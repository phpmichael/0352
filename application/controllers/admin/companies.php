<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for companies.
 * 
 * @package messageboard  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Companies extends Admin 
{
	//name of table
    protected $c_table = "companies";
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
		$this->load->model('companies_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Labels === //
		$this->fields_titles['category'] = language('category');
		$this->fields_titles['name'] = language('company_name');
		$this->fields_titles['email'] = language('email');
		$this->fields_titles['phone'] = language('phone');
		$this->fields_titles['phone2'] = language('phone2');
		$this->fields_titles['fax'] = language('fax');
		$this->fields_titles['website'] = language('website');
		$this->fields_titles['city'] = language('city');
		$this->fields_titles['region'] = language('city_region');
		$this->fields_titles['address'] = language('address');
		$this->fields_titles['work_time'] = language('company_work_time');
		$this->fields_titles['short_description'] = language('short_description');
		$this->fields_titles['services'] = language('company_services');
		$this->fields_titles['long_description'] = language('detailed_description');
		$this->fields_titles['pub_date'] = language('added_date');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('companies_list');
		$this->page_titles['add'] = language('add_company');
		$this->page_titles['edit'] = language('edit_company');
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
		
		$id = intval(@$record['id']);
		
		$configValidation = array(
               array(
                     'field'   => 'category[]', 
                     'label'   => language('category'), 
                     'rules'   => 'trim|integer|callback__isset_category'
                  ),
				array(
                     'field'   => 'name', 
                     'label'   => parent::_getFieldTitle('name'), 
                     'rules'   => 'trim|required|max_length[255]|callback__unique_field_for_edit[name,'.$id.']|xss_clean'
                  ),
               array(
                     'field'   => 'email', 
                     'label'   => parent::_getFieldTitle('email'), 
                     'rules'   => 'trim|max_length[255]|valid_email|callback__unique_field_for_edit[email,'.$id.']'
                  ),
                array(
                     'field'   => 'phone', 
                     'label'   => parent::_getFieldTitle('phone'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'phone2', 
                     'label'   => parent::_getFieldTitle('phone2'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'fax', 
                     'label'   => parent::_getFieldTitle('fax'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'website', 
                     'label'   => parent::_getFieldTitle('website'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'city', 
                     'label'   => parent::_getFieldTitle('city'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'region', 
                     'label'   => parent::_getFieldTitle('region'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'address', 
                     'label'   => parent::_getFieldTitle('address'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'work_time', 
                     'label'   => parent::_getFieldTitle('work_time'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'short_description', 
                     'label'   => parent::_getFieldTitle('short_description'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'services', 
                     'label'   => parent::_getFieldTitle('services'), 
                     'rules'   => 'trim|xss_clean'
                  ),
                array(
                     'field'   => 'long_description', 
                     'label'   => parent::_getFieldTitle('long_description'), 
                     'rules'   => 'trim'
                  ),
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
			
			$this->companies_model->insertOrUpdate($post,$this->input->post('category'));
			
			redirect($this->_getBaseURI());
		}
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Add company.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit company.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->companies_model->getOneById($id);
		
		$this->_processInsert($record);
	}
	
	/**
	 * Delete company's main image.
	 * 
	 * @return void
	 */
	public function DeleteImage()
	{	
		// === GET ID === //
		$id = $this->segment_item;
		
		$this->companies_model->RemovePostImage($id);
		
		redirect($this->_getBaseURI()."/edit/$this->segment_orderby/".$this->segment_orderseq."/".$this->segment_offset."/".$id);
	}
	
	/**
	 * Delete company's additional image.
	 * 
	 * @return void
	 */
	public function Delete_Additional_Image()
	{	
		// === GET ID === //
		$id = $this->segment_item;
		
		$image_id = $this->uri->segment($this->_getSegmentsOffset()+7);
		
		if(!$image_id) redirect($this->_getBaseURI());
		
		$this->companies_model->RemoveAdditionalImage($image_id);
		
		redirect($this->_getBaseURI()."/edit/$this->segment_orderby/".$this->segment_orderseq."/".$this->segment_offset."/".$id);
	}

}