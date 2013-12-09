<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for request a call form.
 * 
 * @package addtional  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Request_call extends Front 
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
		$this->lang_model->init(array('label','front','request_call'));
		
		// === Labels === //
		$this->fields_titles['name'] = language('name');
		$this->fields_titles['phone'] = language('phone');
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //


	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //
	
	/**
	 * Show form.
	 * 
	 * @return void
	 */
	public function Index()
	{
		load_theme_view($this->controller.'/'.$this->method);
	}
	
	/**
	 * Validate form and send email to admin.
	 * 
	 * @return void
	 */
	public function Send()
	{
		$this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'name', 
                     'label'   => parent::_getFieldTitle('name'), 
                     'rules'   => 'trim|required|xss_clean'
                  ),
               array(
                     'field'   => 'phone', 
                     'label'   => parent::_getFieldTitle('phone'), 
                     'rules'   => 'trim|required|xss_clean'
                  )
            );

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else {
			//mailing
    		$this->load->model('auto_responders_model');
			$this->auto_responders_model->send(5,$this->settings_model['site_email'],$_POST);
    		
			echo "success";
		}
		exit;
	}
}