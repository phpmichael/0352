<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for tile.
 * 
 * @package tile  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Tile extends Front 
{
	//name of table
    protected $c_table = "tile";
    protected $process_form_html_id = "tile"; 
    protected $process_form_id;

    /**
     * Init required models, helpers, language sections, pages' titles, css files etc.
     *
     * @return \Tile
     */
    public function __construct()
	{
		parent::__construct();
		
		// === Load Models === //
		$this->load->model(array('tile_model','formbuilder_model'));
		//$this->load->model('tags_model');
		//$this->load->model('comments_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','comments'));
		
		//ID of form
		$this->process_form_id = $this->formbuilder_model->getFormIdByHtmlId($this->process_form_html_id);
		
		// === Page Titles === //
		$this->page_titles['index'] = $this->formbuilder_model->getFormTitle($this->process_form_id);
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
	 * Show tile list by filter.
	 * 
	 * @return void
	 */
	public function Index()
	{
		// === Filter Data === //
		$filter_data = $this->tile_model->getFilterData();
		
		// === Posters === //
		$data = $this->tile_model->get("index", $filter_data);
		
		$data = array_merge($data,$filter_data);

		$data['tpl_page'] = $this->_getController()."/list";

		// === Current Location === //
		$current_location_arr =
		array(
			$this->_getBaseURI()=>$this->_getPageTitle()
		);
		
		$data['current_location_arr'] = $current_location_arr;
		
		//generate additional page title
		$this->appendPageTitleForListPages($filter_data,$data);
		
		parent::_OnOutput($data);
	}
	
	/**
	 * Show tile's full information.
	 * 
	 * @param string(16) $data_key
	 * @return void
	 */
	public function View($data_key)
	{
	    // === GET RECORD === //
	    $data = $this->tile_model->getOneById($data_key);
	    
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