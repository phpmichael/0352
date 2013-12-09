<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for ratings.
 * 
 * @package ratings  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Ratings_model extends Base_model
{
	//name of table
	protected $c_table = 'ratings';
    
    /**
     * Set rating for post. 
     * 
     * @param array $data
     * @return integer|bool rating of post or FALSE
     */
    public function setRating(array $data)
    {
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		$data['customer_id'] = $this->CI->session->userdata('customer_id');
        
        if($this->alreadyRated($data['table'],$data['post_id'])) return FALSE;
        
        $this->CI->load->helper('cookie');
        $cookie = array(
        	'name'   => 'rated_'.$data['table'].'_'.$data['post_id'],
            'value'  => $data['rating'],
            'expire' => 3600*24*365,
            'path'   => '/',
            );
        set_cookie($cookie);
    	
    	parent::Insert($data);
    	
    	return $this->getRating($data['table'],$data['post_id']);
    }
    
    /**
     * Get rating of post.
     *
     * @param string $table
     * @param integer $post_id
     * @return integer rating
     */
    public function getRating($table,$post_id)
    {
    	$result = $this->db->query("SELECT SUM(rating) AS total_rating FROM {$this->c_table} WHERE `table`=? AND post_id=?",array($table,$post_id))->row_array();
    	return intval($result['total_rating']);
    }
    
    /**
	 * Check if customer already rated post. 
	 * There is 3 way to check: ID,IP,cookie.
	 * 
	 * @param string $table
	 * @param integer $post_id
	 * @return bool
	 */
	public function alreadyRated($table,$post_id)
	{
        $settings = $this->CI->settings_model;
        
        $customer_id = $this->CI->session->userdata('customer_id');
        
        $rated = FALSE;
        
        if(!$rated && $settings['ratings_check_by_id'])
        {
	       if(!$customer_id) $rated = TRUE;
           else $rated = (bool)$this->db->select('id')->get_where($this->c_table,array('`table`'=>$table,'post_id'=>$post_id,'customer_id'=>$customer_id))->row_array();
        }
	    
        if(!$rated && $settings['ratings_check_by_ip'])
        {
	       $rated = (bool)$this->db->select('id')->get_where($this->c_table,array('`table`'=>$table,'post_id'=>$post_id,'ip'=>$_SERVER['REMOTE_ADDR']))->row_array();
        }
        
        if(!$rated && $settings['ratings_check_by_cookie'])
        {
	       $this->CI->load->helper('cookie');
	       $rated = (bool)get_cookie('rated_'.$table.'_'.$post_id, TRUE);
        }
	    
	    return $rated;
	}
	
	/**
	 * Delete ratings for post.
	 * 
	 * @param string $table
	 * @param integer $post_id
	 * @return void
	 */
	public function deletePostRatings($table, $post_id)
	{
		if(intval($post_id)) $this->db->delete($this->c_table, array('`table`' => $table, 'post_id' => $post_id));
	}
    
}