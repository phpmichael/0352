<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for comments.
 * 
 * @package comments  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Comments extends Front 
{
	/**
	 * Init required models, helpers, language sections, pages' titles, css files etc.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// === Load Models === //
		$this->load->model('comments_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','comments'));
		
		// === Labels === //
		$this->fields_titles['comment_author'] = language('name');
		$this->fields_titles['comment_author_email'] = language('email');
		$this->fields_titles['comment_author_url'] = language('url');
		$this->fields_titles['comment_content'] = language('comment');
		
		$this->load->helper('text');
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// === Custom validation : Start === //		
	/**
	 * Check if IP Address not exists in blacklist.
	 * 
	 * @return bool
	 */
	public function _ip_not_in_blacklist()
	{
	    return !in_array($_SERVER['REMOTE_ADDR'],array_map('trim',explode("\n",@$this->settings_model['ip_blacklist'])));
	}
	// === Custom validation : End === //

	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //
	
	/**
	 * Add new comment.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'ca', 
                     'label'   => 'Confirmation var', 
                     'rules'   => 'greater_than[0]'
                  ),
               array(
                     'field'   => 'post_id', 
                     'label'   => 'Post ID', 
                     'rules'   => 'required|numeric'
                  ),
               array(
                     'field'   => 'parent_id', 
                     'label'   => 'Parent ID', 
                     'rules'   => 'required|numeric'
                  ),
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
                     'rules'   => 'required|min_length[3]|callback__ip_not_in_blacklist|xss_clean'
                  ),
            );

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() != FALSE)
		{
			$this->comments_model->add($_POST);
			
			echo "success";
		}
		else echo validation_errors();
		
		exit;
	}

}