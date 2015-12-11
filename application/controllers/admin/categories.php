<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for categories.
 * 
 * @package messageboard  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 * @property Categories_model $model
 */
class Categories extends Admin 
{
	//name of table
    protected $c_table = "categories_list";
    //show records per page, by default all
	protected $per_page = 9999;
	//this is for display subcategories, by default show root categories
	protected $parent_id = 0;
	//what categories model used
	protected $model;

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @param string $model
     * @return \Categories
     */
	public function __construct($model = 'categories_model')
	{
		parent::__construct();
		
		if($this->segment_orderby=='id') $this->segment_orderby = 0;
		$this->parent_id = $this->uri->segment($this->_getSegmentsOffset()+3,0);

		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model($model);
		$this->model = $this->$model;
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Labels === //
		$this->fields_titles['category'] = language('category');
		$this->fields_titles['description'] = language('description');
		$this->fields_titles['parent_id'] = language('parent_id');
		$this->fields_titles['sort'] = language('sort');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('categories');
		$this->page_titles['add'] = language('add');
		$this->page_titles['edit'] = language('edit');
		//default page title
		$this->_setDefaultPageTitle();
	}
	
	
	/**
	 * Build right top admin menu.
	 * Overrides parent method.
	 * 
	 * @return string
	 */
	public function _built_right_menu()
	{
		$menu = "<li><span class='css3-icon css3-icon-list'>".anchor($this->_getBaseURI().'/index', language('show_list'))."</span></li>";
		$menu .= "<li><span class='css3-icon css3-icon-add'>".anchor($this->_getBaseURI().'/add/'.$this->parent_id,  language('add'))."</span></li>";

		return $menu;
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	/**
	 * Validate and insert or update data.
	 * 
	 * @param array $record
	 * @return void
	 */
	protected function _processInsert(array $record=array())
	{
		$this->load->library('form_validation');
		
		$configValidation = array();
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "category[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('category')." ({$lang_code})", 
                     'rules'   => 'trim|required|min_length[3]|max_length[250]|xss_clean'
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
			
			$post['parent_id'] = $this->parent_id;
			
			$this->model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI()."/index/".$this->parent_id);
		}
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

    /**
	 * Show list with records by search criterias.
	 * Overrides parent method.
	 * 
	 * @return void
	 */
	public function Index()
	{
		$data = parent::_ListData($this->_getPageTitle($this->method), 1000, "parent_id = ".$this->db->escape_str($this->parent_id), "", $this->parent_id."/", "sort", "asc");

		$data['tpl_page'] = $this->_getController().'/list';
		parent::_OnOutput($data);
	}
	
	/**
	 * Add category.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit category.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		//$this->parent_id = $this->uri->segment($this->_getSegmentsOffset()+5,0);
	    
	    $id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->model->getOneById($id);
		
		$this->_processInsert($record);
	}
	
	/**
	 * Change categories' sorting.
	 * 
	 * @return void
	 */
	public function Sort()
	{
		$this->model->Sort($this->parseSortables(),$this->parent_id);
	}
	
	/**
	 * Delete records by posted checked records' array.
	 * Overrides parent method.
	 * 
	 * @return void
	 */
	public function Delete_Selected()
	{
		$this->model->DeleteSelected(@$_POST['check'],$this->parent_id);

		// === REDIRECT === //
		redirect($this->_getBaseURI()."/index/{$this->parent_id}/");
	}
	
	
	
	
	
	
	public function Tree()
	{
        /*$this->load->model('articles_categories_model');
        //get children categories array
        $categories = $this->articles_categories_model->getTree(0);
	    dump($categories);exit;*/
	    
	    parent::_OnOutput();
	}

}