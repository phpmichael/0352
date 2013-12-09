<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for JavaScript with PHP.
 * 
 * @package app_js  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class App_js extends Front 
{
	/**
	 * Init required models, helpers, language sections, pages' titles, css files etc.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front'));
	}
    
    
    // +++++++++++++ INNER METHODS +++++++++++++++ //


	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //
    
	
    public function config()
    {
        header("Content-type: text/javascript");
        
        // === VIEW === //
		load_theme_view($this->_getFolder()."app_js/config",array());
    }

}