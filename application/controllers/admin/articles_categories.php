<?php
require_once(APPPATH.'controllers/admin/categories.php');

/** 
 * This is admin controller for articles' categories.
 * 
 * @package articles  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Articles_Categories extends Categories 
{
	//name of table
    protected $c_table = "articles_categories_list";

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Articles_Categories
     */
	public function __construct()
	{
		parent::__construct('articles_categories_model');
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

}