<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for orders_customer_info.
 * 
 * @package shop
 * @author Michael Kovalskiy
 * @version 2017
 * @access public
 */
class Orders_customer_info_model extends Base_model
{
	//name of table
	protected $c_table = 'orders_customer_info';
	//name of primary field
	protected $id_column = 'data_key';
	
}