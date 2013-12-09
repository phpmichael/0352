<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for ratings.
 * 
 * @package ratings  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Ratings extends Front 
{
	/**
	 * Init required models, helpers, language sections, pages' titles, css files etc.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// === Load Models === //
		$this->load->model('ratings_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','ratings'));
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// === Custom validation : Start === //		
	
	// === Custom validation : End === //

	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //
	
	/**
	 * Set rating.
	 * 
	 * @return void
	 */
	public function Set()
	{
		$this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'rating', 
                     'label'   => 'Rating', 
                     'rules'   => 'required|numeric'
                  ),
               array(
                     'field'   => 'post_id', 
                     'label'   => 'Post ID', 
                     'rules'   => 'required|numeric'
                  ),
               array(
                     'field'   => 'table', 
                     'label'   => 'Table', 
                     'rules'   => 'required'
                  ),
            );

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() != FALSE)
		{
			$rating = $this->ratings_model->setRating($_POST);
			
			if($rating===FALSE) echo json_encode(array('error'=>language('you_already_rated_this')));
			else echo json_encode(array('error'=>0,'rating'=>$rating));
		}
		else 
		{
			echo json_encode(array('error'=>validation_errors()));
		}
		
		exit;
	}

}