<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for Videos.
 * 
 * @package videos  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Videos extends Front 
{
	//name of table
	protected $c_table = 'videos';

    /**
     * Init required models, helpers, language sections, pages' titles, css files etc.
     *
     * @return \Videos
     */
    public function __construct()
	{
		parent::__construct();
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front'));
		
		// === Load Models === //
		$this->load->model('videos_model');
		
		$this->load->helper('video');
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //


	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //

	/**
	 * Show paginated Videos list.
	 * 
	 * @return void
	 */
	public function Index()
	{
        // Fetch the total number of DB rows
		$total_rows = $this->videos_model->countAll();

		$this->load->library('pagination');

		// Pagination!
		$this->pagination->initialize(
		array(
				'base_url'		 => base_url().$this->_getBaseURI()."/index",
				'total_rows'	 => $total_rows,
				'per_page'		 => $this->per_page,
				'uri_segment'	 => $this->_getSegmentsOffset()+3,
				'full_tag_open'	 => '<p>',
				'full_tag_close' => '</p>',
				'first_link'     => language('pagination_first'),
				'last_link'     => language('pagination_last'),
				)
		);

		$data['paginate'] = $this->pagination->create_links();
		
		$data['videos_records'] = $this->videos_model->get('1','pub_date','ASC',$this->per_page,$this->uri->segment($this->_getSegmentsOffset()+3));

		parent::_OnOutput($data);
	}
	
	/**
	 * Show video.
	 * 
	 * @param string(16) $data_key
	 * @return void
	 */
	public function View($data_key)
	{
		$this->load->helper('text');
		
		// === DB query === //
		$data['video'] = $this->videos_model->getOneById($data_key);
		
		if(!$data['video']) show_404($this->_getBaseURI().'/'.$this->_getMethod().'/'.$data_key);
		
		// === build head === //
		$this->_setPageTitle($data['video']['title']);
		$this->_buid_head_data(array("page_title"=>$this->_getPageTitle(),"meta_keywords"=>"","meta_description"=>$data['video']['description']));

		$data['current_location_arr'] =
		array(
			$this->_getBaseURL()."videos"=>language('videos'),
			$this->_getBaseURL()."videos/view/".$data['video']['data_key']=>character_limiter($this->_getPageTitle(),100)
		);

		parent::_OnOutput($data);
	}

}