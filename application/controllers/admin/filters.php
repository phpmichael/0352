<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for filters.
 * 
 * @package filters  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Filters extends Admin 
{
	//name of table
    protected $c_table = "filters_groups";
    //show records per page, by default all
	protected $per_page = 9999;

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Filters
     */
	public function __construct()
	{
		parent::__construct();
		
		// RELOAD: Segments for OrderBy/OrderSeq/Offset/Item
		$this->segment_orderby = $this->uri->segment($this->_getSegmentsOffset()+3,'sort');

		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('filters_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin','filters'));
		
		// === Labels === //
		$this->fields_titles['filter_group_id'] = language('group');
		$this->fields_titles['title'] = language('title');
		$this->fields_titles['code'] = language('code');
		$this->fields_titles['query'] = language('query');
		$this->fields_titles['active'] = language('active');
		$this->fields_titles['connector'] = language('connector');
		$this->fields_titles['section'] = language('section');
		$this->fields_titles['panel'] = 'Panel';
		$this->fields_titles['sort'] = 'Sort';
		
		// === Page Titles === //
		$this->page_titles['index'] = language('filters_groups');
		$this->page_titles['add'] = language('add_group');
		$this->page_titles['edit'] = language('edit_group');
		$this->page_titles['filters_list'] = language('filters_list');
		$this->page_titles['filters_add'] = language('add_filter');
		$this->page_titles['filters_edit'] = language('edit_filter');
		//default page title
		$this->_setDefaultPageTitle();
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //

	/**
	 * Validate and insert or update filter group.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsertGroup(array $record=array())
	{
	    $this->load->library('form_validation');
		
		$configValidation = array( 
		      array(
                     'field'   => 'active', 
                     'label'   => parent::_getFieldTitle('active'), 
                     'rules'   => 'required|is_natural'
                  ),
               array(
                     'field'   => 'section', 
                     'label'   => parent::_getFieldTitle('section'), 
                     'rules'   => 'required|max_length[100]|xss_clean'
                  ),
              array(
                     'field'   => 'connector', 
                     'label'   => parent::_getFieldTitle('section'), 
                     'rules'   => 'required|alphanum|min_length[2]|max_length[3]'
                  )
            );
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "title[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('title')." ({$lang_code})", 
                     'rules'   => 'trim|required|max_length[255]|xss_clean'
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
			
			$this->filters_model->insertOrUpdateGroup($post);
			
			redirect($this->_getBaseURI());
		}
	}
	
	/**
	 * Validate and insert or update filter.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsertFilter(array $record=array())
	{
		$this->c_table = 'filters';
	    
	    $id = intval(@$record['id']);
	    
	    $this->load->library('form_validation');
		
		$configValidation = array(
				array(
                     'field'   => 'code', 
                     'label'   => parent::_getFieldTitle('code'), 
                     'rules'   => 'trim|required|max_length[100]|alphanum|callback__unique_field_for_edit[code,'.$id.']'
                  ),
				array(
				     'field'   => 'query', 
				     'label'   => parent::_getFieldTitle('query'), 
				     'rules'   => 'required|xss_clean'
				  ),	
				array(
				     'field'   => 'active', 
				     'label'   => parent::_getFieldTitle('active'), 
				     'rules'   => 'required|is_natural'
				  )
            );
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "title[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('title')." ({$lang_code})", 
                     'rules'   => 'trim|required|max_length[100]|xss_clean'
                  );
        }

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			$record['tpl_page'] = $this->_getController().'/filters_add';
		    parent::_OnOutput($record);
		}
		else
		{
			$post = array_merge($record,$_POST);
			
			$this->filters_model->insertOrUpdateFilter($post);
			
			redirect($this->_getBaseURI()."/filters_list/".$post['filter_group_id']);
		}
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

    /**
	 * Add filter group.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsertGroup();
	}
	
	/**
	 * Edit filter group.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->filters_model->getGroupById($id);
		
		$this->_processInsertGroup($record);
	}
	
	/**
	 * Delete selected filters groups.
	 * Overrides parent method.
	 * 
	 * @return void
	 */
	public function Delete_Selected_Groups()
	{
		$this->filters_model->DeleteSelectedGroups(@$_POST['check']);

		redirect($this->_getBaseURI());
	}
	
	/**
	 * Show filters list for group.
	 * 
	 * @param integer $filter_group_id
	 * @return void
	 */
	public function Filters_List($filter_group_id)
	{
		$this->justCurrentLang = TRUE;
		
		$data['filter_group_id'] = $filter_group_id;
	    
	    $data['filters'] = $this->filters_model->getFiltersForGroup($filter_group_id);
		
		$data['tpl_page'] = $this->_getController().'/'.$this->_getMethod();
		parent::_OnOutput($data);
	}
	
	/**
	 * Add filter.
	 * 
	 * @param integer $filter_group_id
	 * @return void
	 */
	public function Filters_Add($filter_group_id)
	{
		$record['filter_group_id'] = $filter_group_id;
		$this->_processInsertFilter($record);
	}
	
	/**
	 * Edit filter.
	 * Params $mm and $nn not used. Just link should have defined format.
	 * 
	 * @param integer $filter_group_id
	 * @param mixed $mm
	 * @param mixed $nn
	 * @param integer $filter_id
	 * @return void
	 */
	public function Filters_Edit($filter_group_id,$mm,$nn,$filter_id)
	{
		// === GET RECORD === //
		$record = $this->filters_model->getOneById($filter_id);
		$record['filter_id'] = $filter_id;
		
		$this->_processInsertFilter($record);
	}
	
	/**
	 * Delete selected filters.
	 * 
	 * @param integer $filter_group_id
	 * @return void
	 */
	public function Delete_Selected_Filters($filter_group_id)
	{
		$this->filters_model->DeleteSelectedFilters(@$_POST['check'],$filter_group_id);
		
		redirect($this->_getBaseURI()."/filters_list/{$filter_group_id}");
	}
	
	/**
	 * Change groups sorting.
	 * 
	 * @return void
	 */
	public function Sort_Groups()
	{
		$this->filters_model->SortGroups($this->parseSortables());
	}

    /**
     * Change filters sorting.
     *
     * @param $filter_group_id
     * @return void
     */
	public function Sort_Filters($filter_group_id)
	{
		$this->filters_model->SortFilters($this->parseSortables(),$filter_group_id);
	}

}