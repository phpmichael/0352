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

    /**
     * Store form data.
     *
     * @param array $data
     * @param bool $nn not used here, just in formbuilder it is form html id
     * @param integer $id
     * @return integer
     */
    public function storeForm($data, $nn, $id=0)
    {
        $configValidation = array(
            array(
                'field'   => 'email',
                'label'   => language('email'),
                'rules'   => 'trim|required|max_length[255]|valid_email|callback__unique_field_for_edit[email,'.$id.']'
            ),
            array(
                'field'   => 'name',
                'label'   => language('name'),
                'rules'   => 'trim|required|xss_clean'
            ),
            array(
                'field'   => 'surname',
                'label'   => language('surname'),
                'rules'   => 'trim|required|xss_clean'
            ),
            array(
                'field'   => 'phone',
                'label'   => language('phone'),
                'rules'   => 'trim|xss_clean'
            ),
            array(
                'field'   => 'phone2',
                'label'   => language('phone2'),
                'rules'   => 'trim|xss_clean'
            ),
            array(
                'field'   => 'website',
                'label'   => language('website'),
                'rules'   => 'trim|xss_clean'
            ),
            array(
                'field'   => 'city',
                'label'   => language('city'),
                'rules'   => 'trim|xss_clean'
            ),
            array(
                'field'   => 'address',
                'label'   => language('address'),
                'rules'   => 'trim|xss_clean'
            ),
            array(
                'field'   => 'zip_code',
                'label'   => language('zip_code'),
                'rules'   => 'trim|xss_clean'
            )
        );

        if( !$id )
        {//create
            $configValidation[] = array(
                'field'   => 'password',
                'label'   => language('password'),
                'rules'   => 'trim|required|min_length[5]|max_length[16]|md5'
            );
            $configValidation[] = array(
                'field'   => 'repassword',
                'label'   => language('repassword'),
                'rules'   => 'trim|required|matches[password]'
            );
}
        else
        {//update
            $configValidation[] = array(
                'field'   => 'password',
                'label'   => language('password'),
                'rules'   => 'trim|min_length[5]|max_length[16]|md5'
            );

            if(isset($data['password']) && trim($data['password']))
            {
                $configValidation[] = array(
                    'field'   => 'repassword',
                    'label'   => language('repassword'),
                    'rules'   => 'trim|required|matches[password]'
                );
            }
            else unset($data['password']);
        }

        if(isset($data['captcha']))
        {
            $configValidation[] = array(
                'field'   => 'captcha',
                'label'   => language('captcha'),
                'rules'   => 'trim|required|callback__valid_captcha'
            );
        }

        $data[$this->id_column] = $id;

        return parent::save($data, $configValidation);
    }
}