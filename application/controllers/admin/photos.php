<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for photos.
 * 
 * @package photos  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Photos extends Admin 
{
	//name of table
    protected $c_table = "photos";
	//show records per page
	protected $per_page = 5;

	/**
    * Init models, set pages' titles, fields' titles, set languages' sections.
    * 
    * @return void
    */
	public function __construct()
	{
        parent::__construct();
		
		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('photos_model');
		$this->load->model('photos_categories_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Labels === //
		$this->fields_titles['orig_name'] = language('photo_name');
		$this->fields_titles['date'] = language('added_date');
		$this->fields_titles['category_id'] = language('category');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('photos_list');
		$this->page_titles['add'] = language('add_photo');
		$this->page_titles['change_category'] = language('change_category');
		//default page title
		$this->_setDefaultPageTitle();

		$data['photo_data'] = $this->photos_model->getPhotoData();
		
		// === LOAD publics TO ALL VIEWERS === //
		$this->load->vars($data);
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //

	/**
	 * Build search creteria for _ListData method.
	 * 
	 * @param array $post
	 * @return string
	 */
	public function _SearchByCategoryId($post)
	{
		// New Search
		if( isset($post['category_id']) && $post['category_id'] ) 
		{
			$where = "category_id = '".intval($post['category_id'])."'";

			//Add Search to Session
			$sessdata[$this->_getCurrentTable().'_category_id'] = $post['category_id'];
			$this->session->set_userdata($sessdata);
		}
		// Reset Search
		elseif($this->uri->segment($this->_getSegmentsOffset()+3) == 'reset')
		{
			$this->session->unset_userdata($this->_getCurrentTable().'_category_id');
			$where = '';
		}
		// Get Search From Session
		elseif( $this->session->userdata($this->_getCurrentTable().'_category_id') )
		{
			$where = "category_id = '".intval($this->session->userdata($this->_getCurrentTable().'_category_id'))."'";
		}
		// No Any Search
		else $where = '';

		return $where;
	}
	
	/**
	 * Validate and insert or update data, upload photo.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsert()
	{
		$data['file_names'] = array();
	    
		//  === LOAD UPLOAD CLASS === //
		$this->load->library('upload', $this->photos_model->getUploadConfig());
		
		if($this->input->post('submit'))
		{
		    for($i=1;$i<=5;$i++)
		    {
		        if( $this->upload->do_upload("image_{$i}") )
		        {
		            $upload_data = $this->upload->data(); 
		    
			        $this->photos_model->Insert($upload_data);
			        
			        $data['file_names'][$i] = $upload_data['file_name'];
		        }
		    }
		}
		
		$data['tpl_page'] = $this->_getController().'/add';
		parent::_OnOutput($data);
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //

    /**
	 * Show list with records by search creterias (sorted and paginated).
	 * Overrides parent method.
	 * 
	 * @return void
	 */
	public function Index()
	{
	    $this->admin_model->init($this->c_table);
	    
		// === SEARCH PROCESS === //
		$where1 = $this->_SearchByCategoryId($_POST);
		
		$where2 = $this->admin_model->searchData($_POST);
		
		if($where1) 
		{
			$where = $where1;
			if($where2) $where .= ' AND '.$where2;
		}
		else $where = $where2;

		// === Pagination Process === //
		$data = $this->_ListData($this->_getPageTitle($this->_getMethod()), $this->per_page, $where);
		
		 // === Categories List === //
		$data['categories'] = $this->photos_categories_model->GetAllCategoriesList();

		$data['tpl_page'] = $this->_getController().'/list';
		parent::_OnOutput($data);
	}
	
	/**
	 * Add photo.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Set category for photo.
	 * 
	 * @return void
	 */
	public function Change_Category()
	{
	    // === GET ID === //
		$post['id'] = $this->segment_item;
		
		$this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'category[]', 
                     'label'   => language('category'), 
                     'rules'   => 'trim|integer|callback__isset_category'
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
		    $post['category'] = $_POST['category'];
		    
		    $this->photos_model->Update($post);
			
			redirect($this->_getBaseURI().'/index/'.$this->segment_orderby.'/'.$this->segment_orderseq.'/'.$this->segment_offset);
		}
	}
	
	/**
	 * Set tags for photo.
	 * 
	 * @return void
	 */
	public function Edit_Tags()
	{
	    redirect($this->_getBaseURL().'tags/edit/'.$this->segment_orderby.'/'.$this->segment_orderseq.'/'.$this->segment_offset.'/'.$this->segment_item.'/'.$this->c_table);
	}
	
	/**
	 * Bulk change category for photo.
	 *
	 */
	public function Bulk_Change_Category()
	{
	    $this->photos_model->bulkChangeCategory($this->input->post('check'),$this->input->post('new_category_id'));
	    
	    redirect(aurl());
	}

}