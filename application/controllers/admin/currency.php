<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for currency.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Currency extends Admin 
{
	//name of table
    protected $c_table = "currency";
	//show records per page
    protected $per_page = 999;

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Currency
     */
	public function __construct()
	{
		parent::__construct();
		
		// === Check is logged manager === //
		$this->_CheckLogged();	
		
		// === Load Models === //
		$this->load->model('currency_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin','currency'));
		
		// === Labels === //
		$this->fields_titles['code'] = language('code');
		$this->fields_titles['title'] = language('thing_name');
		$this->fields_titles['exchange_rate'] = language('exchange_rate');
		$this->fields_titles['symbol'] = language('symbol');
		$this->fields_titles['symbol_location'] = language('symbol_location');
		$this->fields_titles['default'] = language('default_currency');
		$this->fields_titles['enabled'] = language('enabled');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('currency');
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
                     'field'   => 'code', 
                     'label'   => parent::_getFieldTitle('code'), 
                     'rules'   => 'trim|required|alpha|exact_length[3]'
                  ),
               array(
                     'field'   => 'title', 
                     'label'   => parent::_getFieldTitle('title'), 
                     'rules'   => 'trim|required|max_length[20]|xss_clean'
                  ),
               array(
                     'field'   => 'exchange_rate', 
                     'label'   => parent::_getFieldTitle('exchange_rate'), 
                     'rules'   => 'trim|required|numeric'
                  ),
               array(
                     'field'   => 'symbol', 
                     'label'   => parent::_getFieldTitle('symbol'), 
                     'rules'   => 'trim|required|max_length[10]|xss_clean'
                  ),
               array(
                     'field'   => 'symbol_location', 
                     'label'   => parent::_getFieldTitle('symbol_location'), 
                     'rules'   => 'trim|required|xss_clean'
                  ),
               array(
                     'field'   => 'default', 
                     'label'   => parent::_getFieldTitle('default'), 
                     'rules'   => 'trim|required|exact_length[1]|numeric'
                  ),
               array(
                     'field'   => 'enabled', 
                     'label'   => parent::_getFieldTitle('enabled'), 
                     'rules'   => 'trim|required|exact_length[1]|numeric'
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
			
			$this->currency_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI());
		}
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Add currency.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit currency.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->currency_model->getOneById($id);
		
		$this->_processInsert($record);
	}
	
}