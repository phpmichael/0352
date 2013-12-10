<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for groups.
 * 
 * @package customers  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Groups extends Admin 
{
	//name of table
    protected $c_table = "groups";

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Groups
     */
	public function __construct()
	{
		parent::__construct();
		
		// === Check is logged manager === //
		$this->_CheckLogged();	
		
		// === Load Models === //
		$this->load->model('groups_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin','groups'));
		
		// === Labels === //
		$this->fields_titles['name'] = language('thing_name');
		$this->fields_titles['admin_access'] = language('access_to_admin_panel');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('groups');
		$this->page_titles['add'] = language('add');
		$this->page_titles['edit'] = language('edit');
		$this->page_titles['edit_rights'] = language('edit_rights');
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
	                     'field'   => "name", 
	                     'label'   => parent::_getFieldTitle('name'), 
	                     'rules'   => 'trim|required|min_length[3]|max_length[50]|xss_clean'
	                  ),
	                array(
	                     'field'   => "admin_access", 
	                     'label'   => parent::_getFieldTitle('admin_access'), 
	                     'rules'   => 'required|numeric'
	                  )
                ); 

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			$record['tpl_page'] = $this->_getController().'/add';
		    parent::_OnOutput($record);
		}
		else
		{
			$post = array_merge($record,$_POST);
			
			$this->groups_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI());
		}
	}
	
	/**
	 * Set rights.
	 * 
	 * @param integer $group_id
	 * @param array $rights
	 * @return void
	 */
	private function _processRightsInsert($group_id,array $rights=array())
	{
		$this->load->library('form_validation');
		
		$configValidation = array(
					array(
	                     'field'   => "group_id", 
	                     'label'   => "Group ID", 
	                     'rules'   => 'required'
	                  )
                ); 

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			$data['group_id'] = $group_id;
			
			$data['tpl_page'] = $this->_getController().'/edit_rights';
		    parent::_OnOutput($data);
		}
		else
		{
			$post = $_POST;
			
			$this->groups_model->editRights($group_id,$post);
			
			redirect($this->_getBaseURI());
		}
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Add group.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit group.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->groups_model->getOneById($id);
		
		$this->_processInsert($record);
	}
	
	/**
	 * Edit group's rights.
	 * 
	 * @return void
	 */
	public function Edit_Rights()
	{
		$id = $this->segment_item;
		
		$this->_processRightsInsert($id);
	}
	
}