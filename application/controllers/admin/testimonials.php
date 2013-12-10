<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for testimonials.
 * 
 * @package testimonials  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Testimonials extends Admin 
{
	//name of table
    protected $c_table = "testimonials";

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Testimonials
     */
	public function __construct()
	{
		parent::__construct();
		
		// === Check is logged manager === //
		$this->_CheckLogged();	
		
		// === Load Models === //
		$this->load->model('testimonials_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Labels === //
		$this->fields_titles['name'] = language('name');
		$this->fields_titles['link'] = language('link');
		$this->fields_titles['content'] = language('testimonial');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('testimonials');
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
                     'rules'   => 'trim|required|min_length[3]|max_length[255]|xss_clean'
                  ),
               array(
                     'field'   => 'link', 
                     'label'   => parent::_getFieldTitle('link'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'content', 
                     'label'   => parent::_getFieldTitle('content'), 
                     'rules'   => 'trim|xss_clean'
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
			
			$this->testimonials_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI());
		}
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Add testimonial.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit testimonial.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->testimonials_model->getOneById($id);
		
		$this->_processInsert($record);
	}
	
}