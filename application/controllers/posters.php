<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for posters.
 * 
 * @package messageboard  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Posters extends Front 
{
    /**
     * Init required models, helpers, language sections, pages' titles, css files etc.
     *
     * @return \Posters
     */
    public function __construct()
	{
		parent::__construct();
		
		// === Load Models === //
		$this->load->model('customers_model');
		$this->load->model('categories_model');
		$this->load->model('posters_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','posters'));
		
		// === Labels === //
		$this->fields_titles['title'] = language('title');
		$this->fields_titles['text'] = language('poster_text');
		$this->fields_titles['period'] = language('valid_period');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('posters');
		$this->page_titles['search'] = language('posters');
		$this->page_titles['my'] = language('my_posters');
		$this->page_titles['add'] = language('add_poster');
		$this->page_titles['edit'] = language('edit_poster');
		//default page title
		$this->_setDefaultPageTitle();
		
		// === Load Helpers === //
		$this->load->helper('text');
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //

	/**
	 * Validate and insert or update data.
	 * 
	 * @param  array $record
	 * @return void
	 */
	private function _processInsert(array $record=array())
	{
		$this->_CheckLogged();
		
		if( ($id = $this->input->post('id')) || ($id = @$record['id']) )
		{
			$this->posters_model->RedirectWrongUser($id);
		}
		
		$this->load->library('form_validation');
		
		$configValidation = array(
			   array(
                     'field'   => 'category[]', 
                     'label'   => language('category'),
                     'rules'   => 'trim|integer|callback__isset_category'
                  ),
               array(
                     'field'   => 'title', 
                     'label'   => parent::_getFieldTitle('title'), 
                     'rules'   => 'trim|required|min_length[5]|max_length[255]|xss_clean'
                  ),
               array(
                     'field'   => 'text', 
                     'label'   => parent::_getFieldTitle('text'), 
                     'rules'   => 'trim|required|min_length[5]|max_length[5000]|xss_clean'
                  ),
               array(
                     'field'   => 'period', 
                     'label'   => parent::_getFieldTitle('period'), 
                     'rules'   => 'trim|xss_clean'
                  )
            );

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			if(isset($id)) 
			{
				// === GET RECORD === //
				$data = $this->posters_model->getOneById($id);
		
				// === Current Location === //
				$data['current_location_arr'] =
				array(
					$this->_getBaseURL()."customers"=>lowercase(language('my_account')),
					$this->_getBaseURL()."posters/my"=>lowercase($this->_getPageTitle('my')),
					$this->_getBaseURI()."/edit/".$id=>'[page_title]'
				);
			}
			else 
			{
				// === Current Location === //
				$data['current_location_arr'] =
				array(
					$this->_getBaseURL()."customers"=>lowercase(language('my_account')),
					$this->_getBaseURL()."posters/my"=>lowercase($this->_getPageTitle('my')),
					$this->_getBaseURI()."/add"=>'[page_title]'
				);
			}
			
			$data['tpl_page'] = $this->controller."/edit";
			
			parent::_OnOutput($data);
		}
		else
		{
			$post = $_POST;
			
			//UPDATE
			if( isset($id) )
			{
				// === Add to DB === //			
				$this->posters_model->Update($post);

                $categories = $this->input->post('category');
                if(is_array($categories))
                {
                    //remove old categories
                    $this->posters_model->RemovePostCategories($id);
                    //add new categories
                    $this->posters_model->AddPostCategories($id, $categories);
                }
			}
			//ADD
			else 
			{
				// === Add to DB === //			
				$id = $this->posters_model->Insert($post);

                $categories = $this->input->post('category');
                if(is_array($categories)) $this->posters_model->AddPostCategories($id, $categories);
			}
			
			redirect($this->_getBaseURI().'/my');
		}
	}


	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Show posters' categories/subcategories list by parent category ID.
	 * 
	 * @return void
	 */
	public function Index()
	{
		$filter_data = $this->uri->uri_to_assoc($this->_getSegmentsOffset()+3);
		
		if(!isset($filter_data['category'])) $filter_data['category'] = 0;
		
		$data['categories'] = $this->categories_model->GetChildren($filter_data['category'],TRUE);
		
		//if no subcategories - show posts
		if(empty($data['categories']))
		{
			redirect($this->_getBaseURI()."/search/category/".$filter_data['category']);
		}
		
		$data['controller'] = "posters";
		
		$data['tpl_page'] = "categories/list";
		
		// === Current Location === //
		$current_location_arr =
		array(
			$this->_getBaseURI()=>$this->_getPageTitle()
		);
		
		// === Categories Location === //
		$categories_location_arr = $this->categories_model->GetLocation($filter_data['category'],'posters');
		
		$current_location_arr = array_merge($current_location_arr,$categories_location_arr);
		
		$data['current_location_arr'] = $current_location_arr;

		//add search category info
		if($filter_data['category']) $data = array_merge($data,$this->categories_model->getSearchCategoryData($filter_data['category']));
		
		//generate additional page title
		$this->appendPageTitleForListPages($filter_data,$data);
		
		parent::_OnOutput($data);
	}

    /**
	 * Show posters list by filter.
	 * 
	 * @return void
	 */
    public function Search()
	{
		// === DELETE DEAD POSTS === //
		// (maybe move it in cron) //
		$this->posters_model->DeleteDeadPosts();
		
			
		// === Filter Data === //
		$filter_data = $this->posters_model->getFilterData();
		
		// === Posters === //
		if(isset($filter_data['empty_filter']))
		{
			$data['posts_list'] = false;
			$data['paginate'] = '';
		}
		else 
		{
			$data = $this->posters_model->get("search", $filter_data);
		}
		
		$data = array_merge($data,$filter_data);
		
		$data['tpl_page'] = $this->controller."/list";

		// === Current Location === //
		$current_location_arr =
		array(
			$this->_getBaseURI()=>$this->_getPageTitle()
		);
		
		// === Categories Location === //
		$categories_location_arr = $this->categories_model->GetLocation($filter_data['category'],'posters');
		
		$current_location_arr = array_merge($current_location_arr,$categories_location_arr);
		
		$data['current_location_arr'] = $current_location_arr;

		//add search category info
		if($filter_data['category']) $data = array_merge($data,$this->categories_model->getSearchCategoryData($filter_data['category']));
		
		//generate additional page title
		$this->appendPageTitleForListPages($filter_data,$data);
		
		parent::_OnOutput($data);

	}
	
	/**
	 * Show customer's posters.
	 * 
	 * @return void
	 */
	public function my()
	{
		$this->_CheckLogged();

		// === Current Location === //
		$data['current_location_arr'] =
		array(
			$this->_getBaseURL()."customers"=>lowercase(language('my_account')),
			$this->_getBaseURI()."/my"=>'[page_title]'
		);
		
		// === Customer's posters === //
		$data['my_posters'] = $this->posters_model->getMy();
		
		parent::_OnOutput($data);
	}

    /**
	 * Add new poster.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}

	/**
	 * Show poster's full information.
	 * 
	 * @param integer $id
	 * @return void
	 */
	public function View($id)
	{
		// === GET RECORD === //
		$data = $this->posters_model->getOneById($id);
		
		// === Stats: Increment Views === //
		$this->posters_model->IncViews($data['id'],$data['views']);
		
		// === Main Data === //
		$this->_setPageTitle($data['title']);

		// === Current Location === //
		$current_location_arr =
		array(
			$this->_getBaseURI()=>lowercase($this->_getPageTitle('index'))
		);
		
		$view_location_arr = array($this->_getBaseURI()."/view/".$id=>'[page_title]');
		
		// === Categories Location === //
		$categories_location_arr = $this->categories_model->GetLocation($data['post_category'],'posters');
		$current_location_arr = array_merge($current_location_arr,$categories_location_arr,$view_location_arr);
		
		// === Post Owner Info === //
		$data['post_owner'] = $this->customers_model->getOneById($data['customer_id']);

		$data['current_location_arr'] = $current_location_arr;
		
		parent::_OnOutput($data);

	}

	/**
	 * Edit poster.
	 * 
	 * @param $id
	 * @return void
	 */
	public function Edit($id)
	{
		$record['id'] = $id;
		$this->_processInsert($record);
	}

	/**
	 * Delete poster.
	 * 
	 * @param $id
	 * @return void
	 */
	public function Delete($id)
	{
		$this->_CheckLogged();
		
		$this->posters_model->RedirectWrongUser($id);
		
		$this->posters_model->DeleteId($id);
		
		redirect($this->_getBaseURI().'/my');
	}
	
	/**
	 * Delete poster's image.
	 * 
	 * @param $id
	 * @return void
	 */
	public function DeleteImage($id)
	{
		$this->_CheckLogged();
		
		$this->posters_model->RedirectWrongUser($id);
		
		$this->posters_model->RemovePostImage($id);
		
		redirect($this->_getBaseURI().'/edit/'.$id);
	}

}