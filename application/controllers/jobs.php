<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for jobs.
 * 
 * @package messageboard  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Jobs extends Front 
{
    /**
     * Init required models, helpers, language sections, pages' titles, css files etc.
     *
     * @return \Jobs
     */
    public function __construct()
	{
		parent::__construct();
		
		// === Load Models === //
		$this->load->model('customers_model');
		$this->load->model('categories_model');
		$this->load->model('jobs_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','job'));
		
		$data['experienceArr'] = array(0=>language('no_matter'),1=>'1 '.language('year'),2=>'2 '.language('years'),3=>'3 '.language('years'),4 =>'4 '.language('years'),5=>'5 '.language('years1'));
		
		// === LOAD VARS TO ALL VIEWERS === //
		$this->load->vars($data);
		
		// === Labels === //
		$this->fields_titles['title'] = language('title');
		$this->fields_titles['text'] = language('poster_text');
		$this->fields_titles['period'] = language('valid_period');
		$this->fields_titles['position'] = language('job_position');
		$this->fields_titles['experience'] = language('job_experience');
		$this->fields_titles['salary'] = language('salary');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('vacancies');
		$this->page_titles['search'] = language('vacancies');
		$this->page_titles['my'] = language('my_vacancies');
		$this->page_titles['add'] = language('add_vacancy');
		$this->page_titles['edit'] = language('edit_vacancy');
		//default page title
		$this->_setDefaultPageTitle();
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
			$this->jobs_model->RedirectWrongUser($id);
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
                     'field'   => 'position', 
                     'label'   => parent::_getFieldTitle('position'), 
                     'rules'   => 'trim|required|min_length[3]|max_length[150]|xss_clean'
                  ),
               array(
                     'field'   => 'experience', 
                     'label'   => parent::_getFieldTitle('experience'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'salary', 
                     'label'   => parent::_getFieldTitle('salary'), 
                     'rules'   => 'trim|xss_clean'
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
				$data = $this->jobs_model->getOneById($id);
		
				// === Current Location === //
				$data['current_location_arr'] =
				array(
					$this->_getBaseURL()."customers"=>lowercase(language('my_account')),
					$this->_getBaseURL()."jobs/my"=>lowercase($this->_getPageTitle('my')),
					$this->_getBaseURI()."/edit/".$id=>'[page_title]'
				);
			}
			else 
			{
				// === Current Location === //
				$data['current_location_arr'] =
				array(
					$this->_getBaseURL()."customers"=>lowercase(language('my_account')),
					$this->_getBaseURL()."jobs/my"=>lowercase($this->_getPageTitle('my')),
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
				$this->jobs_model->Update($post,$this->input->post('category'));
			}
			//ADD
			else 
			{
				// === Add to DB === //			
				$this->jobs_model->Insert($post,$this->input->post('category'));
			}
			
			redirect($this->_getBaseURI().'/my');
		}
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Show jobs' categories/subcategories list by parent category ID.
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
		
		$data['controller'] = "jobs";
		
		$data['tpl_page'] = "categories/list";
		
		// === Current Location === //
		$current_location_arr =
		array(
			$this->_getBaseURI()=>$this->_getPageTitle()
		);
		
		// === Categories Location === //
		$categories_location_arr = $this->categories_model->GetLocation($filter_data['category'],'jobs');
		
		$current_location_arr = array_merge($current_location_arr,$categories_location_arr);
		
		$data['current_location_arr'] = $current_location_arr;

		//add search category info
		if($filter_data['category']) $data = array_merge($data,$this->categories_model->getSearchCategoryData($filter_data['category']));
		
		//generate additional page title
		$this->appendPageTitleForListPages($filter_data,$data);
		
		parent::_OnOutput($data);
	}

    /**
	 * Show jobs list by filter.
	 * 
	 * @return void
	 */
	public function Search()
	{
		// === DELETE DEAD POSTS === //
		// (maybe move it in cron) //
		$this->jobs_model->DeleteDeadPosts();
		
			
		// === Filter Data === //
		$filter_data = $this->jobs_model->getFilterData();
		
		// === Jobs === //
		if(isset($filter_data['empty_filter']))
		{
			$data['posts_list'] = false;
			$data['paginate'] = '';
		}
		else {
			$data = $this->jobs_model->get("search", $filter_data);
		}
		
		$data = array_merge($data,$filter_data);

		$data['tpl_page'] = $this->controller."/list";

		// === Current Location === //
		$current_location_arr =
		array(
			$this->_getBaseURI()=>'[page_title]'
		);
		
		// === Categories Location === //
		$categories_location_arr = $this->categories_model->GetLocation($filter_data['category'],'jobs');
		$current_location_arr = array_merge($current_location_arr,$categories_location_arr);
		
		$data['current_location_arr'] = $current_location_arr;

		// === DATA === //
		if($filter_data['category']) 
		{
			$category_record = $this->categories_model->getOneById($filter_data['category']);
			if($category_record)
			{
				$data['search_category_id'] = $category_record['id'];
				$data['search_category_title'] = $category_record['category'];
				if(isset($category_record['description'])) $data['search_category_description'] = $category_record['description'];
			}
		}
		
		parent::_OnOutput($data);
	}
	
	/**
	 * Show customer's vacations.
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
		
		// === Customer's jobs === //
		$data['my_jobs'] = $this->jobs_model->getMy();
		
		parent::_OnOutput($data);
	}

    /**
	 * Add new vacation.
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
		$data = $this->jobs_model->getOneById($id);
		
		// === Stats: Increment Views === //
		$this->jobs_model->IncViews($data['id'],$data['views']);
		
		// === Main Data === //
		$this->_setPageTitle($data['title']);

		// === Current Location === //
		$current_location_arr =
		array(
			$this->_getBaseURI()=>lowercase($this->_getPageTitle('index'))
		);
		
		$view_location_arr = array($this->_getBaseURI()."/view/".$id=>'[page_title]');
		
		// === Categories Location === //
		$categories_location_arr = $this->categories_model->GetLocation($data['post_category'],'jobs');
		$current_location_arr = array_merge($current_location_arr,$categories_location_arr,$view_location_arr);
		

		$data['current_location_str'] = $this->_build_cur_location($current_location_arr);
		
		// === Post Owner Info === //
		$data['post_owner'] = $this->customers_model->getOneById($data['customer_id']);

		$data['current_location_arr'] = $current_location_arr;
		
		parent::_OnOutput($data);

	}

	/**
	 * Edit vacation.
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
	 * Delete vacation.
	 * 
	 * @param $id
	 * @return void
	 */
	public function Delete($id)
	{
		$this->_CheckLogged();
		
		$this->jobs_model->RedirectWrongUser($id);
		
		$this->jobs_model->DeleteId($id);
		
		redirect($this->_getBaseURI().'/my');
	}
	
	/**
	 * Delete vacation's image.
	 * 
	 * @param $id
	 * @return void
	 */
	public function DeleteImage($id)
	{
		$this->_CheckLogged();
		
		$this->jobs_model->RedirectWrongUser($id);
		
		$this->jobs_model->RemovePostImage($id);
		
		redirect($this->_getBaseURI().'/edit/'.$id);
	}

}