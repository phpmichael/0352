<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for links.
 * 
 * @package links  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Links extends Front 
{
	// +++++++++++++ INNER METHODS +++++++++++++++ //


	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //

	/**
	 * Show paginated links list.
	 * 
	 * @return void
	 */
	public function Index()
	{
        // === Init Language Section === //
		$this->lang_model->init(array('label','front'));
	    
	    // === Load Models === //
		$this->load->model('links_model');
		
		// --- PAGINATION --- //
        $per_page = 15;

        // Fetch the total number of DB rows
		$total_rows = $this->links_model->countAll();

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

        $data['links_records'] = $this->links_model->get(false,'id','ASC',$per_page,$this->uri->segment($this->_getSegmentsOffset()+3));

		parent::_OnOutput($data);
	}
    
	/**
	 * Redirect user to website by link's ID.
	 * 
	 * @param inreger $link_id
	 * @return void
	 */
    public function Go($link_id)
    {
        // === Load Models === //
		$this->load->model('links_model');
        
        //check if there is link ID
        if(!($link_id = intval($link_id))) show_404($this->_getBaseURI().'/'.$this->_getMethod().'/'.$link_id);
        
        $record = $this->links_model->getOneById($link_id);
        
        //check if there is record with link ID
        if(!$record) show_404($this->_getBaseURI().'/'.$this->_getMethod().'/'.$link_id);
        
        //redirect on site
        header("Location:".prep_url($record['link']));
    }

}