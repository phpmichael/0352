<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for managers.
 * 
 * @package managers  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Managers extends Admin 
{
    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Managers
     */
	public function __construct()
	{
		parent::__construct();
		
		// === Check is logged manager === //
		if( $this->method != 'signin' ) $this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('managers_model');
		$this->load->model('groups_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Labels === //
		$this->fields_titles['email'] = language('email');
		$this->fields_titles['password'] = language('password');
		
		// === Page Titles === //
		$this->page_titles['signin'] = language('sign_in_admin_panel');
		//default page title
		$this->_setDefaultPageTitle();
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// === Custom validation : Start === //	
	/**
	 * Validate login.
	 * 
	 * @param string $password
	 * @param string $email
	 * @return bool
	 */
	public function _valid_login($password,$email)
	{
		return (bool)$this->managers_model->checkLogin($email,$password);
	}
	// === Custom validation : End === //
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	
	/**
	 * Show login form and login manager in admin panel.
	 * 
	 * @return void
	 */
	public function SignIn()
	{
		if($this->_is_logged())
		{
			redirect($this->_getBaseURL().'dashboard');
		}
		
		$this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'email', 
                     'label'   => parent::_getFieldTitle('email'), 
                     'rules'   => 'trim|required|valid_email'
                  ),
               array(
                     'field'   => 'password', 
                     'label'   => parent::_getFieldTitle('password'), 
                     'rules'   => 'trim|required|md5|callback__valid_login['.$this->input->post('email').']'
                  ),
            );

		$this->form_validation->set_rules($configValidation);

		if ($this->form_validation->run() == FALSE)
		{
			$data['tpl_page'] = $this->_getController().'/login';
		    parent::_OnOutput();
		}
		else
		{
			$manager = $this->managers_model->checkLogin($this->input->post('email'),$this->input->post('password'));
			
			$this->managers_model->setLogined($manager);

			redirect($this->_getBaseURL().'dashboard');
		}

		
	}
	
	/**
	 * Logout manager.
	 * 
	 * @return void
	 */
	public function SignOut()
	{
		$this->managers_model->setLogout();
		
		redirect($this->_getBaseURI().'/signin');
	}
	
}