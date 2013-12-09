<?php
require_once(APPPATH.'models/customers_model.php');

/** 
 * This is model for managers table.
 * 
 * @package managers  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Managers_model extends Customers_model
{
	/**
	 * Check if user logged.
	 * 
	 * @param string $email
	 * @param string $password
	 * @return array
	 */
	public function checkLogin($email,$password)
    {
    	$customer = parent::checkLogin($email,$password);
    	
    	if(!$customer) return FALSE;
    	
    	if(!$this->CI->groups_model->hasAdminAccess($customer['group_id'])) return FALSE;
    	
    	return $customer;
    }
	
}