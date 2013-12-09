<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for videos table.
 * 
 * @package videos  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Videos_model extends Base_model
{
	//name of table
	protected $c_table = 'videos';
	//name of primary field
	protected $id_column = 'data_key';
	
}