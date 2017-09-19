<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for tags. It used for photos, news, articles etc.
 * 
 * @package tags  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Tags extends Admin 
{
	//name of table
    protected $c_table = "tags";

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Tags
     */
	public function __construct()
	{
		parent::__construct();	
		
		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('tags_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Page Titles === //
		$this->page_titles['index'] = language('tags');
		$this->page_titles['edit'] = language('edit_tags');
		//default page title
		$this->_setDefaultPageTitle();
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	/**
	 * Build right top admin menu.
	 * Overrides parent method.
	 * 
	 * @return string
	 */
	public function _built_right_menu()
	{
		return '';
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Edit tags. Tags need to be separated by comma.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$post_id = $this->segment_item;
		
		$table = $this->uri->segment($this->_getSegmentsOffset()+7);
		
		// === GET TAGS === //
		$data['tags_list'] = $this->tags_model->getPostTags($table,$post_id);
		
		$this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'tags', 
                     'label'   => language('tags'), 
                     'rules'   => 'trim|required|min_length[3]|max_length[255]|xss_clean'
                  ),
            );

		$this->form_validation->set_rules($configValidation);
			
		if ( $this->form_validation->run() == FALSE )
		{
			$data['tpl_page'] = $this->_getController().'/'.$this->_getMethod();
		    parent::_OnOutput($data);
		}
		else
		{
		    $this->tags_model->addPostTags($table,$post_id,$this->input->post('tags'));
			
			redirect($this->_getBaseURL().$table.'/index/'.$this->segment_orderby.'/'.$this->segment_orderseq.'/'.$this->segment_offset);
		}
	}
	
	// === Delete Tag === //
	/**
	 * Delete tag by ID.
	 * 
	 * @param integer $tag_id
	 * @return void
	 */
	public function Delete($tag_id)
	{//AJAX
		$this->tags_model->DeleteId($tag_id);
	}
	
}