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
     * @return \App_js
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

    /**
     * Generate config file for javascript.
     */
    public function config()
    {
        $expires = gmdate('D, d M Y H:i:s ', strtotime('now +1 hour')) . 'GMT';
        header("Expires: {$expires}");
        header("Content-type: application/javascript; charset=utf-8");
        
        // === VIEW === //
		load_theme_view($this->_getFolder()."app_js/config",array());
    }

}