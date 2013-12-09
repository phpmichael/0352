<?php
require_once(APPPATH.'controllers/admin/photos_categories.php');

/** 
 * This is admin controller for products' categories.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Products_Categories extends Photos_Categories 
{
	//name of table
    protected $c_table = "products_categories_list";

    /**
	 * Init models, set pages' titles, fields' titles, set languages' sections.
	 * 
	 * @param string $model
	 * @return void
	 */
	public function __construct($model='products_categories_model')
	{
		parent::__construct($model);
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

}