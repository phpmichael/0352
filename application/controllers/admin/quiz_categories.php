<?php
require_once(APPPATH.'controllers/admin/photos_categories.php');

/** 
 * This is admin controller for quiz categories.
 * 
 * @package quiz
 * @author Michael Kovalskiy
 * @version 2015
 * @access public
 */
class Quiz_Categories extends Photos_Categories
{
	//name of table
    protected $c_table = "quiz_categories_list";

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @param string $model
     * @return \Quiz_Categories
     */
	public function __construct($model='quiz_categories_model')
	{
		parent::__construct($model);
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

}