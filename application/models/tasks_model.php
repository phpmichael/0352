<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for tasks table.
 * 
 * @package tasks  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Tasks_model extends Base_model
{
	//name of table
	protected $c_table = 'tasks';
	//name of primary field
	protected $id_column = 'data_key';
	
}