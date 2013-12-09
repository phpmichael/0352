<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for discount coupons.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Discount_coupons extends Admin 
{
	//name of table
    protected $c_table = "discount_coupons";
	
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
		$this->load->model('discount_coupons_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin','discounts'));
		
		// === Labels === //
		$this->fields_titles['percents'] = language('percents');
		$this->fields_titles['amount'] = language('amount');
		$this->fields_titles['code'] = language('code');
		$this->fields_titles['possible_uses'] = language('number_of_possible_uses');
		$this->fields_titles['used'] = language('used');
		$this->fields_titles['coupon_format'] = language('coupon_format');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('discount_coupons');
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
                     'field'   => 'percents', 
                     'label'   => parent::_getFieldTitle('percents'), 
                     'rules'   => 'trim|required|integer'
                  ),
               array(
                     'field'   => 'amount', 
                     'label'   => parent::_getFieldTitle('amount'), 
                     'rules'   => 'trim|required|integer'
                  ),
               array(
                     'field'   => 'possible_uses', 
                     'label'   => parent::_getFieldTitle('possible_uses'), 
                     'rules'   => 'trim|required|integer'
                  ),
                array(
                     'field'   => 'coupon_format', 
                     'label'   => parent::_getFieldTitle('coupon_format'), 
                     'rules'   => 'alpha_numeric'
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
			
			$this->discount_coupons_model->insertOrUpdate($post);
			
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
		$record = $this->discount_coupons_model->getOneById($id);
		
		$this->_processInsert($record);
	}
	
}