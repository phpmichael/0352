<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for dashboard.
 * 
 * @package dashboard  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Dashboard extends Admin 
{
	//name of table
	protected $c_table = "dashboard";
	
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
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin','dashboard'));
		
		// === Init Models === //
		$this->load->model(array('groups_model','dashboard_model','filters_model'));
		
		// === Init Helpers === //
		$this->load->helpers('comments');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('dashboard');
		//default page title
		$this->_setDefaultPageTitle();
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	/**
	 * Build rigth top admin menu.
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
	 * Show dashboard.
	 *
	 */
	public function Index()
	{
		$data['widgets'] = $this->dashboard_model->getAvailableWidgets();
		
		parent::_OnOutput($data);
	}
}