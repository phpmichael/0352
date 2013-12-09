<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for mass-mail.
 * 
 * @package massmail  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Newsletters extends Admin 
{
	protected $c_table = 'newsletters';
    
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
		
		// === Load Models === //
		$this->load->model('newsletters_model');
		$this->load->model('email_tpls_model');
		$this->load->model('customers_model');
		$this->load->model('subscribers_model');
		
		// === Load Libraries === //
		$this->load->library('email_templater');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin','newsletters'));
		
		// === Labels === //
		$this->fields_titles['subject'] = language('subject');
		$this->fields_titles['message'] = language('message');
		$this->fields_titles['send_from'] = language('send_from');
		$this->fields_titles['send_to'] = language('send_to');
		$this->fields_titles['date'] = language('date');
		
		// === Page Titles === //
		$this->page_titles['send'] = language('mass_mail');
		$this->page_titles['index'] = language('queue');
		//default page title
		$this->_setDefaultPageTitle();
		
		$this->load->helper('text');
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
		if(!$this->_is_logged()) return '';

		$menu = "";
		
		if(userAccess('email_tpls','view')) $menu = "<li><span class='css3-icon css3-icon-list'>".anchor_base('email_tpls', language('templates'))."</span></li>";
		if(userAccess('email_tpls','add')) $menu .= "<li><span class='css3-icon css3-icon-add'>".anchor_base('email_tpls/add',  language('add_template'))."</span></li>";

		return $menu;
	}

	/**
	 * Validate and insert or update data.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsert()
	{
		$settings = $this->settings_model;
		
		$this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'send_from', 
                     'label'   => parent::_getFieldTitle('send_from'), 
                     'rules'   => 'trim|required|valid_email'
                  ),
               array(
                     'field'   => 'subject', 
                     'label'   => parent::_getFieldTitle('subject'), 
                     'rules'   => 'trim|required|xss_clean'
                  ),
               array(
                     'field'   => 'message', 
                     'label'   => parent::_getFieldTitle('description'), 
                     'rules'   => 'trim|required|xss_clean'
                  )
            );

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			//prefill inputs from session
		    $data['subject'] = $this->session->userdata('send_newsletter_subject') ;
			$data['message'] = $this->session->userdata('send_newsletter_message') ;
			$data['send_from'] = $this->session->userdata('send_newsletter_send_from') ;
		    
		    //change template
		    $data['tplArr'] = $this->email_tpls_model->getList();
			
			if( $load_tpl = $this->uri->segment($this->_getSegmentsOffset()+3) ) 
			{
				$data['message'] = $this->email_tpls_model->getContentById($load_tpl);
			}
			
			if(!$data['send_from']) $data['send_from'] = $settings['send_email_from'];
			
			$data['tpl_page'] = $this->_getController().'/send';
		    parent::_OnOutput($data);
		}
		else
		{
		    // === Send to === //
		    switch ( $this->input->post('send_to') )
		    {
		        case "me":
		              $sendtoArr[0] = $this->customers_model->getLogged();
		        break;
		        
		        case "customers":
		              $sendtoArr = $this->customers_model->getAll();
		        break;
		        
		        case "subscribers":
		              $sendtoArr = $this->subscribers_model->getAll();
		        break;
		    }
		    
		    //store post data in session
		    $sessdata['send_newsletter_subject'] = $this->input->post('subject');
		    $sessdata['send_newsletter_message'] = $this->input->post('message');
		    $sessdata['send_newsletter_send_from'] = $this->input->post('send_from');
			$this->session->set_userdata($sessdata);
			
			$this->newsletters_model->setInQueue($sendtoArr,$this->input->post('subject'),$this->input->post('message'),$this->input->post('send_from'));
			
			if( $this->input->post('send_to')=='me' ) 
			{
			    $this->Email();
			    redirect($this->_getBaseURI().'/send');
			}
			else redirect($this->_getBaseURI().'/index');
		}
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	public function Index()
	{
		$this->Email();
		
		parent::Index();
	}
	
	/**
	 * Add emails to newsletter table (set in queue).
	 * 
	 * @return void
	 */
	public function Send()
	{
		$this->_processInsert();
	}
	
	/**
	 * Send emails and remove from table.
	 * 
	 * @return void
	 */
	private function Email()
	{
		// === Get Emails From DB == //
		$newsletters = $this->newsletters_model->get(false,false,'ASC',$this->settings_model['newsletters_send_count']);

		// === Mass-Mail === //
		foreach ($newsletters as $record)
		{
			if( $customer = $this->customers_model->getOneByUnique('email',$record['send_to']) )
			{ 
				$replaceArr = $customer; 
			}
			else $replaceArr = array();
			
			$this->email_templater->mail($record['send_to'],$record['subject'],$record['message'],$record['send_from'],$replaceArr);

			//print_r( $this->email->print_debugger() );

			// === Delete From DB === //
			$this->newsletters_model->DeleteId($record['id']);
		}

	}
}