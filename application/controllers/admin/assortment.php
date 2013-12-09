<?php
require_once(APPPATH.'controllers/abstract/admin_fb.php');

/** 
 * This is admin controller for assortment.
 * 
 * @package assortment  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Assortment extends Admin_fb 
{
    protected $process_form_html_id = "assortment"; 
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	/**
	 * Validate and insert or update data.
	 * 
	 * @param char(16) $data_key
	 * @return void
	 */
	protected function _processInsert($data_key=FALSE,$form_mode='edit')
	{
		if($data_key) $this->load->vars($this->assortment_model->getOneById($data_key));
	    
		parent::_processInsert($data_key,$form_mode);
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
}