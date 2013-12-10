<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for mass-mail vars.
 * 
 * @package massmail  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Email_tpl_vars extends Admin 
{
    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Email_tpl_vars
     */
    public function __construct()
	{
		parent::__construct();
		
		// === Check is logged manager === //
		$this->_CheckLogged();	
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Page Titles === //
		$this->page_titles['index'] = language('vars_for_templates');
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
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Show list of available vars.
	 *
	 * @return void
	 */
	public function Index()
	{
		// === Customer TPL === //
		$EMAIL_TPL_CUSTOMER[language('email')] = "{email}";
		$EMAIL_TPL_CUSTOMER[language('name')] = "{name}";
		$EMAIL_TPL_CUSTOMER[language('surname')] = "{surname}";
		$EMAIL_TPL_CUSTOMER[language('phone')] = "{phone}";
		$EMAIL_TPL_CUSTOMER[language('phone2')] = "{phone2}";
		$EMAIL_TPL_CUSTOMER[language('city')] = "{city}";
		$EMAIL_TPL_CUSTOMER[language('address')] = "{address}";
		$EMAIL_TPL_CUSTOMER[language('zip_code')] = "{zip_code}";
		$EMAIL_TPL_CUSTOMER[language('reg_date')] = "{reg_date}";
		
		// === Subscribtion TPL == //
		if(userAccess('subscribers','send')) 
		{
			$EMAIL_TPL_SUBSCRIBERS[language('unsubscribe')] = "{unsubscribe_link}";
		}
		
		// === Orders TPL == //
		if(userAccess('orders','view'))
		{
			$EMAIL_TPL_ORDERS[language('order_total')] = "{order_total}";
			$EMAIL_TPL_ORDERS[language('order_content')] = "{order_content}";
		}
		
		// === Settings TPL === //
		$EMAIL_TPL_SETTINGS[language('site_title')] = "{site_title}";
		$EMAIL_TPL_SETTINGS[language('site_email')] = "{site_email}";
		
		// === OTHER TPL == //
		$EMAIL_TPL_OTHER[language('site_url')] = "{site_url}";
		$EMAIL_TPL_OTHER[language('date')] = "{now_date}";
		
		$data['EMAIL_TPL_CUSTOMER'] = $EMAIL_TPL_CUSTOMER;
		$data['EMAIL_TPL_SUBSCRIBERS'] = @$EMAIL_TPL_SUBSCRIBERS;
		$data['EMAIL_TPL_ORDERS'] = @$EMAIL_TPL_ORDERS;
		$data['EMAIL_TPL_SETTINGS'] = $EMAIL_TPL_SETTINGS;
		$data['EMAIL_TPL_OTHER'] = $EMAIL_TPL_OTHER;
		
		$data['tpl_page'] = $this->_getController().'/index';
		parent::_OnOutput($data);
	}
}