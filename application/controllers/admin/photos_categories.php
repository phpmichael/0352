<?php
require_once(APPPATH.'controllers/admin/categories.php');

/** 
 * This is admin controller for photos' categories.
 * 
 * @package photos  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 * @property Photos_categories_model $model
 */
class Photos_Categories extends Categories 
{
	//name of table
    protected $c_table = "photos_categories_list";

    /**
	 * Init models, set pages' titles, fields' titles, set languages' sections.
	 * 
	 * @param string $model
	 * @return \Photos_Categories
	 */
	public function __construct($model = 'photos_categories_model')
	{
		parent::__construct($model);
		
		// === Labels === //
		$this->fields_titles['alt'] = language('alt_attribute_for_image');
		
		$data['photo_data'] = $this->model->getPhotoData();
		
		// === LOAD public TO ALL VIEWERS === //
		$this->load->vars($data);
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
		
		$configValidation = array(
               array(
                     'field'   => 'image', 
                     'label'   => language('photo'), 
                     'rules'   => 'trim|xss_clean'
                  )
            );
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "category[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('category')." ({$lang_code})", 
                     'rules'   => 'trim|required|min_length[3]|max_length[250]|xss_clean'
                  );
                  
            $configValidation[] = array(
                     'field'   => "description[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('description')." ({$lang_code})", 
                     'rules'   => 'trim|xss_clean'
                  );
                  
            $configValidation[] = array(
                     'field'   => "alt[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('alt')." ({$lang_code})", 
                     'rules'   => 'trim|xss_clean'
                  );
        }

		$this->form_validation->set_rules($configValidation);
		
		//  === LOAD UPLOAD CLASS === //
		$this->load->library('upload', $this->model->getUploadConfig());
		
		if( !empty($_FILES['image']) ) $upload_result = $this->upload->do_upload('image');
		else $upload_result = FALSE;
			
		if ( 
		  ($this->form_validation->run() == FALSE) 
		  //||
		  //( empty($record) && $upload_result == FALSE) 
		)
		{
			$record['tpl_page'] = $this->_getController().'/add';
		    parent::_OnOutput($record);
		}
		else
		{
			$upload_data = ($upload_result)? $this->upload->data() : array();
		    
		    $post = array_merge($record,$this->input->post());
			
			$post['parent_id'] = $this->parent_id;
			
			$this->model->insertOrUpdate($post,$upload_data);
			
			redirect($this->_getBaseURI()."/index/".$this->parent_id);
		}
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

}