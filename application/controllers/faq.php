<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for F.A.Q.
 * 
 * @package faq  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Faq extends Front 
{
	// +++++++++++++ INNER METHODS +++++++++++++++ //


	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //

	/**
	 * Show paginated FAQ list.
	 * 
	 * @return void
	 */
	public function Index()
	{
        // === Init Language Section === //
		$this->lang_model->init(array('label','front'));
	    
	    // === Load Models === //
		$this->load->model('faq_model');
		
		// --- PAGINATION --- //
        $per_page = 10;

        // Fetch the total number of DB rows
		$total_rows = $this->faq_model->countAll();

		$this->load->library('pagination');

		// Pagination!
		$this->pagination->initialize(
		array(
				'base_url'		 => base_url().$this->_getBaseURI()."/index",
				'total_rows'	 => $total_rows,
				'per_page'		 => $per_page,
				'uri_segment'	 => $this->_getSegmentsOffset()+3,
				'full_tag_open'	 => '<p>',
				'full_tag_close' => '</p>',
				'first_link'     => language('pagination_first'),
				'last_link'     => language('pagination_last'),
				)
		);

		$data['paginate'] = $this->pagination->create_links();
		
		$data['faq_records'] = $this->faq_model->get('1','id','ASC',$per_page,$this->uri->segment($this->_getSegmentsOffset()+3));

		parent::_OnOutput($data);
	}

}