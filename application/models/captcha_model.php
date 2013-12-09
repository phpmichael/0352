<?php

/** 
 * This model creates captcha and check if user filled valid captcha code.
 * 
 * @package captcha  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Captcha_model extends CI_Model 
{
	//instance of CodeIgniter
	private $CI;
	
	/**
	 * Creates captcha.
	 * 
	 * @uses helper captcha
	 * @return string
	 */
	public function make()
	{
		$this->CI =& get_instance();
		
		$this->load->helper( 'captcha' );
		
		$vals = array(
			'img_path' => './'.$this->CI->_getFolder('images') .'captcha/', // PATH for captcha 
			'img_url' => base_url().$this->CI->_getFolder('images') .'captcha/', // URL for captcha img
			//'img_width' => 200, // width
			//'img_height' => 60, // height
			// 'font_path'     => '../system/fonts/2.ttf',
			// 'expiration' => 7200 ,
			'word' => rand(1111,4444)
		);
		
		// Create captcha
		$cap = create_captcha( $vals );
		
		// Write to DB
		if ( $cap ) 
		{
			$data = array(
				'captcha_id' => '',
				'captcha_time' => $cap['time'],
				'ip_address' => $this ->input->ip_address(),
				'word' => $cap['word'] ,
			);
			$query = $this->db->insert_string( 'captcha', $data );
			$this->db->query( $query );
		}
		else 
		{
			return "Error: captcha doesn't work." ;
		}
		
		return $cap['image'] ;
	}
	 
	/**
	 * Check if captcha code is valid.
	 * 
	 * @param string $captcha
	 * @return bool
	 */
	public function check($captcha)
	{
		// Delete old data ( 2hours)
		$expiration = time() - 7200 ;
		$sql = " DELETE FROM captcha WHERE captcha_time < ? ";
		$binds = array($expiration);
		$query = $this->db->query($sql, $binds);
		
		//checking input
		$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
		$binds = array($captcha, $this->input->ip_address(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();
		
		if ( $row -> count > 0 )
		{
			return TRUE;
		}
		return FALSE;
	
	}
    
}