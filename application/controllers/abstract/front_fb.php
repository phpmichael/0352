<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is abstract front controller for part built with formbuilder.
 * 
 * @package formbuilder  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 * @property Formbuilder_model $model
 */
class Front_fb extends Front 
{
    protected $process_form_html_id; 
    protected $process_form_id; 
    
    //main formbuilder model
	protected $model_name = 'formbuilder_model';
	//special model for process form data
	protected $process_form_model;
	
	protected $actions_require_login = array();
	protected $actions_store_redirect = array( 'add' => 'my', 'edit' => 'my' );

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Front_fb
     */
	public function __construct()
	{
		parent::__construct();	
		
		// === Load Models === //
		$this->load->model($this->model_name);
		$this->model = $this->{$this->model_name};
		
		// === Load Helpers === //
		$this->load->helper('formbuilder');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front'));
		
		//ID of form
		$this->process_form_id = $this->model->getFormIdByHtmlId($this->process_form_html_id);
		
		//name of table
		$this->c_table = $this->model->getFormStoreTable($this->process_form_id);
		
		//load model for process form data
		$this->load->model($this->c_table.'_model');
		$this->process_form_model = $this->{$this->c_table.'_model'};
		
		// === Labels === //
		$this->fields_titles = $this->model->getFieldsList($this->process_form_id);
		
		// === Formbuilder CSS === //
		$this->css_files[] = 'css/fb/styles.css';
		$this->css_files[] = $this->_getTheme().'fb/styles.css';
		
		// === Page Titles === //
		$this->page_titles['index'] = $this->formbuilder_model->getFormTitle($this->process_form_id);
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
     * @param bool|string(16) $data_key
     * @param string $form_mode
     * @return void
     */
	protected function _processInsert($data_key=FALSE,$form_mode='edit')
	{
		if($this->input->post())
		{
		    $data_key = $this->model->storeForm($this->input->post(),$this->process_form_id,$data_key);
		    
		    if($data_key) redirect($this->_getBaseURI().'/'.$this->actions_store_redirect[$this->_getMethod()]);
		    else $this->model->setFormData($this->input->post());
		}
		
		$this->formbuilder_model->setFormMode($form_mode);
		
	    $data['form_id'] = $this->process_form_id;
	    $data['data_key'] = $data_key;
	    
		parent::_OnOutput($data);
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Show list.
	 * 
	 * @return void
	 */
	public function Index()
	{
		// === Filter Data === //
		$filter_data = $this->{$this->process_form_html_id."_model"}->getFilterData();
		$this->model->setFormData($filter_data);
		
		// === Posters === //
		$data = $this->{$this->process_form_html_id."_model"}->get("index", $filter_data);
		
		$data = array_merge($data,$filter_data);

		$data['tpl_page'] = $this->_getController()."/list";

		// === Current Location === //
		$current_location_arr =
		array(
			$this->_getBaseURI()=>$this->_getPageTitle()
		);
		
		$data['current_location_arr'] = $current_location_arr;
		
		//generate additional page title
		$this->appendPageTitleForListPages($filter_data,$data);
		
		parent::_OnOutput($data);
	}
	
	public function My()
	{
	    $this->Index();
	}
	
	/**
	 * Add Item.
	 * 
	 * @return void
	 */
	public function Add()
	{
		if( in_array('add',$this->actions_require_login) ) $this->_CheckLogged();
	    $this->_processInsert();
	}
	
	/**
	 * Edit Item.
	 * 
	 * @param string(16) $data_key
	 * @return void
	 */
	public function Edit($data_key)
	{
		if( in_array('edit',$this->actions_require_login) ) $this->_CheckLogged();
	    $this->_processInsert($data_key);
	}
	
	/**
	 * View Item.
	 * 
	 * @param string(16) $data_key
	 * @return void
	 */
	public function View($data_key)
	{
		if( in_array('view',$this->actions_require_login) ) $this->_CheckLogged();
	    $this->_processInsert($data_key,'view');
	}
	
}