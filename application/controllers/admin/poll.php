<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for poll.
 * 
 * @package poll  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Poll extends Admin 
{
	//name of table
    protected $c_table = "poll_list";
	//show records per page
    protected $per_page = 10;

    /**
    * Init models, set pages' titles, fields' titles, set languages' sections.
    * 
    * @return void
    */
	public function __construct()
	{
		parent::__construct();

		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('poll_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin','poll'));
		
		// === Labels === //
		$this->fields_titles['title'] = language('title');
		$this->fields_titles['date'] = language('date');
		$this->fields_titles['answer'] = language('answer');
		$this->fields_titles['active'] = language('active');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('poll_list');
		$this->page_titles['add'] = language('add');
		$this->page_titles['edit'] = language('edit');
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
	 * Check if poll can be activated.
	 * 
	 * @param integer $active
	 * @param integer $poll_id
	 * @return bool
	 */
	public function _poll_could_be_active($active,$poll_id)
	{
		//if not activated then it is ok
	    if(!$active) return TRUE;
		
		//new poll could not be activated
		if(!$poll_id) return FALSE;
	    
		$total_poll_answers = $this->poll_model->getTotalPollAnswers($poll_id);
		
		//check if poll has minimal 2 answers
		return ($total_poll_answers>=2);
	}
	// === Custom validation : End === //

	/**
	 * Validate and insert or update poll.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsert(array $record=array())
	{
		$poll_id = isset($record['id']) ? $record['id'] : 0;
	    
	    $this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'active', 
                     'label'   => parent::_getFieldTitle('active'), 
                     'rules'   => 'required|is_natural|callback__poll_could_be_active['.$poll_id.']'
                  )
            );
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "title[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('title')." ({$lang_code})", 
                     'rules'   => 'trim|required|min_length[5]|max_length[255]|xss_clean'
                  );
        }

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			$record['tpl_page'] = $this->_getController().'/add';
		    parent::_OnOutput($record);
		}
		else
		{
			$post = array_merge($record,$_POST);
			
			$this->poll_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI());
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
		
		$configValidation = array(); 
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "answer[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('answer')." ({$lang_code})", 
                     'rules'   => 'trim|required|max_length[255]'
                  );
        }

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			$record['tpl_page'] = $this->_getController().'/answers_add';
		    parent::_OnOutput($record);
		}
		else
		{
			$post = array_merge($record,$_POST);
			
			$this->poll_model->insertOrUpdateAnswer($post);
			
			redirect($this->_getBaseURI()."/answers_list/".$record['poll_id']);
		}
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

    /**
	 * Add poll.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit poll.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->poll_model->getOneById($id);
		
		$this->_processInsert($record);
	}
	
	/**
	 * Delete selected polls.
	 * Overrides parent method.
	 * 
	 * @return void
	 */
	public function Delete_Selected()
	{
		$this->poll_model->DeleteSelectedPoll(@$_POST['check']);

		redirect($this->_getBaseURI());
	}
	
	/**
	 * Show answers list for poll.
	 * 
	 * @param integer $poll_id
	 * @return void
	 */
	public function Answers_List($poll_id)
	{
		$this->justCurrentLang = TRUE;
	    
	    $data['answers'] = $this->poll_model->getAnswers($poll_id);
		
		$data['tpl_page'] = $this->_getController().'/'.$this->_getMethod();
		parent::_OnOutput($data);
	}
	
	/**
	 * Add answer for poll.
	 * 
	 * @param integer $poll_id
	 * @return void
	 */
	public function Answers_Add($poll_id)
	{
		$record['poll_id'] = $poll_id;
		$this->_processInsertAnswer($record);
	}
	
	/**
	 * Edit answer for poll.
	 * Params $mm and $nn not used. Just link should have defined format.
	 * 
	 * @param integer $poll_id
	 * @param mixed $mm
	 * @param mixed $nn
	 * @param integer $answer_id
	 * @return void
	 */
	public function Answers_Edit($poll_id,$mm,$nn,$answer_id)
	{
		// === GET RECORD === //
		$record = $this->poll_model->getAnswerById($answer_id);
		$record['poll_id'] = $poll_id;
		
		$this->_processInsertAnswer($record);
	}
	
	/**
	 * Delete selected answers.
	 * 
	 * @param integer $poll_id
	 * @return void
	 */
	public function Delete_Selected_Answers($poll_id)
	{
		$this->poll_model->DeleteSelectedAnswers(@$_POST['check']);
		
		redirect($this->_getBaseURI()."/answers_list/$poll_id");
	}

}