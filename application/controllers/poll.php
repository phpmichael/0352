<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for poll.
 * 
 * @package poll  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Poll extends Front 
{
    /**
     * Init required models, helpers, language sections, pages' titles, css files etc.
     *
     * @return \Poll
     */
	public function __construct()
	{
		parent::__construct();
		
		// === Load Models === //
		$this->load->model('poll_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','poll'));
		
		// === Labels === //
		$this->fields_titles['title'] = language('title');
		$this->fields_titles['date'] = language('date');
		$this->fields_titles['answer'] = language('answer');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('poll_list');
		$this->page_titles['results'] = language('poll_results');
		//default page title
		$this->_setDefaultPageTitle();
		
		$this->load->helper('text');
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// === Custom validation : Start === //	
	/**
	 * Validate poll answered: check if integer.
	 *
	 * @param integer $answer
	 * @return bool
	 */
	public function _valid_poll_answer($answer)
	{
	    if( abs(intval($answer)) != $answer ) return FALSE;
		
		return TRUE;
	}
	// === Custom validation : End === //

	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //


	/**
	 * Show active polls.
	 * Not sure if this still required.
	 * 
	 * @return void
	 */
	public function Index()
	{
        $data['poll_records'] = $this->poll_model->get("active = 1",'date','DESC');

		parent::_OnOutput($data);
	}
	
	/**
	 * Check if customer already voted if no than store customer's vote.
	 * 
	 * @param integer $poll_id
	 * @return void
	 */
	public function Submit($poll_id)
	{
		$customer_id = $this->session->userdata('customer_id');
		
		$this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'answer', 
                     'label'   => parent::_getFieldTitle('answer'), 
                     'rules'   => 'callback__valid_poll_answer'
                  ),
            );

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() != FALSE)
		{
			//protect from vote twice
		    if( !$this->poll_model->isVoted($poll_id,$customer_id) )
			{
    		    $answer_id = intval(@$_POST['answer']);
        		$this->poll_model->storeAnswer($poll_id,$answer_id,$customer_id);
        		
        		die(json_encode(array('result'=>'success','message'=>language('thank_you_for_your_vote'))));    
			}	
			else 
			{
			     die(json_encode(array('result'=>'error','message'=>language('you_already_voted'))));    
			}
		}
		else 
		{
		    die(json_encode(array('result'=>'error','message'=>language('validation_error'))));    
		}
	}
	
	/**
	 * Show poll results.
	 *
	 * @param integer $poll_id
	 * @return void
	 */
	public function Results($poll_id)
	{
        $this->load->helper('poll');
	    $data['poll_id'] = $poll_id;
	    load_theme_view('poll/results',$data);
	}

}