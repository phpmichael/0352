<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for send mass-mail.
 * 
 * @package massmail  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Newsletters_model extends Base_model
{
	//name of table
	protected $c_table = 'newsletters';
	
	/**
	 * Add email to queue (insert into table).
	 * 
	 * @param array $sendtoArr
	 * @param string $subject
	 * @param string $message
	 * @param string $send_from
	 * @return void
	 */
	public function setInQueue(array $sendtoArr,$subject,$message,$send_from)
	{
		foreach ($sendtoArr as $row)
		{
			$newsletter['subject'] = $subject;
			$newsletter['message'] = $message;
			$newsletter['send_from'] = $send_from;
			$newsletter['send_to'] = $row['email'];
			
			$this->Insert($newsletter);
		}
	}
	
}