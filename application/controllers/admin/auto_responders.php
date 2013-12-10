<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for auto responders.
 * 
 * @package customers  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Auto_Responders extends Admin 
{
	//name of table
    protected $c_table = "auto_responders";

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Auto_Responders
     */
	public function __construct()
	{
		parent::__construct();
		
		// === Check is logged manager === //
		$this->_CheckLogged();	
		
		// === Load Models === //
		$this->load->model('auto_responders_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Labels === //
		$this->fields_titles['subject'] = language('subject');
		$this->fields_titles['message'] = language('message');
		$this->fields_titles['enabled'] = language('enabled');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('auto_responders');
		$this->page_titles['edit'] = language('edit');
		//default page title
		$this->_setDefaultPageTitle();
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	/**
	 * Build right top admin menu.
	 * Overrides parent method.
	 * 
	 * @return string
	 */
	public function _built_right_menu()
	{
		return '';
	}
	
	/**
	 * Validate and insert or update data.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsert(array $record=array())
	{
		$this->load->library('form_validation');
		
		$configValidation = array();
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "subject[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('subject')." ({$lang_code})", 
                     'rules'   => 'trim|required|min_length[5]|max_length[255]|xss_clean'
                  );
                  
            $configValidation[] = array(
                     'field'   => "message[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('message')." ({$lang_code})", 
                     'rules'   => 'trim|required|min_length[3]|xss_clean'
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
			
			$this->auto_responders_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI());
		}
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Edit auto responder.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->auto_responders_model->getOneById($id);
		
		$this->_processInsert($record);
	}
	
}