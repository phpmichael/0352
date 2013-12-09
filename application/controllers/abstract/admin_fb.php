<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is abstract admin controller for part buit with formbuilder.
 * 
 * @package formbuilder  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Admin_fb extends Admin 
{
    protected $process_form_html_id; 
    protected $process_form_id; 
    
    //main formbuilder model
	protected $model_name = 'formbuilder_model';
	//special model for process form data
	protected $process_form_model;
	
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
		$this->load->model($this->model_name);
		$this->model = $this->{$this->model_name};
		
		// === Load Helpers === //
		$this->load->helper('formbuilder');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		//ID of form
		$this->process_form_id = $this->model->getFormIdByHtmlId($this->process_form_html_id);
		
		//name of table
		$this->c_table = $this->model->getFormStoreTable($this->process_form_id);
		
		//load model for process form data
		$this->load->model($this->c_table.'_model');
		$this->process_form_model = $this->{$this->c_table.'_model'};
		
		// === Labels === //
		$this->fields_titles = $this->model->getFieldsList($this->process_form_id);
		
		// === Default Sort By === //
		$this->segment_orderby = $this->uri->segment($this->_getSegmentsOffset()+3,'pub_date');
		
		// === Formbuilder CSS === //
		$this->css_files[] = 'css/fb/styles.css';
		$this->css_files[] = $this->_getTheme().'fb/styles.css';
		
		// === Page Titles === //
		$this->page_titles['index'] = $this->model->getFormTitle($this->process_form_id);
		$this->page_titles['add'] = language('add');
		$this->page_titles['edit'] = language('edit');
		$this->page_titles['view'] = language('view');
		//default page title
		$this->_setDefaultPageTitle();
	}
	
	/**
	 * Return ID of processing form.
	 *
	 * @return integer
	 */
	public function _getProcessFormId()
	{
	    return $this->process_form_id;
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	/**
	 * Validate and insert or update data.
	 * 
	 * @param char(16) $data_key
	 * @return void
	 */
	protected function _processInsert($data_key=FALSE,$form_mode='edit')
	{
		if($this->input->post())
		{
		    $data_key = $this->model->storeForm($this->input->post(),$this->process_form_id,$data_key);
		    
		    if($data_key) redirect($this->_getBaseURI());
		    else $this->model->setFormData($this->input->post());
		}
		
		$this->formbuilder_model->setFormMode($form_mode);
		
	    $data['tpl_page'] = 'admin_fb/build';
	    $data['form_id'] = $this->process_form_id;
	    $data['data_key'] = $data_key;
	    
		parent::_OnOutput($data);
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Add Item.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit Item.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$data_key = $this->segment_item;
		
		$this->_processInsert($data_key);
	}
	
	/**
	 * View Item.
	 * 
	 * @return void
	 */
	public function View()
	{
		$data_key = $this->segment_item;
		
		$this->_processInsert($data_key,'view');
	}
	
}