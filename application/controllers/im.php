<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for instant messenger.
 * 
 * @package IM  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Im extends Front 
{
    /**
     * Init required models, helpers, language sections, pages' titles, css files etc.
     *
     * @return \Im
     */
    public function __construct()
	{
		parent::__construct();
		
		// === Check is logged customer === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('im_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','im'));
		
		// === Labels === //
		$this->fields_titles['date'] = language('date');
		$this->fields_titles['message'] = language('message');
		
		// === CSS Styles === //
		$this->css_files = array(
		      $this->_getTheme().'css/im.css'
		);
		
		$this->load->helper('text');
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //

    /**
	 * Show main IM window between logged user and user with ID = $to_id.
	 * 
	 * @param integer $to_id
	 * @return void
	 */
	public function Index($to_id)
	{
       	$customer_id = $this->session->userdata('customer_id');
       	
       	if($to_id==$customer_id) die('Error: you can not send message to yourself.');
       	
       	//customers info
       	$data['sender'] = $this->customers_model->getOneById($customer_id);
       	$data['recipient'] = $this->customers_model->getOneById($to_id);
       	
       	$history_messages = $this->im_model->getHistoryMessages($to_id,$customer_id,20);
       	$data['history_messages'] = json_encode($history_messages);
		
		// === Set page title and meta data === //
		$this->_buid_head_data();
		
		// === VIEW === //
		load_theme_view($this->_getFolder().$this->controller."/index",$data);
	}
	
	/**
	 * Send message from logged user to user with ID = $to_id.
	 * 
	 * @param integer $to_id
	 * @return void
	 */
	public function Submit($to_id)
	{
		$to_id = intval($to_id);
		
		$customer_id = $this->session->userdata('customer_id');
		
		if(!$to_id) die('Error: recipient doesn\'t defined.');
		
		if($to_id==$customer_id) die('Error: you can not send message to yourself.');
		
		$this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'message', 
                     'label'   => parent::_getFieldTitle('message'), 
                     'rules'   => 'trim|required|xss_clean'
                  ),
            );

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() != FALSE)
		{
    		$this->im_model->addMessage($customer_id,$to_id,$_POST['message']);
		}
		else die('Error: Message is required.');
		
		exit;
	}
	
	/**
	 * Returns new messages from user with ID = $from_id in JSON format.
	 * 
	 * @param integer $from_id
	 * @return string
	 */
	public function getNewMessages($from_id)
	{
		$from_id = intval($from_id);
		
		if(!$from_id) die('Error: Sender doesn\'t defined');
		
		$customer_id = $this->session->userdata('customer_id');
		
		$messages = $this->im_model->getNewMessages($from_id,$customer_id);
		
		echo json_encode($messages);
	}
	
	/**
	 * Show history between logged user to user with ID = $to_id.
	 * 
	 * @param integer $to_id
	 * @return void
	 */
	public function History($to_id)
	{
       	$customer_id = $this->session->userdata('customer_id');
       	
       	if($to_id==$customer_id) die('Error: you can not send message to yourself.');
       	
       	//customers info
       	$data['sender'] = $this->customers_model->getOneById($customer_id);
       	$data['recipient'] = $this->customers_model->getOneById($to_id);
       	
       	$history_messages = $this->im_model->getHistoryMessages($to_id,$customer_id);
       	$data['history_messages'] = json_encode($history_messages);
		
		// === Set page title and meta data === //
		$this->_buid_head_data();
		
		// === VIEW === //
		load_theme_view($this->_getFolder().$this->controller."/history",$data);
	}

}