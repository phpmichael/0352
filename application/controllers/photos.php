<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for photos gallery.
 * 
 * @package photos  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Photos extends Front 
{
	//name of table
    protected $c_table = "photos";

    /**
     * Init required models, helpers, language sections, pages' titles, css files etc.
     *
     * @return \Photos
     */
	public function __construct()
	{
		parent::__construct();
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','photos'));
		
		// === Load Models === //
		$this->load->model('photos_model');
		$this->load->model('photos_categories_model');
		$this->load->model('tags_model');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('photo_categories');
		$this->page_titles['show'] = language('photos');
		$this->page_titles['tag'] = language('photos');
		//default page title
		$this->_setDefaultPageTitle();
		
		//Get tags cloud
		$data['tags_cloud'] = $this->tags_model->generateTagCloud($this->c_table,25,12,20);
		
		//Load Vars
		$this->load->vars($data);
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //



	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //

    /**
     * Returns children categories in JSON format.
     *
     * @param int $parent_id
     * @return string
     */
	public function getCategoriesJSON($parent_id=0)
	{
	    $categoriesArr = $this->photos_categories_model->GetChildren($parent_id);
	    $categories = array();
	    
	    foreach ($categoriesArr as $category_id => $category_name)
    	{
    		$categories[$category_id] = $this->photos_categories_model->getOneById($category_id);
    		$childrenArr = $this->photos_categories_model->GetChildren($category_id);
    		if(!empty($childrenArr))
    		{
    		    $categories[$category_id]['has_children'] = 1;
    		}
    		else 
    		{
    		    $categories[$category_id]['has_children'] = 0;
    		}
    	}
    	
    	echo json_encode($categories);
	}

	/**
	 * Use Show action.
	 * 
	 * @param string $tag
	 * @return void
	 */
	public function Tag($tag='')
	{
		if($tag=='ALL') $tag = 0;

		$this->Show(0,$tag);
	}

    /**
	 * Show photos' categories (with images).
	 * 
	 * @param integer $parent_id
	 * @return void
	 */
	public function Index($parent_id=0)
	{
		if($parent_id=='category') //url like "photos/index/category/:id"
		    $parent_id = $this->uri->segment($this->_getSegmentsOffset()+4);
	    else $parent_id = intval($parent_id); //url like "photos/index/:id"
	    
	    $data['categories'] = $this->photos_categories_model->GetChildren($parent_id,TRUE);
		
		//if no subcategories - show posts
		if(empty($data['categories']))
		{
			redirect($this->_getBaseURI()."/show/".$parent_id);
		}
		
		$data['tpl_page'] = $this->controller."/categories";

		parent::_OnOutput($data);
	}


    /**
     * Show photos.
     *
     * @param integer $category_id
     * @param integer|string $tag
     * @return void
     */
	public function Show($category_id=0,$tag=0)
	{
	    $settings = $this->settings_model;
	    
	    $category_id = intval($category_id);
	    
	    $tag = $this->security->xss_clean(trim(urldecode($tag)));
	    
        $per_page = $settings['gallery_per_page'];
        
        if($category_id) $category = $this->photos_categories_model->getOneById($category_id);

        // === Photos List === //
        $data = $this->photos_model->get($category_id,$tag,$per_page);
		
		if($category_id) $add_to_page_title = ': '.$category['category'];
		elseif($tag) $add_to_page_title = ': '.$tag;
		else $add_to_page_title = '';
		
		// === build head === //
		$this->_setPageTitle($this->_getPageTitle($this->method).$add_to_page_title);
		
		// === Current Location === //
		$data['current_location_arr'] =
		array(
			$this->_getBaseURI()."/index" => lowercase($this->_getPageTitle('index')),
			$this->_getBaseURI()."/show/$category_id/$tag" => '[page_title]'
		);

		$data['category_id'] = $category_id;
		$data['tpl_page'] = $this->_getController()."/list";
		
		parent::_OnOutput($data);
	}

}