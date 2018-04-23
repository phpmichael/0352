<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for books_authors table.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2018
 * @access public
 */
class Books_authors_model extends Base_model
{
	//name of table
	protected $c_table = 'books_authors';
	
	/**
	 * Return list of authors.
	 *
	 * @param int $limit
	 * @return array
	 */
	public function getAuthorsList($limit)
	{
	    $this->db->order_by('name','asc');
		$records = $this->db->get($this->c_table, $limit)->result_array();
		
		$list = multi2singleArray('id','name',$records);

		return $list;
	}
}