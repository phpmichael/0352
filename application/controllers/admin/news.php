<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for news.
 * 
 * @package news  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class News extends Admin 
{
	//name of table
    protected $c_table = "news";
    //show records per page
	protected $per_page = 10;

    /**
     * Constructor for News controller.
     *
     * @return \News
     */
	public function __construct()
	{
		parent::__construct();

		// RELOAD: Segments for OrderBy/OrderSeq/Offset/Item
		$this->segment_orderseq = $this->uri->segment($this->_getSegmentsOffset()+4,'desc');

		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('news_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Labels === //
		$this->fields_titles['head'] = language('title');
		$this->fields_titles['slug'] = language('page_slug');
		$this->fields_titles['meta_keywords'] = language('meta_keywords');
		$this->fields_titles['meta_description'] = language('meta_description');
		$this->fields_titles['body'] = language('text');
		$this->fields_titles['date'] = language('date');
		$this->fields_titles['comments_opened'] = language('comments_opened');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('news');
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
	    if( isset($_POST['head']) )
		{
			// === Make Slug === //
			foreach (get_multilang_codes() as $lang_code)
			{
			    $_POST['slug'][$lang_code] = $this->news_model->doSlug($_POST['head'][$lang_code]);
			}
		}
		
		$slug_lang_id = intval(@$record['slug_lang_id']);
	    
	    $this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'category[]', 
                     'label'   => language('category'), 
                     'rules'   => 'trim|integer|callback__isset_category'
                  )
            );
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "head[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('head')." ({$lang_code})", 
                     'rules'   => 'trim|required|min_length[3]|max_length[250]|xss_clean'
                  );
                  
            $configValidation[] = array(
                     'field'   => "slug[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('slug')." ({$lang_code})", 
                     'rules'   => 'trim|max_length[250]|callback__unique_slug['.$lang_code.','.$this->c_table.','.$slug_lang_id.']'
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
                     'rules'   => 'trim|required|min_length[3]'
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
			
			if(!isset($post['date'])) $post['date'] = date("Y-m-d H:i:s");
			
			$this->news_model->insertOrUpdate($post);

            $id = $categories = $this->input->post('category');
            if(is_array($categories)) $this->news_model->UpdatePostCategories($id, $categories);
			
			redirect($this->_getBaseURI());
		}
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

    /**
	 * Add news.
	 * 
	 * @return void
	 */
    public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit news.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->news_model->getOneById($id);
		
		$this->_processInsert($record);
	}
    
	/**
	 * Set tags for news.
	 * 
	 * @return void
	 */
    public function Edit_Tags()
	{
	    redirect($this->_getBaseURL().'tags/edit/'.$this->segment_orderby.'/'.$this->segment_orderseq.'/'.$this->segment_offset.'/'.$this->segment_item.'/'.$this->c_table);
	}

}