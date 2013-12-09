<?php
require_once(APPPATH.'models/articles_model.php');

/** 
 * This is models for news table.
 * 
 * @package news  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class News_model extends Articles_model 
{
	//name of table
	protected $c_table = 'news';
	//name of ...
	protected $c_type = "news";
	
}