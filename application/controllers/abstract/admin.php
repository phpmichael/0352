<?php
require_once(APPPATH.'controllers/abstract/base.php');

/** 
 * This is basic controller for all admin controllers.
 * 
 * @package base  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
abstract class Admin extends Base
{
	protected $panel = "admin";
    
    protected $segment_orderby;
	protected $segment_orderseq;
	protected $segment_offset;
	protected $segment_item;
	protected $segment_filters;
	
	protected $folder = "admin/";

    /**
     * Init models, set theme, set default segments values.
     *
     * @return \Admin
     */
	public function __construct()
	{
		parent::__construct();
		
		// Segments for OrderBy/OrderSeq/Offset/Item
		$this->segment_orderby = $this->uri->segment($this->_getSegmentsOffset()+3,'id');
		$this->segment_orderseq = $this->uri->segment($this->_getSegmentsOffset()+4,'asc');
		$this->segment_offset = $this->uri->segment($this->_getSegmentsOffset()+5,0);
		$this->segment_item = $this->uri->segment($this->_getSegmentsOffset()+6,0);
		$this->segment_filters = $this->uri->segment($this->_getSegmentsOffset()+7,'');
		
		// === Load Models === //
		$this->load->model('admin_model');
		
		$this->load->helper(array('aform','aurl'));
		
		// === Set Theme ==== //
		$this->_setTheme();
	}


	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// === Custom validation : Start === //
    /**
     * Validate if slug is unique.
     *
     * @param $slug
     * @param string $params
     * @return bool
     */
	public function _unique_slug($slug,$params)
	{
	    list($lang,$table,$slug_lang_id) = explode(',',$params);
	    
	    $record = $this->lang_gen_model->getSlugMultiData($lang,$slug,$table);
	    
	    if(!$record) return TRUE;
	    if($record['id']==$slug_lang_id) return TRUE;
	    return FALSE;
	}
	// === Custom validation : End === //
	
	/**
	 * Return "orderby" segment.
	 *
	 * @return string
	 */
	public function _getSegmentOrderby()
	{
	    return $this->segment_orderby;
	}
	
	/**
	 * Return "orderseq" segment.
	 *
	 * @return string
	 */
	public function _getSegmentOrderseq()
	{
	    return $this->segment_orderseq;
	}
	
	/**
	 * Return "offset" segment.
	 *
	 * @return integer
	 */
	public function _getSegmentOffset()
	{
	    return $this->segment_offset;
	}
	
	/**
	 * Return "filters" segment.
	 *
	 * @return integer
	 */
	public function _getSegmentFilters()
	{
	    return $this->segment_filters;
	}
	
	/**
	 * Check is admin logined.
	 * 
	 * @return bool
	 */
	public function _is_logged()
	{
		return $this->session->userdata('customer_is_admin');
	}

    /**
     * Redirect not logined customer to login page.
     *
     * @param bool $redirect
     * @return void
     */
	protected function _CheckLogged($redirect=TRUE)
	{
		if(!$this->_is_logged())
		{
			if($redirect) redirect($this->_getBaseURL()."managers/signin");
			else die( 'Session is expired. '.anchor($this->_getBaseURL()."managers/signin","Click here for login.") );
		}
		
		//check rights
		if(!$this->_checkUserAccess())
		{
		    if($redirect) redirect($this->_getBaseURL()."dashboard");
		    else die("You have not access to this.");
		}
	}
	
	/**
	 * Check if user has access to current method.
	 *
	 * @return bool
	 */
	protected function _checkUserAccess()
	{
	    $controller = $this->_getController();
	    $method = $this->_getMethod();
	    
	    if ($controller=='email_tpl_vars') return TRUE;//it shows just list of vars available in email
	    
	    $right = "";
	    
	    switch ($method)
	    {
	        case "index":
	        case "left"://menu
	        case "bottom"://menu
	        case "questions_list"://quiz
	        case "answers_list"://quiz, poll
	        case "download_csv"://subscribers
	        case "values_list"://products attributes
	            if($controller=='settings') $right = 'edit';//settings has just this right
	            elseif($controller=='newsletters') $right = 'send';//index is queue of emails
	            else $right = "view";
	        break;
	        
	        case "edit":
	        case "edit_tags"://products, photos, news, articles
	        case "edit_rights"://groups
	        case "sort"://categories, menu, articles_categories, products_categories
	        case "update"://lang
	        case "translateall"://lang
	        case "change_category"://photos
	        case "questions_edit"://quiz
	        case "answers_edit"://quiz, poll
	        case "whole_prices_update"://products
	        case "setinstock"://products
	        case "setnotinstock"://products
	        case "setnotfeatured"://products
	        case "values_edit"://products attributes
	        case "containers_edit"://formbuilder
	        case "inputs_edit"://formbuilder
	            $right = "edit";
	        break;
	        
	        case "add":
	        case "questions_add"://quiz
	        case "answers_add"://quiz, poll
	        case "values_add"://products attributes
	        case "containers_add"://formbuilder
	        case "inputs_add"://formbuilder
	            $right = "add";
	        break;
	        
	        case "delete":
	        case "delete_selected":
	        case "deleteimage"://products, companies
	        case "delete_additional_image"://products, companies
	        case "delete_selected_questions"://quiz
	        case "delete_selected_answers"://quiz, poll
	        case "delete_selected_values"://products attributes
	            $right = "delete";
	        break;
	        
	        case "send":
	            $right = "send";//newsletters
	        break;
	    }
	    
	    //allow dashboard for all
	    if($controller=='dashboard') $right = "";
	    //for tools just "view" right
	    if($controller=='tools') $right = "view";
	    
	    //if right name not found - allow access
	    if(!$right) return TRUE;
	    
	    //check access
	    $access = userAccess($controller,$right);
	    
	    //log if user has no access 
	    if(!$access) log_message('error',"No rights: {$right}. {$controller}->{$method}.");
	    
	    return $access;
	}

	// === Built Index Page === //
    /**
     * Select data for display in main records list (paginated).
     *
     * @param string $title
     * @param integer $per_page
     * @param string $where
     * @param bool $params_string
     * @param bool|string $orderby
     * @param bool|string $orderseq
     * @param bool|int $offset
     * @return array
     */
	protected function _ListData($title, $per_page = 10, $where = '', $params_string = FALSE, $orderby = FALSE, $orderseq = FALSE, $offset = FALSE)
	{
		if(!$this->method) $this->method = "index";
		
		$url = base_url().$this->_getBaseURI()."/".$this->_getMethod()."/";
		
		if($params_string) $url .= $params_string;
		if($orderby===FALSE) $orderby = $this->segment_orderby;
		if($orderseq===FALSE) $orderseq = $this->segment_orderseq;
		if($offset===FALSE) $offset = $this->segment_offset;

		// === DATA === //
		$this->_setPageTitle($title);

		$this->admin_model->init($this->c_table);
		$data = $this->admin_model->get($per_page,$where,$orderby,$orderseq,$offset);
		
		$records_amount_str = ' <strong>'.sprintf( language('x_of_x_records'), ($offset+1).'-'.min(($per_page+$offset),$data['total_rows']),$data['total_rows']).'</strong> ';

		$this->load->library('pagination');

		// Pagination
		$this->pagination->initialize(
			array(
					'base_url'		 => "$url/$orderby/$orderseq",
					'total_rows'	 => $data['total_rows'],
					'per_page'		 => $per_page,
					'uri_segment'	 => $this->_getSegmentsOffset()+5,
					'full_tag_open'	 => '<p>'.$records_amount_str,
					'full_tag_close' => '</p>',
					'first_link'     => language('pagination_first'),
					'last_link'     => language('pagination_last'),
			)
		);

		$data['paginate'] = $this->pagination->create_links();
		
		return $data;
	}
	
    /**
	 * Delete record by ID.
	 * 
	 * @param integer $id
	 * @return void
	 */
	protected function _DeleteID($id)
	{
		// === DELETE RECORD === //
		$this->admin_model->init($this->c_table);
		$this->admin_model->DeleteId($id);

		// === REDIRECT === //
		redirect(aurl());
	}
	
	// === Left Top Menu === //
	/**
	 * Build top admin menu.
	 * 
	 * @return string
	 */
	/*public function _built_left_menu()
	{
		if(!$this->_is_logged()) return '';

		$menu = '';
		$menu .= "<li>".language('logged_as').": <b>".$this->session->userdata('customer_name')."</b></li>";
		
		$menu .= "<li>".$this->buildLeftMenuItem('managers/signout','logout')."</li>";
		$menu .= "<li>".$this->buildLeftMenuItem('dashboard','dashboard')."</li>";
		
		if(userAccess('settings','edit'))               $menu .= "<li>".$this->buildLeftMenuItem('settings','settings')."</li>";
		if(userAccess('newsletters','send')) 			$menu .= "<li>".$this->buildLeftMenuItem('newsletters/send','mass_mail')."</li>";
		if(userAccess('auto_responders','view')) 		$menu .= "<li>".$this->buildLeftMenuItem('auto_responders','auto_responders')."</li>";
		if(userAccess('pages','view')) 					$menu .= "<li>".$this->buildLeftMenuItem('pages','pages')."</li>";
		if(userAccess('categories','view')) 			$menu .= "<li>".$this->buildLeftMenuItem('categories','categories')."</li>";
		if(userAccess('companies','view')) 				$menu .= "<li>".$this->buildLeftMenuItem('companies','companies')."</li>";
		if(userAccess('customers','view')) 				$menu .= "<li>".$this->buildLeftMenuItem('customers','users')."</li>";
		if(userAccess('groups','view')) 				$menu .= "<li>".$this->buildLeftMenuItem('groups','groups')."</li>";
		if(userAccess('links','view')) 					$menu .= "<li>".$this->buildLeftMenuItem('links','links')."</li>";
		if(userAccess('articles','view')) 				$menu .= "<li>".$this->buildLeftMenuItem('articles','articles')."</li>";
		if(userAccess('articles_categories','view')) 	$menu .= "<li>".$this->buildLeftMenuItem('articles_categories','articles_categories')."</li>";
		if(userAccess('news','view')) 					$menu .= "<li>".$this->buildLeftMenuItem('news','news')."</li>";
		if(userAccess('faq','view')) 					$menu .= "<li>".$this->buildLeftMenuItem('faq','faq')."</li>";
		if(userAccess('photos','view')) 				$menu .= "<li>".$this->buildLeftMenuItem('photos','photos')."</li>";
		if(userAccess('photos_categories','view')) 		$menu .= "<li>".$this->buildLeftMenuItem('photos_categories','photo_categories')."</li>";
		if(userAccess('quiz','view')) 					$menu .= "<li>".$this->buildLeftMenuItem('quiz','quiz_list')."</li>";
		if(userAccess('lang','view')) 					$menu .= "<li>".$this->buildLeftMenuItem('lang','lang_codes')."</li>";
		if(userAccess('poll','view')) 					$menu .= "<li>".$this->buildLeftMenuItem('poll','poll_list')."</li>";
		if(userAccess('comments','view')) 				$menu .= "<li>".$this->buildLeftMenuItem('comments','comments')."</li>";
		if(userAccess('products','view')) 				$menu .= "<li>".$this->buildLeftMenuItem('products','products')."</li>";
		if(userAccess('products_categories','view')) 	$menu .= "<li>".$this->buildLeftMenuItem('products_categories','products_categories')."</li>";
		if(userAccess('products_manufacturers','view')) $menu .= "<li>".$this->buildLeftMenuItem('products_manufacturers','manufacturers')."</li>";
		if(userAccess('products_attributes','view')) 	$menu .= "<li>".$this->buildLeftMenuItem('products_attributes','products_attributes')."</li>";
		if(userAccess('orders','view')) 				$menu .= "<li>".$this->buildLeftMenuItem('orders','orders')."</li>";
		if(userAccess('currency','view')) 				$menu .= "<li>".$this->buildLeftMenuItem('currency','currency')."</li>";
		if(userAccess('testimonials','view')) 			$menu .= "<li>".$this->buildLeftMenuItem('testimonials','testimonials')."</li>";

		return $menu;
	}*/
	
	/**
	 * Return link for admin left menu.
	 *
	 * @param string $rel_link
	 * @param string $lang_code
	 * @return string
	 */
	public function buildLeftMenuItem($rel_link,$lang_code)
	{
		return anchor($this->_getBaseURL().$rel_link, language($lang_code));
	}

	// === Right Top Menu === //
	/**
	 * Build right top admin menu.
	 * 
	 * @return string
	 */
	public function _built_right_menu()
	{
		if(!$this->_is_logged()) return '';

		$menu = "<li><span class='css3-icon css3-icon-list'>".anchor($this->_getBaseURI().'/index', language('show_list'))."</span></li>";
		if(userAccess($this->_getController(),'add')) $menu .= "<li><span class='css3-icon css3-icon-add'>".anchor($this->_getBaseURI().'/add',  language('add'))."</span></li>";

		return $menu;
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

    /**
     * Delete records by posted checked records' array.
     *
     * @param string $orderby
     * @param string $orderseq
     * @param int|string $offset
     * @return void
     */
	public function Delete_Selected($orderby='',$orderseq='',$offset='')
	{
		$this->admin_model->init($this->c_table);
		
		$this->{$this->_getController().'_model'}->DeleteSelected(@$_POST['check']);

		// === REDIRECT === //
		redirect(aurl());
	}


	/**
	 * Show list with records by search criterias (sorted and paginated).
	 * 
	 * @return void
	 */
	public function Index()
	{
		$this->admin_model->init($this->c_table);
	    
	    // === SEARCH PROCESS === //
		$where = $this->admin_model->searchData($_POST);
		if(!$where) $where = '1';
		
		// === Apply Filters === //
		$where .= $this->admin_model->applyFilters();

		// === Pagination Process === //
		$data = $this->_ListData($this->_getPageTitle($this->method), $this->per_page, $where);

		//Deny sortable if not all records shown !!!
		if($where!='1') $data['deny_sortable'] = TRUE;

		$data['tpl_page'] = $this->_getController().'/list';
		parent::_OnOutput($data);
	}
}