<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for partner slider.
 * 
 * @package partner_slider  
 * @author Michael Kovalskiy
 * @version 2013
 * @access public
 */
class Partner_slider_model extends Base_model
{
	//name of table
	protected $c_table = 'partner_slider';
	//name of primary field
	protected $id_column = 'data_key';
	
}