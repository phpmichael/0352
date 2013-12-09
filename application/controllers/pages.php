<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for pages.
 * 
 * @package pages  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Pages extends Front 
{
	protected $is_home_page = FALSE;
    
    // +++++++++++++ INNER METHODS +++++++++++++++ //


	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //

	/**
	 * Show page.
	 * 
	 * @param string $slug
	 * @return void
	 */
	public function Index($slug='')
	{
	    //$this->output->enable_profiler(TRUE);
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front'));
		
		// === GET RECORD === //
		if(!$slug) 
		{
		    $data = $this->pages_model->getOneById(1);
		    $this->is_home_page = TRUE;
		}
		else $data = $this->pages_model->getBySlug($slug);
		
		//if no page
		if(empty($data)) show_404($this->input->server('REQUEST_URI'));

		// === Main Data === //
		$data['tpl_page'] = $this->_getController().'/page';
		
		$current_location_arr =
		array(
			$this->_getInterfaceLang()."/page/".$slug=>'[page_title]'
		);
		
		if(!$slug) unset($current_location_arr[0]);

		$current_location_arr = array_unique($current_location_arr);

		$data['current_location_arr'] = $current_location_arr;

		parent::_OnOutput($data);
	}

}