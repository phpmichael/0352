<?php
require_once(APPPATH.'models/categories_model.php');

/** 
 * This is model for articles_categories_list table.
 * 
 * @package articles  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Articles_categories_model extends Categories_model
{
	//name of table
	protected $c_table = 'articles_categories_list';
	
}