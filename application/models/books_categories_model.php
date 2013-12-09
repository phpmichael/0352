<?php
require_once(APPPATH.'models/products_categories_model.php');

/** 
 * This is model for products_categories_list table.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Books_categories_model extends Products_categories_model
{
	//name of table
	protected $c_table = 'products_categories_list';
	
}