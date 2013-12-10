<?php
require_once(APPPATH.'controllers/products.php');

/** 
 * This is controller for books.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Books extends Products 
{
	//name of table
    protected $c_table = "books";
    
    //main formbuilder model
	protected $model_name = 'formbuilder_model';
    
    protected $process_form_model;

    /**
     * Init required models, helpers, language sections, pages' titles, css files etc.
     *
     * @return \Books
     */
    public function __construct()
	{
		parent::__construct();
		
		// === Load Models === //
		$this->load->model($this->model_name);
		$this->model = $this->{$this->model_name};
		
		// === Formbuilder CSS === //
		$this->css_files[] = 'css/fb/styles.css';
		$this->css_files[] = $this->_getTheme().'fb/styles.css';
		
		// === Page Titles === //
		$this->page_titles['index'] = language('books');
		$this->page_titles['search'] = language('books');
		//default page title
		$this->_setDefaultPageTitle();
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //

	

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	

}