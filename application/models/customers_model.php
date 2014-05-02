<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for customers table.
 * 
 * @package customers  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Customers_model extends Base_model 
{
	//name of table
	protected $c_table = "customers";
    
	/**
	 * Insert data. Returns ID.
	 * Overloads parent method.
	 * 
	 * @param array $post
	 * @return integer
	 */
    public function Insert($post)
    {
    	$post['reg_date'] = date('Y-m-d H:i:s');
		
		return parent::Insert($post);
    }
    
    /**
	 * Check if user logged.
	 * 
	 * @param string $email
	 * @param string $password
	 * @return array|bool
	 */
    public function checkLogin($email,$password)
    {
    	//hash password if it is not hashed yet
        if(strlen($password)!=32) $password = md5($password);

        $customer = $this->db->get_where($this->c_table,array('email'=>$email,'password'=>$password))->row_array();
    	if(empty($customer)) return FALSE;
    	return $customer;
    }
    
    /**
	 * Creates session for user after login.
	 * 
	 * @param array $customer
	 * @return void
	 */
    public function setLogined($customer)
    {
    	$this->setLastLogged($customer[$this->id_column]);
    	
    	$sessdata['customer_name'] = $customer['name'];
		$sessdata['customer_id'] = $customer[$this->id_column];
		$sessdata['customer_logged_in'] = TRUE;
		$sessdata['customer_group_id'] = isset($customer['group_id'])?$customer['group_id']:1;
		$sessdata['customer_is_admin'] = $this->CI->groups_model->hasAdminAccess($sessdata['customer_group_id']);
		$sessdata['customer_rights'] = $this->CI->groups_model->getGroupRights($sessdata['customer_group_id']);

		$this->session->set_userdata($sessdata);
		
		if($sessdata['customer_is_admin'])
		{
			//set access to tinymce images plugin
			setcookie('T_M_I',md5('soliter-123'.$_SERVER['REMOTE_ADDR']),time()+7200,'/');
		}
    }
    
    /**
     * Return logged customer's data.
     *
     * @return array
     */
    public function getLogged()
    {
        return $this->getOneById($this->session->userdata('customer_id'));
    }
    
    /**
	 * Remove session for user after logout.
	 * 
	 * @return void
	 */
    public function setLogout()
    {
    	$sessdata['customer_name'] = '';
		$sessdata['customer_id'] = 0;
		$sessdata['customer_logged_in'] = FALSE;
		$sessdata['customer_group_id'] = FALSE;
		$sessdata['customer_is_admin'] = FALSE;
		$sessdata['customer_rights'] = FALSE;

		$this->session->unset_userdata($sessdata);
		
		//remove access to tinymce images plugin
		setcookie('T_M_I','',time()-7200,'/');
    }
    
    /**
	 * Generate random password for user.
	 * 
	 * @param integer $customer_id
	 * @return string
	 */
    public function generatePassword($customer_id)
	{
	    $encryption_key = $this->CI->config->item('encryption_key');
	    
	    $password = substr(md5($customer_id.$encryption_key.time()),0,10);
		
		// === Update Password in DB === //
		$this->db->where($this->id_column, $customer_id);
		$this->db->update($this->c_table, array("password"=>md5($password)));
		
		return $password;
	}
	
	/**
	 * Return link for restoring password.
	 *
	 * @param integer $customer_id
	 * @return string
	 */
	public function generateRestorePasswordLink($customer_id)
	{
	    $encryption_key = $this->CI->config->item('encryption_key');
	    
	    $hash = md5($customer_id.$encryption_key);
	    
	    $link = site_url('customers/restore_pass/'.$customer_id.'/'.$hash);
	    
	    return $link;
	}
	
	/**
	 * Set timestamp of last user login.
	 * 
	 * @param integer $id
	 * @return void
	 */
	private function setLastLogged($id)
    {
    	parent::Update(array($this->id_column=>$id,'last_logged'=>date('Y-m-d H:i:s')));
    }
    
    /**
     * Return customer's name by ID.
     *
     * @param integer $customer_id
     * @return string|bool
     */
    public function getNameById($customer_id)
    {
        $customer = $this->getOneById($customer_id);
        
        if (!$customer) return FALSE;
        
        return $customer['name'];
    }
    
    /**
     * Return customer's full name by ID.
     *
     * @param integer $customer_id
     * @return string|bool
     */
    public function getFullNameById($customer_id)
    {
        $customer = $this->getOneById($customer_id);
        
        if (!$customer) return FALSE;
        
        return $customer['name']. ' ' . $customer['surname'];
    }
    
    /**
     * Delete customer and his data.
     * @todo remove customer data
     *
     * @param integer $customer_id
     * @return void
     */
    public function DeleteId($customer_id)
    {
    	//remove customer's wishlist
    	$wishlist_model = load_model('wishlist_model');
    	$wishlist_model->deleteCustomerWishlist($customer_id);
    	
    	//remove customer's posters
    	//remove customer's jobs
    	//remove customer's orders
    	//remove customer's quiz archives
    	
    	//remove customer
    	parent::DeleteId($customer_id);
    }
}