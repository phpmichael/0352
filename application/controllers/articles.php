<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for articles.
 * 
 * @package articles  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Articles extends Front 
{
	//name of table
	protected $c_table = 'articles';
    
	/**
	 * Init required models, helpers, language sections, pages' titles, css files etc.
	 * 
	 * @return void
	 */
    public function __construct()
	{
		parent::__construct();
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','articles','comments'));
		
		// === Load Models === //
		$this->load->model('articles_model');
		$this->load->model('articles_categories_model');
        $this->load->model('tags_model');
        $this->load->model('comments_model');
        
        // === Page Titles === //
		$this->page_titles['index'] = language('articles');
		//default page title
		$this->_setDefaultPageTitle();
        
		// === Load Helpers === //
        $this->load->helper('customer');
        $this->load->helper('comments');
        $this->load->helper('blog');
        
        $this->includeCommentsAndRatingsFiles();
        
		$data['blog_model'] = 'articles';
        
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
	 * Show paginated articles list.
	 * 
	 * @return void
	 */
	public function Index()
	{
	    if( $keywords = $this->input->post('keywords') ) $filter_data['keywords'] = $keywords;
	    elseif( $keywords = $this->input->get('keywords') ) $filter_data['keywords'] = $keywords;
		else $filter_data = $this->uri->uri_to_assoc($this->_getSegmentsOffset()+3);
        
        $this->load->helper('text');
        
        // === Articles List === //
        $data = $this->articles_model->get($this->_getMethod(),$filter_data);
        
        $data = array_merge($data,$filter_data);
        
        // === Currenr Location === //
		$current_location_arr = 
		array(
			$this->_getBaseURI()=>$this->_getPageTitle()
		);
		
		// === Categories Location === //
		$categories_location_arr = $this->articles_categories_model->GetLocation(@$filter_data['category'],'articles');
		$current_location_arr = array_merge($current_location_arr,$categories_location_arr);
		
		$data['current_location_arr'] = $current_location_arr;
        
        //add search category info
		if(@$filter_data['category']) $data = array_merge($data,$this->articles_categories_model->getSearchCategoryData(@$filter_data['category']));
		
		//generate additional page title
		$this->appendPageTitleForListPages($filter_data,$data);

		parent::_OnOutput($data);
	}
	
	/**
	 * Show article by slug.
	 *
	 * @param string $slug
	 * @return void
	 */
	public function Name($slug=FALSE)
	{
	    if(!$slug) redirect($this->_getBaseURI());
		
		$data = $this->articles_model->getBySlug($slug);
	    
	    //if no page
		if(empty($data)) show_404($this->input->server('REQUEST_URI'));
	    
	    $this->Details($data['id']);
	}

	/**
	 * Show article full information.
	 * 
	 * @param integer $id
	 * @return void
	 */
	public function Details($id)
	{
		$this->load->helper('text');
		
		// === DB query === //
		$data['article'] = $this->articles_model->getOneById($id);
		
		if(!$data['article']) show_404($this->input->server('REQUEST_URI'));
		
		// === build head === //
		$this->_setPageTitle($data['article']['head']);
		$this->_buid_head_data(array("page_title"=>$this->_getPageTitle(),"meta_keywords"=>$data['article']['meta_keywords'],"meta_description"=>$data['article']['meta_description']));

		$data['current_location_arr'] =
		array(
			$this->_getBaseURL()."articles"=>language('articles'),
			$this->_getBaseURL()."articles/name/".$data['article']['slug']=>character_limiter($this->_getPageTitle(),100)
		);

		parent::_OnOutput($data);
	}
    
	/**
	 * Show articles RSS (last 10 latest records ).
	 * 
	 * @return void
	 */
    public function RSS()
	{
        $this->load->helper('text');

        // === Articles List === //
        $data = $this->articles_model->get();
        
        // === Set page title and meta data === //
		$this->_buid_head_data();
		
		// === VIEW === //
		load_theme_view($this->_getFolder().$this->_getController()."/RSS",$data);
	}
	
	/*public function Calendar($year=false,$month=false)
	{
		$data['calendar_box'] = $this->articles_model->buildCalendarBox($year,$month);
		
		parent::_OnOutput($data);
	}*/

}