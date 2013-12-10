<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for admin menu.
 * 
 * @package menu  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Menu extends Admin 
{
    //name of table
	protected $c_table = "menu";

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Menu
     */
	public function __construct()
	{
		parent::__construct();

		// RELOAD: Segments for OrderBy/OrderSeq/Offset/Item
		$this->segment_orderby = $this->uri->segment($this->_getSegmentsOffset()+3,'sort');
		$this->segment_orderseq = $this->uri->segment($this->_getSegmentsOffset()+4,'asc');

		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('menu_model');
		$this->load->model('pages_model');
		$this->load->model('lang_gen_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Labels === //
		$this->fields_titles['name'] = language('thing_name');
		$this->fields_titles['link'] = language('link');
		$this->fields_titles['menu'] = language('menu');
		$this->fields_titles['page'] = language('page');
		$this->fields_titles['sort'] = language('sort');
		
		// === Page Titles === //
		$this->page_titles['add'] = language('add');
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
		$menu = "<li><span class='css3-icon css3-icon-list'>".anchor($this->_getBaseURI().'/left', language('left_menu'))."</span></li>";
		$menu .= "<li><span class='css3-icon css3-icon-list'>".anchor($this->_getBaseURI().'/bottom', language('bottom_menu'))."</span></li>";
		if(userAccess($this->_getController(),'add')) $menu .= "<li><span class='css3-icon css3-icon-add'>".anchor($this->_getBaseURI().'/add',  language('add'))."</span></li>";

		return $menu;
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
		
		$configValidation = array(
               /*array(
                     'field'   => 'name', 
                     'label'   => parent::_getFieldTitle('name'), 
                     'rules'   => 'trim|required|max_length[255]|xss_clean'
                  ),*/
                array(
                     'field'   => 'link', 
                     'label'   => parent::_getFieldTitle('link'), 
                     'rules'   => 'trim|xss_clean'
                  ),
                array(
                     'field'   => 'menu', 
                     'label'   => parent::_getFieldTitle('menu'), 
                     'rules'   => 'trim|required|xss_clean'
                  )
            );
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "name[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('name')." ({$lang_code})", 
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
			
			$this->menu_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI()."/".$this->input->post('menu'));
		}
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

	/**
	 * Call Left action.
	 * 
	 * @return void
	 */
	public function Index()
	{
		$this->left();
	}

	/**
	 * Show sorted list of items in left menu.
	 * 
	 * @return void
	 */
	public function Left()
	{
		$data = parent::_ListData(language('left_menu'), 9999, "menu = 'left'");

		$data['menu'] = 'left';

		$data['tpl_page'] = $this->_getController().'/list';
		parent::_OnOutput($data);
	}

	/**
	 * Show sorted list of items in bottom menu.
	 * 
	 * @return void
	 */
	public function Bottom()
	{
		$data = parent::_ListData(language('bottom_menu'), 9999, "menu = 'bottom'");

		$data['menu'] = 'bottom';

	    $data['tpl_page'] = $this->_getController().'/list';
		parent::_OnOutput($data);;
	}

	/**
	 * Add menu item.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit menu item.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->menu_model->getOneById($id);
		
		$this->_processInsert($record);
	}

    /**
     * Change menu sorting.
     *
     * @param $menu
     * @return void
     */
	public function Sort($menu)
	{
		$this->menu_model->Sort($this->parseSortables(),$menu);
	}
	
	/**
	 * Delete selected menu items.
	 * Overrides parent method.
	 * 
	 * @return void
	 */
	public function Delete_Selected()
	{
		$menu = $this->uri->segment($this->_getSegmentsOffset()+3);
		
		$this->menu_model->DeleteSelected(@$_POST['check'],$menu);

		// === REDIRECT === //
		redirect($this->_getBaseURI()."/".$menu);
	}

}