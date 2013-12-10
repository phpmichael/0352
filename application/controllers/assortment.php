<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for assortment.
 * 
 * @package assortment  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Assortment extends Front 
{
	//name of table
    protected $c_table = "assortment";
    protected $process_form_html_id = "assortment"; 
    protected $process_form_id; 
    
    /**
	 * Init required models, helpers, language sections, pages' titles, css files etc.
	 * 
	 * @return \Assortment
	 */
    public function __construct()
	{
		parent::__construct();
		
		// === Load Models === //
		$this->load->model(array('assortment_model','formbuilder_model','products_categories_model'));
		//$this->load->model('tags_model');
		//$this->load->model('comments_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','comments'));
		
		//ID of form
		$this->process_form_id = $this->formbuilder_model->getFormIdByHtmlId($this->process_form_html_id);
		
		// === Page Titles === //
		$this->page_titles['index'] = $this->formbuilder_model->getFormTitle($this->process_form_id);
		$this->page_titles['search'] = $this->formbuilder_model->getFormTitle($this->process_form_id);
		//default page title
		$this->_setDefaultPageTitle();
		
		// === Load Helpers === //
		//$this->load->helper('text');
		//$this->load->helper('comments');
		
		//$this->includeCommentsAndRatingsFiles();
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
    /*public function Tag($tag='')
	{
	    if($tag=='ALL') $tag = 0;

		redirect($this->_getBaseURI().'/index/tag/'.$tag);
	}*/
    
    /**
	 * Show categories/subcategories list by parent category ID.
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
		
		// === Current Location === //
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
	 * Show assortment list by filter.
	 * 
	 * @return void
	 */
	public function Search()
	{
		// === Filter Data === //
		$filter_data = $this->assortment_model->getFilterData();
		
		// === Posters === //
		$data = $this->assortment_model->get("search", $filter_data);
		
		$data = array_merge($data,$filter_data);

		$data['tpl_page'] = $this->_getController()."/list";

		// === Current Location === //
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
     * Show assortment by slug.
     *
     * @param bool|string $slug
     * @return void
     */
	public function Name($slug=FALSE)
	{
	    if(!$slug) redirect($this->_getBaseURI());
		
		$data = $this->assortment_model->getBySlug($slug);
	    
	    //if no page
		if(empty($data)) show_404($this->input->server('REQUEST_URI'));
	    
	    $this->View($data[$this->assortment_model->getIdColumn()]);
	}
	
	/**
	 * Show assortment's full information.
	 * 
	 * @param string(16) $data_key
	 * @return void
	 */
	public function View($data_key)
	{
	    // === GET RECORD === //
	    $data = $this->assortment_model->getOneById($data_key);
	    
	    //if no page
		if(empty($data)) show_404($this->input->server('REQUEST_URI'));
		
		// === Main Data === //
		$this->_setPageTitle($data['name']);
		$this->_buid_head_data(array("page_title"=>$this->_getPageTitle(),"meta_keywords"=>'',"meta_description"=>''));

		// === Current Location === //
		$current_location_arr =
		array(
			$this->_getBaseURI() => $this->formbuilder_model->getFormTitle($this->process_form_id),
		);
		
		$view_location_arr = array($this->_getBaseURI()."/view/".$data['data_key']=>'[page_title]');
		
		$current_location_arr = array_merge($current_location_arr,$view_location_arr);
		
		$data['current_location_arr'] = $current_location_arr;

		parent::_OnOutput($data);
	}

}