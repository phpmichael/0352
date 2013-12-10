<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for email templates.
 * 
 * @package massmail  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Email_tpls extends Admin 
{
	//name of table
    protected $c_table = 'email_tpl';

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Email_tpls
     */
	public function __construct()
	{
		parent::__construct();

		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('email_tpls_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Labels === //
		$this->fields_titles['name'] = language('thing_name');
		$this->fields_titles['content'] = language('message');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('templates');
		$this->page_titles['add'] = language('add_template');
		$this->page_titles['edit'] = language('edit_template');
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
		
		$configValidation = array(
               array(
                     'field'   => 'name', 
                     'label'   => parent::_getFieldTitle('name'), 
                     'rules'   => 'trim|required|min_length[5]|max_length[255]|xss_clean'
                  ),
               array(
                     'field'   => 'content', 
                     'label'   => parent::_getFieldTitle('content'), 
                     'rules'   => 'trim|required|xss_clean'
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
			
			$this->email_tpls_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI());
		}
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Add email template.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit email template.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->email_tpls_model->getOneById($id);
		
		$this->_processInsert($record);
	}

}