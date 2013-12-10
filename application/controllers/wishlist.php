<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for wishlist.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Wishlist extends Front 
{
    /**
     * Init required models, helpers, language sections, pages' titles, css files etc.
     *
     * @return \Wishlist
     */
	public function __construct()
	{
		parent::__construct();
		
		// === Load Models === //
		$this->load->model('products_model');
		$this->load->model('wishlist_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','users','wishlist'));
		
		// === Page Titles === //
		$this->page_titles['index'] = language('my_wishlist');
		//default page title
		$this->_setDefaultPageTitle();
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

    /**
	 * Show customer's home page.
	 * 
	 * @return void
	 */
	public function Index()
	{
		$this->_CheckLogged();
		
		$data['wishlist'] = $this->wishlist_model->getMy();

		parent::_OnOutput($data);
	}

	/**
	 * Add product to customer's wishlist.
	 *
	 * @return void
	 */
	public function Add()
	{
		if(!$this->_is_logged())
		{
			die( json_encode(array('error'=>1,'message'=>language('error').' : '.language('please_login'))) );
		}
		
		$result = $this->wishlist_model->Add($this->session->userdata('customer_id'),$this->input->post('product_id'));
		
		if($result) die( json_encode(array('success'=>1,'message'=>language('added_to_wishlist'))) );
		else die( json_encode(array('error'=>1,'message'=>language('error').': '.language('could_not_add_to_wishlist'))) );
	}

    /**
     * Remove product from wishlist.
     * @param $wishlist_id
     */
    public function Remove($wishlist_id)
	{
		$this->_CheckLogged();
		
		$this->wishlist_model->remove($this->session->userdata('customer_id'),$wishlist_id);
		
		redirect($this->_getBaseURI());
	}

}