<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for discounts.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Discounts extends Admin 
{
	//name of table
    protected $c_table = "discounts";
	
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
		$this->load->model('discounts_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin','discounts'));
		
		// === Labels === //
		$this->fields_titles['products_count'] = language('products_count');
		$this->fields_titles['order_amount'] = language('order_amount');
		$this->fields_titles['discount_percent'] = language('discount');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('discounts');
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
                     'field'   => 'products_count', 
                     'label'   => parent::_getFieldTitle('products_count'), 
                     'rules'   => 'trim|required|integer'
                  ),
               array(
                     'field'   => 'order_amount', 
                     'label'   => parent::_getFieldTitle('order_amount'), 
                     'rules'   => 'trim|required|numeric'
                  ),
               array(
                     'field'   => 'discount_percent', 
                     'label'   => parent::_getFieldTitle('discount_percent'), 
                     'rules'   => 'trim|required|numeric'
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
			
			$this->discounts_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI());
		}
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Add discount.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit discount.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->discounts_model->getOneById($id);
		
		$this->_processInsert($record);
	}
	
}