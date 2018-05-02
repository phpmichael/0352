<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for books authors.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2018
 * @access public
 */
class Books_authors extends Admin
{
	//name of table
    protected $c_table = "books_authors";
	//show records per page
    protected $per_page = 15;

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Books_authors
     */
	public function __construct()
	{
		parent::__construct();
		
		// === Check is logged manager === //
		$this->_CheckLogged();	
		
		// === Load Models === //
		$this->load->model('books_authors_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Labels === //
		$this->fields_titles['name'] = language('thing_name');
		$this->fields_titles['description'] = language('description');

		// === Page Titles === //
		$this->page_titles['index'] = language('authors');
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
		
		$configValidation = array(
               array(
                     'field'   => 'name', 
                     'label'   => parent::_getFieldTitle('name'), 
                     'rules'   => 'trim|required|min_length[2]|max_length[150]|xss_clean'
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
			
			$this->books_authors_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI());
		}
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Add manufacturer.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit manufacturer.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->books_authors_model->getOneById($id);
		
		$this->_processInsert($record);
	}
	
}