<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for mass-mail templates.
 * 
 * @package massmail  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Email_tpls_model extends Base_model
{
	//name of table
	protected $c_table = 'email_tpl';
	
	/**
	 * Returns array of templates' names.
	 * 
	 * @return array
	 */
	public function getList()
	{
		$records = parent::getAll();
		$tplArr = array();
		
		$tplArr[0] = language('choose_template');
		foreach ($records as $record)
		{
			$tplArr[$record['id']] = $record['name'];
		}
		
		return $tplArr;
	}
	
	/**
	 * Get template content by ID.
	 * 
	 * @param integer $id
	 * @return string
	 */
	public function getContentById($id)
	{
		$record = parent::getOneById($id);
		return $record['content'];
	}
	
}