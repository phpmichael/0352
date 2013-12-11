<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

/** 
 * This class for replacing template vars in mass-mail.
 * 
 * @package massmail  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Email_templater
{
	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		log_message('debug', "Email_templater Class Initialized");
	}

	/**
	 * Replace template vars in template.
	 *
	 * @param string $text
	 * @param array $array
	 * @return string
	 */
	private function Replace( $text, array $array=array() )
	{
		$CI =& get_instance();
		
		// === Special Array === //
		if( !empty($array) )
		{
			foreach ($array as $field=>$value)
			{
			   $text = str_replace("{".$field."}",$value,$text);
			}
		}

		// === Settings === //
		$settings = $CI->settings_model->toArray();

		foreach ($settings as $field=>$value)
		{
		   $text = str_replace("{".$field."}",$value,$text);
		}

		// === Other === //
		$text = str_replace("{site_title}",$CI->settings_model['site_title_'.strtoupper($CI->_getInterfaceLang(TRUE))],$text);
		$text = str_replace("{site_url}",base_url(),$text);
		$text = str_replace("{now_date}",date("Y-m-d H:i:s"),$text);
		$text = str_replace("{unsubscribe_link}",site_url("subscribe/unsubscribe"),$text);
		if(isset($array['id'])) $text = str_replace("{restore_password_link}",$CI->customers_model->generateRestorePasswordLink($array['id']),$text);

		return $text;
	}

	/**
	 * Send email.
	 * 
	 * @param string $to
	 * @param string $subject
	 * @param string $message
	 * @param string $from
	 * @param array $array
	 * @return void
	 */
	public function mail($to,$subject,$message,$from,array $array=array())
	{
		$CI =& get_instance();

		// === Replace === //
		$subject = $this->Replace($subject,$array);
		$message = $this->Replace($message,$array);

		// === Email === //
		$CI->load->library('email');

		//$config['protocol'] = 'sendmail';
		//$config['mailpath'] = '/usr/sbin/sendmail';
		//$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = FALSE;
		//$config['_encoding'] = '7bit';

		$CI->email->initialize($config);

		$CI->email->clear();

		$CI->email->from($from);
		$CI->email->to($to);

		$CI->email->subject($subject);
		$CI->email->message($message);

		$CI->email->send();

		//print_r( $CI->email->print_debugger() );
	}

}