<?php
require_once(APPPATH.'models/articles_categories_model.php');

/** 
 * This is model for news_categories_list table.
 * 
 * @package news  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class News_categories_model extends Categories_model
{
	//name of table
	protected $c_table = 'articles_categories_list';
}