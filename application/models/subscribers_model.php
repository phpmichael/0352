<?php
require_once(APPPATH.'models/posts_model.php');

/** 
 * This is model for subscribers.
 * 
 * @package subscribers  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Subscribers_model extends Posts_model
{
	//name of table
	protected $c_table = "subscribers";

    //pagination
    protected $per_page = 20;

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

    /**
     * Make sql criterias based on $filter_data.
     *
     * @param $filter_data
     * @return string
     */
    protected function _buildWhere(array $filter_data = array())
    {
        $where = "1";

        //Email
        if( isset($filter_data['keywords']) && ($keywords = $this->CI->security->xss_clean(trim(urldecode($filter_data['keywords'])))) )
        {
            $where .= " AND {$this->c_table}.email LIKE '%".$this->db->escape_str($keywords)."%'";
        }

        return $where;
    }

    /**
     * Make array of search/sort criterias.
     *
     * @return array
     */
    public function getFilterData()
    {
        $filter_data = $this->CI->input->post(NULL,TRUE);

        if( isset($filter_data['keywords']) ) $filter_data['keywords'] = urlencode($filter_data['keywords']);

        if(!@$filter_data['per_page']) $filter_data['per_page'] = $this->per_page;
        //set default values for filters - requires for pagination
        if( !@$filter_data['sort_by'] ) $filter_data['sort_by'] = 'id';
        if( !@$filter_data['sort_order'] ) $filter_data['sort_order'] = 'asc';


        //Request from Pagination
        $filter_data = $this->paginationFilter($filter_data);

        return $filter_data;
    }
    
}