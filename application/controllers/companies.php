<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for companies.
 * 
 * @package messageboard  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Companies extends Front 
{
    /**
     * Init required models, helpers, language sections, pages' titles, css files etc.
     *
     * @return \Companies
     */
    public function __construct()
	{
		parent::__construct();
		
		// === Load Models === //
		$this->load->model('companies_model');
		$this->load->model('categories_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front'));
		
		// === Labels === //
		$this->fields_titles['category'] = language('category');
		$this->fields_titles['name'] = language('company_name');
		$this->fields_titles['email'] = language('email');
		$this->fields_titles['phone'] = language('phone');
		$this->fields_titles['phone2'] = language('phone2');
		$this->fields_titles['fax'] = language('fax');
		$this->fields_titles['website'] = language('website');
		$this->fields_titles['city'] = language('city');
		$this->fields_titles['region'] = language('city_region');
		$this->fields_titles['address'] = language('address');
		$this->fields_titles['work_time'] = language('company_work_time');
		$this->fields_titles['short_description'] = language('short_description');
		$this->fields_titles['services'] = language('company_services');
		$this->fields_titles['long_description'] = language('detailed_description');
		$this->fields_titles['pub_date'] = language('added_date');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('companies');
		$this->page_titles['search'] = language('companies');
		//default page title
		$this->_setDefaultPageTitle();
		
		// === Load Helpers === //
		$this->load->helper('text');
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //

	

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Show companies' categories/subcategories list by parent category ID.
	 * 
	 * @return void
	 */
	public function Index()
	{
		$filter_data = $this->uri->uri_to_assoc($this->_getSegmentsOffset()+3);
		
		if(!isset($filter_data['category'])) $filter_data['category'] = 0;
		
		$data['categories'] = $this->categories_model->GetChildren($filter_data['category'],TRUE);
		
		//if no subcategories - show posts
		if(empty($data['categories']))
		{
			redirect($this->_getBaseURI()."/search/category/".$filter_data['category']);
		}
		
		$data['controller'] = "companies";
		
		$data['tpl_page'] = "categories/list";
		
		// === Current Location === //
		$current_location_arr = 
		array(
			$this->_getBaseURI()=>$this->_getPageTitle()
		);
		
		// === Categories Location === //
		$categories_location_arr = $this->categories_model->GetLocation($filter_data['category'],'companies');
		$current_location_arr = array_merge($current_location_arr,$categories_location_arr);
		
		$data['current_location_arr'] = $current_location_arr;
		
		//add search category info
		if($filter_data['category']) $data = array_merge($data,$this->categories_model->getSearchCategoryData($filter_data['category']));
		
		//generate additional page title
		$this->appendPageTitleForListPages($filter_data,$data);
		
		parent::_OnOutput($data);
	}

    /**
	 * Show companies list by filter.
	 * 
	 * @return void
	 */
	public function Search()
	{
		// === Filter Data === //
		$filter_data = $this->companies_model->getFilterData();
		
		// === Posters === //
		if(isset($filter_data['empty_filter']))
		{
			$data['posts_list'] = false;
			$data['paginate'] = '';
		}
		else 
		{
			$data = $this->companies_model->getAction("search", $filter_data);
		}
		
		$data = array_merge($data,$filter_data);

		$data['tpl_page'] = $this->controller."/list";

		// === Current Location === //
		$current_location_arr =
		array(
			$this->_getBaseURI()=>$this->_getPageTitle()
		);
		
		// === Categories Location === //
		$categories_location_arr = $this->categories_model->GetLocation(@$filter_data['category'],'companies');
		
		$current_location_arr = array_merge($current_location_arr,$categories_location_arr);
		
		$data['current_location_arr'] = $current_location_arr;

		//add search category info
		if(@$filter_data['category']) $data = array_merge($data,$this->categories_model->getSearchCategoryData($filter_data['category']));
		
		//generate additional page title
		$this->appendPageTitleForListPages($filter_data,$data);
		
		parent::_OnOutput($data);
	}
	
	/**
	 * Show company's full information.
	 * 
	 * @param integer $id
	 * @param integer $category
	 * @return void
	 */
	public function View($id,$category=0)
	{
		// === GET RECORD === //
		$data = $this->companies_model->getOneById($id);
		
		// === Stats: Increment Views === //
		$this->companies_model->IncViews($data['id'],$data['views']);
		
		// === Main Data === //
		$this->_setPageTitle($data['name']);

		// === Current Location === //
		$current_location_arr =
		array(
			$this->_getBaseURI() => language('companies'),
		);
		
		$view_location_arr = array($this->_getBaseURI()."/view/".$id=>'[page_title]');
		
		// === Categories Location === //
		$categories_location_arr = $this->categories_model->GetLocation($category,'companies');
		
		$current_location_arr = array_merge($current_location_arr,$categories_location_arr,$view_location_arr);
		

		$data['current_location_arr'] = $current_location_arr;

		parent::_OnOutput($data);
	}

}