<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for subscribers.
 * 
 * @package subscribers  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Subscribers_model extends Base_model 
{
	//name of table
	protected $c_table = "subscribers";

	/**
	 * Check if email exists in table.
	 * 
	 * @param string $email
	 * @return bool
	 */
    public function EmailExists($email)
    {
		// Check if email already in subscription
		$subscription = $this->db->get_where( $this->c_table, array('email' => $email), 1)->result_array();
		
		if(empty($subscription))
		{
			return FALSE;
		}
		else 
		{
			return TRUE;
		}
	}
	
	/**
	 * Insert email in table.
	 * 
	 * @param string $email
	 * @return void
	 */
	public function addEmail($email)
	{
		$this->db->insert($this->c_table, array('email'=>$email));
	}
	
	/**
	 * Remove email from table.
	 * 
	 * @param string $email
	 * @return void
	 */
    public function Unsubscribe($email)
    {
    	$this->db->delete($this->c_table, array('email'=>$email));
    }

    /**
     * Store form data.
     *
     * @param array $data
     * @param bool $nn not used here, just in frombuilder it is form html id
     * @param integer $id
     * @return integer
     */
    public function storeForm($data, $nn, $id=0)
    {
        $configValidation = array(
            array(
                'field'   => 'email',
                'label'   => 'E-Mail',
                'rules'   => 'trim|required|max_length[255]|valid_email|callback__unique_field_for_edit[email,'.$id.']'
            )
        );

        return parent::save($data, $configValidation);
    }
    
}