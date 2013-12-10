<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for contact form.
 * 
 * @package addtional  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Contact_us extends Front 
{
    /**
     * Init required models, helpers, language sections, pages' titles, css files etc.
     *
     * @return \Contact_us
     */
	public function __construct()
	{
		parent::__construct();
		
		// === Load Models === //
		$this->load->model('captcha_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front'));
		
		// === Labels === //
		$this->fields_titles['name'] = language('your_name');
		$this->fields_titles['email'] = language('your_email');
		$this->fields_titles['message'] = language('message');
		$this->fields_titles['captcha'] = language('captcha');
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// ============= ACTION METHODS ================ //
	
	/**
	 * Show form with captcha.
	 * 
	 * @return void
	 */
	public function Index()
	{
		// === CAPTCHA === //
		$data["cap_img"] = $this->captcha_model->make();
		
		parent::_OnOutput($data);
	}
	
	/**
	 * Validate form and send email to admin.
	 * 
	 * @return void
	 */
	public function Send()
	{
		// Post
		//if($_POST['post']) parse_str($_POST['post'],$_POST);
		
		$this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'captcha', 
                     'label'   => parent::_getFieldTitle('captcha'), 
                     'rules'   => 'trim|required|callback__valid_captcha'
                  ),
               array(
                     'field'   => 'name', 
                     'label'   => parent::_getFieldTitle('name'), 
                     'rules'   => 'trim|required|xss_clean'
                  ),
               array(
                     'field'   => 'email', 
                     'label'   => parent::_getFieldTitle('email'), 
                     'rules'   => 'trim|required|xss_clean|max_length[255]|valid_email'
                  ),
               array(
                     'field'   => 'message', 
                     'label'   => parent::_getFieldTitle('message'), 
                     'rules'   => 'trim|required|xss_clean'
                  )
            );

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else 
		{
			// === Load Email Library === //
			$this->load->library('email');
			$config['wordwrap'] = FALSE;
			$this->email->initialize($config);
			
			// === Settings === //
			$settings = $this->settings_model;
			
			// === Email === //
			$this->email->clear();
			
			$this->email->from($this->settings_model['send_email_from'], $this->input->post('name',1));
			$this->email->to($settings['site_email']);
			$this->email->reply_to($this->input->post('email',1), $this->input->post('name',1));
			
			$this->email->subject("Request from: ". $this->input->post('name',1));
			$this->email->message($this->input->post('message',1));
			
			$this->email->send();
			
			echo "success";
		}
		exit;
	}
	
}