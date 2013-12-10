<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for comments.
 * 
 * @package comments  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Comments extends Admin 
{
	//name of table
    protected $c_table = "comments";
	//show records per page
    protected $per_page = 10;

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Comments
     */
	public function __construct()
	{
		parent::__construct();

		// RELOAD: Segments for OrderBy/OrderSeq/Offset/Item
		$this->segment_orderseq = $this->uri->segment($this->_getSegmentsOffset()+4,'desc');

		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('comments_model');
		
		// === Load Helpers === //
		$this->load->helper('text');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin','comments'));
		
		// === Labels === //
		$this->fields_titles['table'] = 'table';
		$this->fields_titles['comment_author'] = language('name');
		$this->fields_titles['comment_author_email'] = language('email');
		$this->fields_titles['comment_author_url'] = language('url');
		$this->fields_titles['comment_author_ip'] = language('ip_address');
		$this->fields_titles['comment_content'] = language('comment');
		$this->fields_titles['comment_date'] = language('date');
		$this->fields_titles['comment_approved'] = language('approved');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('comments');
		$this->page_titles['edit'] = language('edit');
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
		return "";
	}
	
	/**
	 * Validate and insert or update data.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsert(array $record=array())
	{
		$this->load->library('form_validation');
		
		$id = intval(@$record['id']);
		
		if( $id )
		{
			$configValidation = array(
               array(
                     'field'   => 'comment_author', 
                     'label'   => parent::_getFieldTitle('comment_author'), 
                     'rules'   => 'required|min_length[3]|xss_clean'
                  ),
               array(
                     'field'   => 'comment_author_email', 
                     'label'   => parent::_getFieldTitle('comment_author_email'), 
                     'rules'   => 'required|valid_email|xss_clean'
                  ),
               array(
                     'field'   => 'comment_author_url', 
                     'label'   => parent::_getFieldTitle('comment_author_url'), 
                     'rules'   => 'xss_clean|prep_url'
                  ),
               array(
                     'field'   => 'comment_content', 
                     'label'   => parent::_getFieldTitle('comment_content'), 
                     'rules'   => 'required|min_length[3]|xss_clean'
                  )
            );
		}

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			$record['tpl_page'] = $this->_getController().'/add';
		    parent::_OnOutput($record);
		}
		else
		{
			$post = array_merge($record,$_POST);
			
			$this->comments_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI());
		}
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Edit comment.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->comments_model->getOneById($id);
		
		$this->_processInsert($record);
	}

}