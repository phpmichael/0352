<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for products.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Products extends Admin 
{
	//name of table
    protected $c_table = "products";
    
    protected $per_page = 10;

    /**
     * Constructor for Products controller.
     *
     * @return \Products
     */
	public function __construct()
	{
		parent::__construct();

		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('products_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Labels === //
		$this->fields_titles['SKU'] = 'SKU';
		$this->fields_titles['name'] = language('thing_name');
		$this->fields_titles['slug'] = language('page_slug');
		$this->fields_titles['page_title'] = language('page_title');
		$this->fields_titles['meta_keywords'] = language('meta_keywords');
		$this->fields_titles['meta_description'] = language('meta_description');
		$this->fields_titles['price'] = language('price');
		$this->fields_titles['old_price'] = language('old_price');
		$this->fields_titles['description'] = language('description');
		$this->fields_titles['youtube_url'] = 'YouTube URL';
		$this->fields_titles['in_stock'] = language('in_stock');
		$this->fields_titles['featured'] = language('featured');
		$this->fields_titles['manufacturer_id'] = language('manufacturer');
		$this->fields_titles['alt'] = language('alt_attribute_for_image');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('products');
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
		//dump($_POST);exit;
	    //dump($record);exit;
	    
	    if( isset($_POST['name']) )
		{
			// === Make Slug === //
			foreach (get_multilang_codes() as $lang_code)
			{
			    $_POST['slug'][$lang_code] = $this->products_model->doSlug($_POST['name'][$lang_code]);
			}
		}
		
		$slug_lang_id = intval(@$record['slug_lang_id']);
	    
	    $this->load->library('form_validation');
		
		$configValidation = array(
                array(
                     'field'   => 'category[]', 
                     'label'   => language('category'), 
                     'rules'   => 'trim|integer|callback__isset_category'
                  ),
                array(
                     'field'   => 'price', 
                     'label'   => parent::_getFieldTitle('price'), 
                     'rules'   => 'trim|required|numeric'
                  ),
                array(
                     'field'   => 'old_price', 
                     'label'   => parent::_getFieldTitle('old_price'), 
                     'rules'   => 'trim|numeric'
                  ),
                array(
                     'field'   => "youtube_url", 
                     'label'   => parent::_getFieldTitle('youtube_url'), 
                     'rules'   => 'trim|callback__valid_youtube_url'
                  )
            );
            
        //if used product SKU - add validator for it
        if( isset($this->settings_model['use_product_sku']) && $this->settings_model['use_product_sku'] )
        {
        	$id = isset($record['id']) ? $record['id'] : '';
        	
        	$configValidation[] = array(
                     'field'   => "SKU", 
                     'label'   => parent::_getFieldTitle('SKU'), 
                     'rules'   => 'trim|required|max_length[30]|callback__unique_field_for_edit[SKU,'.$id.']|xss_clean'
                  );
        }
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "name[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('name')." ({$lang_code})", 
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
                     'field'   => "description[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('description')." ({$lang_code})", 
                     'rules'   => 'trim'
                  );
                  
            $configValidation[] = array(
                     'field'   => "alt[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('alt')." ({$lang_code})", 
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
			
			$this->products_model->insertOrUpdate($post,$this->input->post('category'));
			
			redirect($this->_getBaseURI());
		}
	}
	
	/**
	 * Remap methods calls.
	 *
	 * @param string $method
	 * @param array $params
	 */
	public function _remap($method, $params=array()) 
	{
		if( in_array($method,array('setinstock','setnotinstock','setfeatured','setnotfeatured')) ) 
        {
            $this->products_model->$method($this->input->post('check'));
            
            // === REDIRECT === //
			redirect(aurl());
        }
        else 
        {
        	if (method_exists($this, $method)) call_user_func_array(array($this, $method), $params);
		    else show_404();
        }
    }

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

    /**
	 * Add product.
	 * 
	 * @return void
	 */
    public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit product.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->products_model->getOneById($id);
		
		$this->_processInsert($record);
	}
    
	/**
	 * Set tags for products.
	 * 
	 * @return void
	 */
    public function Edit_Tags()
	{
	    redirect($this->_getBaseURL().'tags/edit/'.$this->segment_orderby.'/'.$this->segment_orderseq.'/'.$this->segment_offset.'/'.$this->segment_item.'/'.$this->c_table);
	}
	
	/**
	 * Delete products's main image.
	 * 
	 * @return void
	 */
	public function DeleteImage()
	{	
		// === GET ID === //
		$id = $this->segment_item;
		
		$this->products_model->RemovePostImage($id);
		
		redirect($this->_getBaseURI()."/edit/$this->segment_orderby/".$this->segment_orderseq."/".$this->segment_offset."/".$id);
	}
	
	
	/**
	 * Delete products's additional image.
	 * 
	 * @return void
	 */
	public function Delete_Additional_Image()
	{	
		// === GET ID === //
		$id = $this->segment_item;
		
		$image_id = $this->uri->segment($this->_getSegmentsOffset()+7);
		
		if(!$image_id) redirect($this->_getBaseURI());
		
		$this->products_model->RemoveAdditionalImage($image_id);
		
		redirect($this->_getBaseURI()."/edit/$this->segment_orderby/".$this->segment_orderseq."/".$this->segment_offset."/".$id);
	}
	
	/**
	 * Update price for all products.
	 *
	 * @return void
	 */
	public function Whole_Prices_Update()
	{
	    $sign = $this->input->post('sign');
	    $value = $this->input->post('value');
	    $type = $this->input->post('type');
        $selectedIds = $this->input->post('check');
	    
	    $this->products_model->wholePricesUpdate($sign,$value,$type,$selectedIds);
	    
	    redirect(aurl());
	}

}