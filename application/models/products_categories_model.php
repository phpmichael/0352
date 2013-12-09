<?php
require_once(APPPATH.'models/photos_categories_model.php');

/** 
 * This is model for products_categories_list table.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Products_categories_model extends Photos_categories_model
{
	//name of table
	protected $c_table = 'products_categories_list';
	
	//images settings
	protected $photo_data = array(
	   'small_width' => 150,
	   'small_height' => 150,
	   'big_width' => 800,
	   'big_height' => 800,
	   'big_dir' => 'b/',
	   'small_dir' => 's/',
	   'small_crop' => TRUE
	);
	
}