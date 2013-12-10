<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for news.
 * 
 * @package news  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class News extends Front 
{
	//name of table
	protected $c_table = 'news';
    
	/**
	 * Init required models, helpers, language sections, pages' titles, css files etc.
	 * 
	 * @return \News
	 */
    public function __construct()
	{
		parent::__construct();
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','news','comments'));
		
		// === Load Models === //
		$this->load->model('news_model');
		$this->load->model('news_categories_model');
        $this->load->model('tags_model');
        $this->load->model('comments_model');
        
        // === Page Titles === //
		$this->page_titles['index'] = language('news');
		//default page title
		$this->_setDefaultPageTitle();
        
		// === Load Helpers === //
        $this->load->helper('customer');
        $this->load->helper('comments');
        $this->load->helper('blog');
        
        $this->includeCommentsAndRatingsFiles();
        
		$data['blog_model'] = 'news';
        
        //Load Vars
		$this->load->vars($data);
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //


	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //

	/**
	 * Use Index action.
	 * 
	 * @param string $tag
	 * @return void
	 */
    public function Tag($tag='')
	{
		if($tag=='ALL') $tag = 0;

		redirect($this->_getBaseURI().'/index/tag/'.$tag);
	}
	
	public function Calendar($year,$month)
	{
		redirect($this->_getBaseURI().'/index/year/'.$year.'/month/'.$month);
	}

	/**
	 * Show paginated news list.
	 * 
	 * @return void
	 */
	public function Index()
	{
	    if($keywords = $this->input->post('keywords')) $filter_data['keywords'] = $keywords;
	    elseif($keywords = $this->input->get('keywords')) $filter_data['keywords'] = $keywords;
		else $filter_data = $this->uri->uri_to_assoc($this->_getSegmentsOffset()+3);
        
        $this->load->helper('text');
        
        // === News List === //
        $data = $this->news_model->get($this->_getMethod(), $filter_data);
        
        $data = array_merge($data,$filter_data);
        
        // === Current Location === //
		$current_location_arr = 
		array(
			$this->_getBaseURI()=>$this->_getPageTitle()
		);
		
		// === Categories Location === //
		$categories_location_arr = $this->news_categories_model->GetLocation(@$filter_data['category'],'news');
		$current_location_arr = array_merge($current_location_arr,$categories_location_arr);
		
		$data['current_location_arr'] = $current_location_arr;
        
        //add search category info
		if(@$filter_data['category']) $data = array_merge($data,$this->news_categories_model->getSearchCategoryData(@$filter_data['category']));
		
		//generate additional page title
		$this->appendPageTitleForListPages($filter_data,$data);

		parent::_OnOutput($data);
	}

	/**
	 * Show news by slug.
	 *
	 * @param string $slug
	 * @return void
	 */
	public function Name($slug)
	{
	    $data = $this->news_model->getBySlug($slug);
	    
	    //if no page
		if(empty($data)) show_404($this->_getBaseURI().'/'.$this->_getMethod().'/'.$slug);
	    
	    $this->Details($data['id']);
	}

	/**
	 * Show news full information.
	 * 
	 * @param integer $id
	 * @return void
	 */
	public function Details($id)
	{
		$this->load->helper('text');

		// === DB query === //
		$data['news'] = $this->news_model->getOneById($id);
		
		if(!$data['news']) show_404($this->_getBaseURI().'/'.$this->_getMethod().'/'.$id);
		
		// === build head === //
		$this->_setPageTitle($data['news']['head']);
		$this->_buid_head_data(array("page_title"=>$this->_getPageTitle(),"meta_keywords"=>'',"meta_description"=>''));

		$data['current_location_arr'] =
		array(
			$this->_getBaseURL()."news"=>language('news'),
			$this->_getBaseURL()."news/name/".$data['news']['slug']=>character_limiter($this->_getPageTitle(),75)
		);

		parent::_OnOutput($data);
	}
    
	/**
	 * Show news RSS (last 10 latest records ).
	 * 
	 * @return void
	 */
    public function RSS()
	{
        $this->load->helper('text');

        // === News List === //
        $data = $this->news_model->get();
        
        // === Set page title and meta data === //
		$this->_buid_head_data();
		
		// === VIEW === //
		load_theme_view($this->_getFolder().$this->_getController()."/RSS",$data);
	}

}