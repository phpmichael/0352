<?php
require_once(APPPATH.'models/categories_model.php');

/** 
 * This is model for documents_categories_list table.
 * 
 * @package documents
 * @author Michael Kovalskiy
 * @version 2014
 * @access public
 */
class Documents_categories_model extends Categories_model
{
	//name of table
	protected $c_table = 'documents_categories_list';
	
}