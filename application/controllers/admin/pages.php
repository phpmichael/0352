<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for pages.
 * 
 * @package pages  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Pages extends Admin 
{
	//name of table
    protected $c_table = "pages";
	//show records per page
	protected $per_page = 15;

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Pages
     */
	public function __construct()
	{
		parent::__construct();

		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('pages_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Labels === //
		$this->fields_titles['page_title'] = language('title');
		$this->fields_titles['slug'] = language('page_slug');
		$this->fields_titles['meta_keywords'] = language('meta_keywords');
		$this->fields_titles['meta_description'] = language('meta_description');
		$this->fields_titles['is_content'] = language('content_page_short');
		$this->fields_titles['body'] = language('page_content');
		$this->fields_titles['link'] = language('link');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('pages');
		$this->page_titles['add'] = language('add_page');
		$this->page_titles['edit'] = language('edit_page');
		//default page title
		$this->_setDefaultPageTitle();
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	/**
	 * Validate and insert or update data.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsert(array $record=array())
	{
		/*if( isset($_POST['page_title']) && !isset($record['slug']) )
		{
			// === Make Slug === //
			$_POST['slug'] = $this->pages_model->doSlug($_POST['page_title']);
		}*/
		
		if( isset($_POST['page_title']) )
		{
			// === Make Slug === //
			foreach (get_multilang_codes() as $lang_code)
			{
			    $_POST['slug'][$lang_code] = $this->pages_model->doSlug($_POST['page_title'][$lang_code]);
			}
		}
		
		$slug_lang_id = intval(@$record['slug_lang_id']);
	    
	    $this->load->library('form_validation');
		
		$configValidation = array();
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "page_title[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('page_title')." ({$lang_code})", 
                     'rules'   => 'trim|required|min_length[3]|max_length[250]|xss_clean'
                  );
                  
            $configValidation[] = array(
                     'field'   => "slug[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('slug')." ({$lang_code})", 
                     'rules'   => 'trim||max_length[250]|callback__unique_slug['.$lang_code.','.$this->c_table.','.$slug_lang_id.']'
                  );
                  
            $configValidation[] = array(
                     'field'   => "meta_keywords[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('meta_keywords')." ({$lang_code})", 
                     'rules'   => 'trim|xss_clean'
                  );
                  
            $configValidation[] = array(
                     'field'   => "meta_description[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('meta_description')." ({$lang_code})", 
                     'rules'   => 'trim|xss_clean'
                  );
                  
            $configValidation[] = array(
                     'field'   => "body[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('body')." ({$lang_code})", 
                     'rules'   => 'trim'
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
			
			$this->pages_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI());
		}
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

    /**
	 * Add content page.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$record['is_content'] = "yes";
		
		$this->_processInsert($record);
	}
	
	/**
	 * Edit page.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->pages_model->getOneById($id);
		
		$this->_processInsert($record);
	}

}