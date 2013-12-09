<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for products.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Products extends Front 
{
	//name of table
    protected $c_table = "products";
    
    protected $process_form_model;
    
    /**
	 * Init required models, helpers, language sections, pages' titles, css files etc.
	 * 
	 * @return void
	 */
    public function __construct()
	{
		parent::__construct();
		
		// === Load Models === //
		$this->load->model($this->c_table.'_model');
		$this->process_form_model = $this->{$this->c_table.'_model'};
		$this->load->model('products_categories_model');
		$this->load->model('testimonials_model');
		$this->load->model('tags_model');
		$this->load->model('comments_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','cart','wishlist','testimonials','comments',$this->c_table));
		
		// === Labels === //
		$this->fields_titles['name'] = language('thing_name');
		$this->fields_titles['price'] = language('price');
		$this->fields_titles['qty'] = language('quantity');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('products');
		$this->page_titles['search'] = language('products');
		//default page title
		$this->_setDefaultPageTitle();
		
		// === Load Helpers === //
		$this->load->helper('text');
		$this->load->helper('comments');
		$this->load->helper('video');
		
		$this->includeCommentsAndRatingsFiles();
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //

	

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Use Index action.
	 * 
	 * @param string $tag
	 * @return void
	 */
    public function Tag($tag='')
	{
	    if($tag=='ALL') $tag = 0;

		redirect($this->_getBaseURI().'/search/tag/'.$tag);
	}
	
	/**
	 * Show products' categories/subcategoris list by parent category ID.
	 * 
	 * @return void
	 */
	public function Index()
	{
		$filter_data = $this->uri->uri_to_assoc($this->_getSegmentsOffset()+3);
		
		if(!isset($filter_data['category'])) $filter_data['category'] = 0;
		
		$data['categories'] = $this->products_categories_model->GetChildren($filter_data['category'],TRUE);
		
		//if no subcategories - show posts
		if(empty($data['categories']))
		{
			redirect($this->_getBaseURI()."/search/category/".$filter_data['category']);
		}
		
		$data['controller'] = $this->_getController();
		
		$data['tpl_page'] = "categories/list";
		
		// === Currenr Location === //
		$current_location_arr = 
		array(
			$this->_getBaseURI()=>$this->_getPageTitle()
		);
		
		// === Categories Location === //
		$categories_location_arr = $this->products_categories_model->GetLocation($filter_data['category'],$this->_getController());
		$current_location_arr = array_merge($current_location_arr,$categories_location_arr);
		
		$data['current_location_arr'] = $current_location_arr;
		
		//add search category info
		if($filter_data['category']) $data = array_merge($data,$this->products_categories_model->getSearchCategoryData($filter_data['category']));
		
		//generate additional page title
		$this->appendPageTitleForListPages($filter_data,$data);
		
		parent::_OnOutput($data);
	}

    /**
	 * Show products list by filter.
	 * 
	 * @return void
	 */
	public function Search()
	{
		// === Filter Data === //
		$filter_data = $this->process_form_model->getFilterData();
		if(isset($this->model_name) && $this->model_name=='formbuilder_model') $this->model->setFormData($filter_data);
		
		// === Posters === //
		if(isset($filter_data['empty_filter']))
		{
			$data['posts_list'] = false;
			$data['paginate'] = '';
		}
		else 
		{
			$data = $this->process_form_model->get("search", $filter_data);
		}
		
		$data = array_merge($data,$filter_data);

		$data['tpl_page'] = $this->_getController()."/list";

		// === Currenr Location === //
		$current_location_arr =
		array(
			$this->_getBaseURI()=>$this->_getPageTitle()
		);
		
		// === Categories Location === //
		$categories_location_arr = $this->products_categories_model->GetLocation(@$filter_data['category'],$this->_getController());
		
		$current_location_arr = array_merge($current_location_arr,$categories_location_arr);
		
		$data['current_location_arr'] = $current_location_arr;
		
		//add search category info
		if(@$filter_data['category']) $data = array_merge($data,$this->products_categories_model->getSearchCategoryData($filter_data['category']));
		
		//generate additional page title
		$this->appendPageTitleForListPages($filter_data,$data);
		
		parent::_OnOutput($data);
	}
	
	/**
	 * Show product by slug.
	 *
	 * @param string $slug
	 * @param integer $category
	 * @return void
	 */
	public function Name($slug=FALSE,$category=0)
	{
	    if(!$slug) redirect($this->_getBaseURI());
		
		$data = $this->process_form_model->getBySlug($slug);
	    
	    //if no page
		if(empty($data)) show_404($this->input->server('REQUEST_URI'));
	    
	    $this->View($data[$this->process_form_model->getIdColumn()],$category);
	}
	
	/**
	 * Show product's full information.
	 * 
	 * @param integer $resource
	 * @param integer $category
	 * @return void
	 */
	public function View($id,$category=0)
	{
	    // === GET RECORD === //
	    $data = $this->process_form_model->getOneById($id);
	    
	    //if no page
		if(empty($data)) show_404($this->input->server('REQUEST_URI'));
		
		// === Stats: Increment Views === //
		$this->process_form_model->IncViews($data[$this->process_form_model->getIdColumn()],$data['views']);
		
		// === Main Data === //
		$this->_setPageTitle($data['name']);
		if(isset($data['meta_keywords'])) $this->_buid_head_data(array("page_title"=>$this->_getPageTitle(),"meta_keywords"=>$data['meta_keywords'],"meta_description"=>$data['meta_description']));

		// === Currenr Location === //
		$current_location_arr =
		array(
			$this->_getBaseURI() => $this->page_titles['index'],
		);
		
		$view_location_arr = array($this->_getBaseURI()."/name/".$data['slug']=>'[page_title]');
		
		// === Categories Location === //
		$categories_location_arr = $this->products_categories_model->GetLocation($category,$this->_getController());
		
		$current_location_arr = array_merge($current_location_arr,$categories_location_arr,$view_location_arr);

		$data['current_location_arr'] = $current_location_arr;

		parent::_OnOutput($data);
	}

}