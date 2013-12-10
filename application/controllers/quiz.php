<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for quizes.
 * 
 * @package quiz  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Quiz extends Front 
{
    /**
     * Init required models, helpers, language sections, pages' titles, css files etc.
     *
     * @return \Quiz
     */
    public function __construct()
	{
		parent::__construct();

		// === Check is logged customer === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('quiz_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','quiz'));
		
		// === Labels === //
		$this->fields_titles['name'] = language('thing_name');
		$this->fields_titles['description'] = language('description');
		$this->fields_titles['date'] = language('date');
		$this->fields_titles['question'] = language('question');
		$this->fields_titles['answer'] = language('answer');
		$this->fields_titles['correct'] = language('correct');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('quiz_list');
		$this->page_titles['my'] = language('my_quiz_results');
		$this->page_titles['go'] = language('quiz');
		$this->page_titles['result'] = language('quiz_result');
		$this->page_titles['rating'] = language('quiz_rating');
		//default page title
		$this->_setDefaultPageTitle();
		
		// === CSS Styles === //
		$this->css_files = array(
		      $this->_getTheme().'css/quiz.css'
		);
		
		$this->load->helper('text');
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// === Custom validation : Start === //	
	/**
	 * Validate customer's answers (checkboxes).
	 * 
	 * @param array $answers
	 * @return bool
	 */
	public function _valid_quiz_answers($answers)
	{
		if(empty($answers)) return FALSE;
		
		foreach ($answers as $answer)
		{
			if( abs(intval($answer)) != $answer ) return FALSE;
		}
		
		return TRUE;
	}
	
	/**
	 * Validate customer's answer (radio).
	 * 
	 * @param integer $answer
	 * @return bool
	 */
	public function _valid_quiz_answer($answer)
	{
	    if( abs(intval($answer)) != $answer ) return FALSE;
		
		return TRUE;
	}
	// === Custom validation : End === //

	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //

    /**
	 * Show list with all active quizes.
	 * 
	 * @return void
	 */
	public function Index()
	{
        $data['quiz_records'] = $this->quiz_model->get("active = 1",'date','DESC');

		parent::_OnOutput($data);
	}
	
	/**
	 * Show list with customer's quizes.
	 * 
	 * @return void
	 */
	public function My()
	{
        $customer_id = $this->session->userdata('customer_id');
		
		$data['quiz_records'] = $this->quiz_model->getCustomerQuizArchives($customer_id);
		$not_finished_quiz_records = $this->quiz_model->getCustomerNotFinishedQuizList($customer_id);
		
		$data['quiz_records'] = array_merge($not_finished_quiz_records,$data['quiz_records']);
		
		// === Currenr Location === //
		$data['current_location_arr'] =
		array(
			$this->_getBaseURI()."/index" => lowercase($this->_getPageTitle('index')),
			$this->_getBaseURI()."/my" => lowercase($this->_getPageTitle('my')),
		);
		//dump($data['quiz_records']);exit;
		parent::_OnOutput($data);
	}
	
	/**
	 * Start quiz.
	 * 
	 * @param integer $quiz_id
	 * @return void
	 */
	public function Start($quiz_id)
	{
		redirect($this->_getBaseURI().'/go/'.$quiz_id);
	}
	
	/**
	 * Generate and show question with answers options.  
	 * 
	 * @param integer $quiz_id
	 * @return void
	 */
	public function Go($quiz_id)
	{
	    $customer_id = $this->session->userdata('customer_id');
		
		$data['amount_answered_questions'] = $this->quiz_model->getAmountCustomerAnsweredQuestions($quiz_id,$customer_id);
		$data['total_questions'] = $this->quiz_model->getRequiredAmountQuestions($quiz_id);
		
		//if customer answered enough - then finish quiz
		if($this->quiz_model->isQuizFinished($quiz_id,$customer_id))
		{
			redirect($this->_getBaseURI().'/finish/'.$quiz_id);
		}
		
		$data['quiz'] = $this->quiz_model->getNextQuestion($quiz_id,$customer_id);
		
		//if no more time for question
		if($data['quiz']['question']['time']<=0)
		{
		    $this->quiz_model->storeNoAnswer($quiz_id,$customer_id,$data['quiz']['question']['id']);
		    redirect($this->_getBaseURI().'/go/'.$quiz_id);
		}
 		
 		// === Currenr Location === //
		$data['current_location_arr'] =
		array(
			$this->_getBaseURI()."/index" => lowercase($this->_getPageTitle('index')),
			$this->_getBaseURI()."/my" => lowercase($this->_getPageTitle('my')),
		);
		
		parent::_OnOutput($data);
	}
	
	/**
	 * Validate and store customer's answer, than redirect to next question.
	 * 
	 * @param integer $quiz_id
	 * @param integer $question_id
	 * @return void
	 */
	public function Submit($quiz_id,$question_id)
	{
		$customer_id = $this->session->userdata('customer_id');
		
		$this->load->library('form_validation');
		
		//if custom answer from input
		if(isset($_POST['custom_answer']))
		{
			$configValidation = array(
               array(
                     'field'   => 'custom_answer', 
                     'label'   => parent::_getFieldTitle('answer'), 
                     'rules'   => 'trim|required|xss_clean'
                  ),
            );
		}
		//if checkboxes answers
		elseif(!empty($_POST['answers']))
		{
			$configValidation = array(
               array(
                     'field'   => 'answers[]', 
                     'label'   => parent::_getFieldTitle('answer'), 
                     'rules'   => 'callback__valid_quiz_answers'
                  ),
            );
		}
		//if readiobox
		else 
		{
			$configValidation = array(
               array(
                     'field'   => 'answer', 
                     'label'   => parent::_getFieldTitle('answer'), 
                     'rules'   => 'callback__valid_quiz_answer'
                  ),
            );
		}

		$this->form_validation->set_rules($configValidation);
			
		//if answered - store it and remove current question from session
		if ($this->form_validation->run() != FALSE)
		{
			//protect from answer on question twice
		    if( !$this->quiz_model->questionAnswered($quiz_id,$customer_id,$question_id) )
			{
    		    //check if user answered in time
			    if( $this->quiz_model->ifAnsweredInTime($quiz_id,$customer_id,$question_id) )
    		    {
    			    if( isset($_POST['custom_answer']) )
        			{
        				$custom_answer = $_POST['custom_answer'];
        				$this->quiz_model->storeCustomAnswer($quiz_id,$customer_id,$question_id,$custom_answer);
        			}
        			elseif( !empty($_POST['answers']) )
        			{
        				$answers = $_POST['answers'];
        				foreach ($answers as $answer_id=>$selected)
        				{
        					$this->quiz_model->storeAnswer($quiz_id,$customer_id,$question_id,$answer_id);
        				}
        			}
        			else
        			{
        				$answer_id = intval(@$_POST['answer']);
        				$this->quiz_model->storeAnswer($quiz_id,$customer_id,$question_id,$answer_id);
        			}
    		    }
    		    else 
    		    {
    		        $this->quiz_model->storeNoAnswer($quiz_id,$customer_id,$question_id);
    		    }
			}	
		}
		
		redirect($this->_getBaseURI().'/go/'.$quiz_id);
	}
	
	/**
	 * Finish quiz and add it to archives.
	 * 
	 * @param integer $quiz_id
	 * @return void
	 */
	public function Finish($quiz_id)
	{
	    $customer_id = $this->session->userdata('customer_id');
	    
	    //check if customer answered enough for finish quiz
		if( !$this->quiz_model->isQuizFinished($quiz_id,$customer_id) )
		{
			redirect($this->_getBaseURI().'/my');
		}
		
		//get quiz info
		$data['quiz'] = $this->quiz_model->getOneById($quiz_id);
		$data['quiz_questions'] = $this->quiz_model->getFinishedQuizQuestions($quiz_id);
		$result = $this->quiz_model->checkIfCorrectAnswers($quiz_id,$customer_id);
		$scores = $result['scores'];
		$data['correctArr'] = $result['correctArr'];
		$data['answers'] = $result['answers'];
		$data['correct_answers'] = $result['correct_answers'];
		$data['customer_answers'] = $result['customer_answers'];
		
		//save quiz data in archive
		$archive_id = $this->quiz_model->addToArchive($customer_id,$quiz_id,$scores,$data);
		
		redirect($this->_getBaseURI().'/result/'.$archive_id);
	}
	
	/**
	 * Show results with scores and what answers were correct and what no.
	 * 
	 * @param integer $archive_id
	 * @return void
	 */
	public function Result($archive_id)
	{
	    $customer_id = $this->session->userdata('customer_id');
	    
	    $data = $this->quiz_model->getCustomerQuizArchive($customer_id,$archive_id);
	    //dump($data);EXIT;
	    if(empty($data)) show_404($this->_getBaseURI().'/'.$this->_getMethod().'/'.$archive_id);
	    
	    // === Currenr Location === //
		$data['current_location_arr'] =
		array(
			$this->_getBaseURI()."/index" => lowercase($this->_getPageTitle('index')),
			$this->_getBaseURI()."/my" => lowercase($this->_getPageTitle('my')),
			$this->_getBaseURI()."/result/{$archive_id}" => lowercase($this->_getPageTitle())
		);
		
		parent::_OnOutput($data);
	}
	
	/**
	 * Show top customers' results.
	 * 
	 * @return void
	 */
	public function Rating()
	{
	    $quiz_id = intval(@$_POST['quiz_id']);
	    
	    $data['quiz_id'] = $quiz_id;
	    
	    $data['quiz_list'] = $this->quiz_model->getQuizList(array('active'=>1));
	    
	    if($quiz_id) $data['records'] = $this->quiz_model->getTopRatedList($quiz_id);
	    
	    // === Current Location === //
		$data['current_location_arr'] =
		array(
			$this->_getBaseURI()."/index" => lowercase($this->_getPageTitle('index')),
			$this->_getBaseURI()."/my" => lowercase($this->_getPageTitle('my')),
			$this->_getBaseURI()."/rating" => lowercase($this->_getPageTitle())
		);
		
		parent::_OnOutput($data);
	}

}