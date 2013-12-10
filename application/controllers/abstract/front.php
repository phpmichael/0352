<?php
require_once(APPPATH.'controllers/abstract/base.php');

/** 
 * This is basic controller for most front controllers.
 * 
 * @package base  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
abstract class Front extends Base 
{
	protected $panel = "front";
    
    //get text just for current language
    protected $justCurrentLang = TRUE;
    
    //head data
    protected $head = array();

    /**
     * Init models, set theme, load some vars in view.
     *
     * @return \Front
     */
	public function __construct()
	{
		parent::__construct();
		
		//if section not enabled - show 404 not found
		if( !$this->_CheckIfSectionEnabled() ) show_404($this->input->server('REQUEST_URI'));
		
		// === Load Models === //
		$this->load->model('pages_model');
		$this->load->model('menu_model');
		
		// === Set Theme ==== //
		$this->_setTheme();
	}


	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// === Custom validation : Start === //
	
	// === Custom validation : End === //
	
	/**
	 * Check if section enabled in settings.
	 *
	 * @return bool
	 */
	private function _CheckIfSectionEnabled()
	{
		$this->load->model('groups_model');
		
		$section = $this->_getController();
		
		if( in_array($section,array('pages','app_js')) ) return TRUE;
		elseif( $this->groups_model->isAvailabeSection($section,'front') ) return TRUE;
		else return FALSE;
	}
	
	/**
	 * Set page title and meta data.
	 * 
	 * @param array $params
	 * @return bool
	 */
	protected function _buid_head_data( array $params = array() )
	{
		if(!empty($this->head)) return FALSE;
		
		$settings = $this->settings_model;
		$head = array('site_title'=>$settings['site_title_'.strtoupper(parent::_getInterfaceLang(TRUE))]);
		
		if( $this->controller!='pages' )
		{
			$link = $this->controller;
			if( $this->method!='index' ) $link .= '/'.$this->method;
		}
		else 
		{
			$slug = $this->uri->segment($this->_getSegmentsOffset()+2);
			if($slug) $link = 'page/'.$slug;
			else $link = '';
		}
		
		if( $params )
		{
			$head['page_title'] = @$params['page_title'];
			$head['meta_keywords'] = @$params['meta_keywords'];
			$head['meta_description'] = @$params['meta_description'];
		}
		elseif( $page = $this->pages_model->getByLink($link) )
		{
			//$head['page_title'] = $page['page_title'];
			$head['page_title'] = ($this->_getPageTitle())?$this->_getPageTitle():$page['page_title'];
			$head['meta_keywords'] = $page['meta_keywords'];
			$head['meta_description'] = $page['meta_description'];
		}
		else 
		{
			$head['page_title'] = $this->_getPageTitle();
			$head['meta_keywords'] = $settings['meta_keywords_'.strtoupper(parent::_getInterfaceLang(TRUE))];
			$head['meta_description'] = $settings['meta_description_'.strtoupper(parent::_getInterfaceLang(TRUE))];
		}
		
		//replace special characters
		$head['page_title'] = @strip_tags($head['page_title']); // remove "&", "<" and ">"
		$head['meta_keywords'] = @htmlspecialchars($head['meta_keywords'],ENT_QUOTES); // "'",""", "&", "<" and ">"
		$head['meta_description'] = @htmlspecialchars($head['meta_description'],ENT_QUOTES); // "'",""", "&", "<" and ">"
		
		$this->head = $data['head'] = $head;
		
		$this->_setPageTitle($head['page_title']);

		// === LOAD VARS TO ALL VIEWERS === //
		$this->load->vars($data);

        return TRUE;
	}
	
	/**
	 * Append additional page title for list pages (like: products list/search, articles list/search, news list/search, companies list/search etc)
	 *
	 * @param array $filter_data
	 * @param array $data
	 */
	protected function appendPageTitleForListPages(array $filter_data, array $data)
	{
	    if( isset($filter_data['keywords']) && trim(urldecode($filter_data['keywords'])) )// if search smth
		{ 
		   $page_title = language('search_results_for').' "'.trim(urldecode($filter_data['keywords'])).'"';
		}
		elseif( isset($filter_data['tag']) && trim(urldecode($filter_data['tag'])) )// if tag selected
		{ 
		   $page_title = language($this->controller.'_with_tag').' "'.trim(urldecode($filter_data['tag'])).'"';
		}
		elseif( isset($filter_data['category']) && $filter_data['category'] ) //if category selected
	    {
	       $page_title = language('category').' "'.@$data['search_category_title'].'"';
	    }
	    elseif( isset($filter_data['manufacturer_id']) && $filter_data['manufacturer_id'] ) //if manufacturer_id selected
	    {
	       $page_title = language('manufacturer').' "'.$this->products_manufacturers_model->getManyfacturerName($filter_data['manufacturer_id']).'"';
	    }
	    elseif( isset($filter_data['manufacturer']) && trim(urldecode($filter_data['manufacturer'])) )// if manufacturer selected
		{ 
		   $page_title = language('manufacturer').' "'.trim(urldecode($filter_data['manufacturer'])).'"';
		}
		else $page_title = '';
		
		$this->_appendToPageTitle($page_title);
	}

	/**
	 * Make breadcrumb.
	 * 
	 * @param $current_location_arr
	 * @return string
	 */
	protected function _build_cur_location($current_location_arr)
	{
		$current_location_str = "";

		foreach ($current_location_arr as $uri=>$title)
		{
		    if($uri==$this->_getBaseURL()) $link = "<a href='".base_url().$this->_getBaseURL()."'>{$title}</a>";
		    else $link = anchor($uri,$title,"");
		    $current_location_str .= $link." > ";
		}

		return substr($current_location_str,0,-3);
	}
	
	/**
	 * Check is customer logined.
	 * 
	 * @return bool
	 */
	protected function _is_logged()
	{
		return $this->session->userdata('customer_logged_in');
	}

	/**
	 * Redirect not logined customer to login page.
	 * 
	 * @return void
	 */
	protected function _CheckLogged()
	{
		if(!$this->_is_logged())
		{
			redirect($this->_getBaseURL()."customers/signin");
		}
	}
	
	/**
	 * Preparate data before output view.
	 * 
	 * @param array $data
	 * @return void
	 */
	protected function _OnOutput( array $data = array() )
	{
	    // === Set page title and meta data === //
		$this->_buid_head_data();
	    
	    if( !isset($data['current_location_arr']) || empty($data['current_location_arr']) )
		{
		    $last_link = $this->_getBaseURL().$this->controller.( ($this->method!='index') ? '/'.$this->method : '');
			
			$data['current_location_arr'] = array(
				$this->_getBaseURL() => language('home_page'),
				$last_link => lowercase($this->_getPageTitle())
			);
		}
		else 
		{
		    foreach ($data['current_location_arr'] as $url=>&$loc)
		    {
		        $loc = str_replace('[page_title]',lowercase($this->_getPageTitle()),$loc);
		        
		        //fix for home page
		        if(preg_match("#^page/$#",$url)) $data['current_location_arr'] = array();
		    }
		    
		    $data['current_location_arr'] = array_merge( array($this->_getBaseURL()=>language('home_page') ),$data['current_location_arr']);
		}
		
		$data['current_location_str'] = $this->_build_cur_location($data['current_location_arr']);
		
		// === VIEW === //
		parent::_OnOutput($data);
	}
	
	/**
	 * Check if loaded home page.
	 *
	 * @return bool
	 */
	public function is_home_page()
    {
        if( $this->_getController()=='pages' && $this->is_home_page == TRUE ) return TRUE;
        return FALSE;
    }
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //


	// ============= ACTION METHODS ================ //
}