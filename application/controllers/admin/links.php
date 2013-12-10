<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for links.
 * 
 * @package links  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Links extends Admin 
{
	//name of table
    protected $c_table = "links";
	//show records per page
    protected $per_page = 15;

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Links
     */
	public function __construct()
	{
		parent::__construct();
		
		// === Check is logged manager === //
		$this->_CheckLogged();	
		
		// === Load Models === //
		$this->load->model('links_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Labels === //
		$this->fields_titles['name'] = language('thing_name');
		$this->fields_titles['link'] = language('link');
		$this->fields_titles['description'] = language('description');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('links');
		$this->page_titles['add'] = language('add');
		$this->page_titles['edit'] = language('edit');
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
		$this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'link', 
                     'label'   => parent::_getFieldTitle('link'), 
                     'rules'   => 'trim|required|min_length[4]|xss_clean'
                  )
            );
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "name[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('name')." ({$lang_code})", 
                     'rules'   => 'trim|required|min_length[3]|max_length[255]|xss_clean'
                  );
                  
            $configValidation[] = array(
                     'field'   => "description[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('description')." ({$lang_code})", 
                      'rules'   => 'trim|xss_clean'
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
			
			$this->links_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI());
		}
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Add link.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit link.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->links_model->getOneById($id);
		
		$this->_processInsert($record);
	}
	
}