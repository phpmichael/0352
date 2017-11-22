<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for quiz.
 * 
 * @package quiz  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Quiz extends Admin 
{
	//name of quizes table
	protected $c_table = "quiz_list";
	//show records per page
	protected $per_page = 10;

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Quiz
     */
	public function __construct()
	{
		parent::__construct();

		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('quiz_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin','quiz'));
		
		// === Labels === //
		$this->fields_titles['name'] = language('thing_name');
		$this->fields_titles['description'] = language('description');
		$this->fields_titles['date'] = language('date');
		$this->fields_titles['question'] = language('question');
		$this->fields_titles['code'] = 'Code';
		$this->fields_titles['answer'] = language('answer');
		$this->fields_titles['correct'] = language('correct');
		$this->fields_titles['active'] = language('active');
		$this->fields_titles['questions_count'] = language('questions_count');
		$this->fields_titles['correct_count'] = language('correct_answered_count');
		$this->fields_titles['time'] = language('minutes');
		$this->fields_titles['connected_answer'] = 'Connected Answer';

		// === Page Titles === //
		$this->page_titles['index'] = language('quiz_list');
		$this->page_titles['add'] = language('add');
		$this->page_titles['edit'] = language('edit');
		$this->page_titles['questions_list'] = language('questions_list');
		$this->page_titles['questions_add'] = language('add_question');
		$this->page_titles['questions_edit'] = language('edit_question');
		$this->page_titles['answers_list'] = language('answers_list');
		$this->page_titles['answers_add'] = language('add_answer');
		$this->page_titles['answers_edit'] = language('edit_answer');
		//default page title
		$this->_setDefaultPageTitle();
		
		
		$this->load->helper('text');
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// === Custom validation : Start === //	
	/**
	 * Check if quiz can be activated.
	 *
	 * @param integer $active
	 * @param array $params
	 * @return bool
	 */
	public function _quiz_could_be_active($active,$params)
	{
		//if not activated then it is ok
	    if(!$active) return TRUE;
		
		list($quiz_id,$questions_count) = explode(',',$params);
		
		//new quiz could not be activated
		if(!$quiz_id) return FALSE;
	    
		$total_quiz_questions = $this->quiz_model->getTotalQuizQuestions($quiz_id);
		//dump($quiz_id);exit;
		
		//check if quiz has minimal questions count
		return ($total_quiz_questions>=$questions_count);
	}
	
	/**
	 * Check if count of required answers not more than total count
	 *
	 * @param integer $correct_count
	 * @param integer $questions_count
	 * @return bool
	 */
	public function _quiz_correct_answers_not_more_then_total($correct_count,$questions_count)
	{
	    return ($questions_count>=$correct_count);
	}
	// === Custom validation : End === //

	/**
	 * Validate and insert or update quiz.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsert(array $record=array())
	{
		$quiz_id = isset($record['id']) ? $record['id'] : 0;
	    
	    $this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'name', 
                     'label'   => parent::_getFieldTitle('name'), 
                     'rules'   => 'trim|required|min_length[5]|max_length[255]|xss_clean'
                  ),
               array(
                     'field'   => 'questions_count', 
                     'label'   => parent::_getFieldTitle('questions_count'), 
                     'rules'   => 'required|is_natural'
                  ),
               array(
                     'field'   => 'correct_count', 
                     'label'   => parent::_getFieldTitle('correct_count'), 
                     'rules'   => 'required|is_natural|callback__quiz_correct_answers_not_more_then_total['.@$_POST['questions_count'].']'
                  ),
               array(
                     'field'   => 'description', 
                     'label'   => parent::_getFieldTitle('description'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'active', 
                     'label'   => parent::_getFieldTitle('active'), 
                     'rules'   => 'required|is_natural|callback__quiz_could_be_active['.$quiz_id.','.@$_POST['questions_count'].']'
                  )
            );

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			$record['tpl_page'] = $this->_getController().'/add';
		    parent::_OnOutput($record);
		}
		else
		{
			$post = array_merge($record,$_POST);
			
			if(!isset($post['date'])) $post['date'] = date("Y-m-d H:i:s");
			
			$this->quiz_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI());
		}
	}
	
	/**
	 * Validate and insert or update question.
	 *
	 * @param array $record
	 * @return void
	 */
	private function _processInsertQuestion(array $record=array())
	{
		$this->load->library('form_validation');
		
		$configValidation = array(
              array(
                     'field'   => 'time', 
                     'label'   => parent::_getFieldTitle('time'), 
                     'rules'   => 'trim|required|natural'
                  ), 
		      array(
                     'field'   => 'question', 
                     'label'   => parent::_getFieldTitle('question'), 
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'code', 
                     'label'   => parent::_getFieldTitle('code'), 
                     'rules'   => 'trim'
                  )
            );

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			$record['tpl_page'] = $this->_getController().'/questions_add';
		    parent::_OnOutput($record);
		}
		else
		{
			$post = array_merge($record,$_POST);
			
			$this->quiz_model->insertOrUpdateQuestion($post);
			
			redirect($this->_getBaseURI()."/questions_list/".$record['quiz_id']);
		}
	}
	
	/**
	 * Validate and insert or update answer.
	 *
	 * @param array $record
	 * @return void
	 */
	private function _processInsertAnswer(array $record=array())
	{
		$this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'answer', 
                     'label'   => parent::_getFieldTitle('answer'), 
                     'rules'   => 'trim|required|max_length[255]'
                  ),
               array(
                     'field'   => 'correct', 
                     'label'   => parent::_getFieldTitle('correct'), 
                     'rules'   => 'numeric|xss_clean'
                  ),
            );

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			$record['tpl_page'] = $this->_getController().'/answers_add';
		    parent::_OnOutput($record);
		}
		else
		{
			$post = array_merge($record,$_POST);
			
			$this->quiz_model->insertOrUpdateAnswer($post);
			
			redirect($this->_getBaseURI()."/answers_list/".$record['quiz_id'].'/'.$record['question_id']);
		}
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //


	/**
	 * Add quiz.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit quiz.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->quiz_model->getOneById($id);
		
		$this->_processInsert($record);
	}
	
	/**
	 * Delete selected quizes.
	 * Override parent method.
	 * 
	 * @return void
	 */
	public function Delete_Selected($orderby='',$orderseq='',$offset='')
	{
		$this->quiz_model->DeleteSelectedQuiz(@$_POST['check']);

		redirect($this->_getBaseURI());
	}
	
	/**
	 * Show questions list.
	 *
	 * @param integer $quiz_id
	 * @return void
	 */
	public function Questions_List($quiz_id)
	{
		$data['questions'] = $this->quiz_model->getQuestions($quiz_id);
		
		$data['tpl_page'] = $this->_getController().'/'.$this->_getMethod();
		parent::_OnOutput($data);
	}
	
	/**
	 * Add question.
	 *
	 * @param integer $quiz_id
	 * @return void
	 */
	public function Questions_Add($quiz_id)
	{
		$record['quiz_id'] = $quiz_id;
		$record['time'] = 120;
		$this->_processInsertQuestion($record);
	}
	
	/**
	 * Edit question.
	 *
	 * @return void
	 */
	public function Questions_Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->quiz_model->getQuestionById($id);
		
		$this->_processInsertQuestion($record);
	}
	
	/**
	 * Delete selected questions.
	 *
	 * @param integer $quiz_id
	 * @return void
	 */
	public function Delete_Selected_Questions($quiz_id)
	{
		$this->quiz_model->DeleteSelectedQuestions(@$_POST['check']);
		
		redirect($this->_getBaseURI()."/questions_list/$quiz_id");
	}
	
	/**
	 * Show answers list.
	 *
	 * @param integer $quiz_id
	 * @param integer $question_id
	 * @return void
	 */
	public function Answers_List($quiz_id,$question_id)
	{
		$data['answers'] = $this->quiz_model->getAnswers($question_id);
		$data['connected_answers'] = $this->quiz_model->getConnectedAnswers($question_id);

		$data['tpl_page'] = $this->_getController().'/'.$this->_getMethod();
		parent::_OnOutput($data);
	}
	
	/**
	 * Add answer
	 *
	 * @param integer $quiz_id
	 * @param integer $question_id
	 * @return void
	 */
	public function Answers_Add($quiz_id,$question_id)
	{
		$record['quiz_id'] = $quiz_id;
		$record['question_id'] = $question_id;
		$this->_processInsertAnswer($record);
	}
	
	/**
	 * Edit answer.
	 *
	 * @param integer $quiz_id
	 * @param integer $question_id
	 * @param mixed $nn not used
	 * @param integer $answer_id
	 * @return void
	 */
	public function Answers_Edit($quiz_id,$question_id,$nn,$answer_id)
	{
		// === GET RECORD === //
		$record = $this->quiz_model->getAnswerById($answer_id);
		$record['quiz_id'] = $quiz_id;
		
		$this->_processInsertAnswer($record);
	}
	
	/**
	 * Delete selected answers.
	 *
	 * @param integer $quiz_id
	 * @param integer $question_id
	 * @return void
	 */
	public function Delete_Selected_Answers($quiz_id,$question_id)
	{
		$this->quiz_model->DeleteSelectedAnswers(@$_POST['check']);
		
		redirect($this->_getBaseURI()."/answers_list/$quiz_id/$question_id");
	}

}