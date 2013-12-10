<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for F.A.Q.
 * 
 * @package FAQ  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Faq extends Admin 
{
	//name of table
    protected $c_table = "faq";
	//show records per page
	protected $per_page = 15;
	
	/**
    * Init models, set pages' titles, fields' titles, set languages' sections.
    * 
    * @return \Faq
    */
	public function __construct()
	{
		parent::__construct();	
		
		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('faq_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Labels === //
		$this->fields_titles['question'] = language('question');
		$this->fields_titles['answer'] = language('answer');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('faq');
		$this->page_titles['add'] = language('add');
		$this->page_titles['edit'] = language('edit');
		//default page title
		$this->_setDefaultPageTitle();
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	/**
	 * Validate and insert or update data.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsert(array $record=array())
	{
		$this->load->library('form_validation');
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "question[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('question')." ({$lang_code})", 
                     'rules'   => 'trim|required|min_length[5]|max_length[255]|xss_clean'
                  );
                  
            $configValidation[] = array(
                     'field'   => "answer[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('answer')." ({$lang_code})", 
                     'rules'   => 'trim|required|min_length[5]|xss_clean'
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
			
			$this->faq_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI());
		}
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Add FAQ.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit FAQ.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->faq_model->getOneById($id);
		
		$this->_processInsert($record);
	}
	
}