<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is currency exchange controller.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Currency extends Front 
{
    /**
     * Init required models, helpers, language sections, pages' titles, css files etc.
     *
     * @return \Currency
     */
	public function __construct()
	{
		parent::__construct();
		
		// === Load Models === //
		$this->load->model('currency_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front'));
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// ============= ACTION METHODS ================ //
	
	/**
	 * Change currency.
	 * 
	 * @return void
	 */
	public function Set()
	{
		$this->currency_model->setCurrencyCode($this->input->post('currency_code'));
		
		redirect(base_url().$this->_getBaseURL());
	}
	
}