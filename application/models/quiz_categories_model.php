<?php
require_once(APPPATH.'models/photos_categories_model.php');

/** 
 * This is model for quiz_categories_list table.
 * 
 * @package quiz
 * @author Michael Kovalskiy
 * @version 2015
 * @access public
 */
class Quiz_categories_model extends Photos_categories_model
{
	//name of table
	protected $c_table = 'quiz_categories_list';
	
	//images settings
	protected $photo_data = array(
	   'small_width' => 150,
	   'small_height' => 150,
	   'big_dir' => FALSE,
	   'small_dir' => 's/',
	   'small_crop' => TRUE
	);
	
}