<?php
require_once(APPPATH.'controllers/abstract/front_fb.php');

/** 
 * This is controller for instructors.
 * Project: kurort-bukovel
 * 
 * @package instructors  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Instructors extends Front_fb
{
    protected $process_form_html_id = "instructors"; 
    
    protected $actions_store_redirect = array( 'edit_my_profile' => 'view_my_profile' );

	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Edit logged instructor's profile.
	 *
	 */
	public function Edit_My_Profile()
	{
		$this->_CheckLogged();
		
		$this->_processInsert($this->instructors_model->getMyPostId());
	}
	
	/**
	 * View logged instructor's profile.
	 *
	 */
	public function View_My_Profile()
	{
		$this->_CheckLogged();
		
		$this->_processInsert($this->instructors_model->getMyPostId(),'view');
	}
	
	/**
	 * View instructor's profile.
	 *
	 */
	public function View_Profile($data_key)
	{
		$this->View($data_key);
	}

}