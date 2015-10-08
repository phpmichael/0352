<?php
require_once(APPPATH.'controllers/admin/categories.php');

/** 
 * This is admin controller for documents' categories.
 * 
 * @package documents
 * @author Michael Kovalskiy
 * @version 2014
 * @access public
 */
class Documents_Categories extends Categories
{
	//name of table
    protected $c_table = "documents_categories_list";

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Documents_Categories
     */
	public function __construct()
	{
		parent::__construct('documents_categories_model');
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

}