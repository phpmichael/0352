<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for autoresponder emails.
 * 
 * @package models  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Auto_responders_model extends Base_model
{
	//name of table
	protected $c_table = 'auto_responders';

    /**
     * Init email templater.
     *
     * @return \Auto_responders_model
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->CI->load->library("email_templater");
        $this->CI->load->helper("email");
    }
	
    /**
     * Send autoresponder if it is enabled.
     *
     * @param integer $auto_responder_id
     * @param string $to_email
     * @param array $data
     * @return bool
     */
	public function send($auto_responder_id,$to_email,$data)
	{
	    //get record by ID
	    $auto_responder = $this->getOneById($auto_responder_id);
	    
	    //check if autoresponder enabled
	    if( !$auto_responder['enabled'] || !valid_email($to_email) ) return FALSE;
	    
	    //get settings
	    $settings = $this->CI->settings_model;

		$lang = strtoupper($this->CI->_getInterfaceLang(TRUE));

		$subject = is_array($auto_responder['subject']) ? $auto_responder['subject'][$lang] : $auto_responder['subject'];
		$message = is_array($auto_responder['message']) ? $auto_responder['message'][$lang] : $auto_responder['message'];

	    //replace template vars and send email
	    return $this->CI->email_templater->mail(
            $to_email,
            $subject,
            $message,
            "{$settings['site_title_'.$lang]} <{$settings['send_email_from']}>",
            $data
		);
	}
	
}