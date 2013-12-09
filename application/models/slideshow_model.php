<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for slideshow.
 * 
 * @package slideshow  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Slideshow_model extends Base_model
{
	//name of table
	protected $c_table = 'slideshow';
	//name of primary field
	protected $id_column = 'data_key';
	
}