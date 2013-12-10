<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for products attributes.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Products_attributes extends Admin 
{
	//name of table
    protected $c_table = "products_available_attributes";

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Products_attributes
     */
	public function __construct()
	{
		parent::__construct();

		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('products_attributes_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin','products'));
		
		// === Labels === //
		$this->fields_titles['name'] = language('thing_name');
		$this->fields_titles['value'] = language('value');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('products_attributes');
		$this->page_titles['add'] = language('add');
		$this->page_titles['edit'] = language('edit');
		$this->page_titles['values_list'] = language('values_list');
		$this->page_titles['values_add'] = language('add_value');
		$this->page_titles['values_edit'] = language('edit_value');
		//default page title
		$this->_setDefaultPageTitle();
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// === Custom validation : Start === //	
	
	// === Custom validation : End === //

	/**
	 * Validate and insert or update attribute.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsert(array $record=array())
	{
	    $this->load->library('form_validation');
		
		$configValidation = array();
            
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
			
			$this->products_attributes_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI());
		}
	}
	
	/**
	 * Validate and insert or update attribute's value.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsertValue(array $record=array())
	{
		$this->load->library('form_validation');
		
		$configValidation = array(); 
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "value[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('value')." ({$lang_code})", 
                     'rules'   => 'trim|required|max_length[255]'
                  );
        }

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			$record['tpl_page'] = $this->_getController().'/values_add';
		    parent::_OnOutput($record);
		}
		else
		{
			$post = array_merge($record,$_POST);
			
			$this->products_attributes_model->insertOrUpdateValue($post);
			
			redirect($this->_getBaseURI()."/values_list/".$record['attr_id']);
		}
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

    /**
	 * Add attribute.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit attribute's value.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->products_attributes_model->getOneById($id);
		
		$this->_processInsert($record);
	}
	
	/**
	 * Delete selected attributes.
	 * Overrides parent method.
	 * 
	 * @return void
	 */
	public function Delete_Selected()
	{
		$this->products_attributes_model->DeleteSelectedAttributes(@$_POST['check']);

		redirect($this->_getBaseURI());
	}
	
	/**
	 * Show values list for attribute.
	 * 
	 * @param integer $attr_id
	 * @return void
	 */
	public function Values_List($attr_id)
	{
		$this->justCurrentLang = TRUE;
	    
	    $data['values'] = $this->products_attributes_model->getAvailableValues($attr_id);
		
		$data['tpl_page'] = $this->_getController().'/'.$this->_getMethod();
		parent::_OnOutput($data);
	}
	
	/**
	 * Add value for attribute.
	 * 
	 * @param integer $attr_id
	 * @return void
	 */
	public function Values_Add($attr_id)
	{
		$record['attr_id'] = $attr_id;
		$this->_processInsertValue($record);
	}
	
	/**
	 * Edit value for attribute.
	 * Params $mm and $nn not used. Just link should have defined format.
	 * 
	 * @param integer $attr_id
	 * @param mixed $mm
	 * @param mixed $nn
	 * @param integer $value_id
	 * @return void
	 */
	public function Values_Edit($attr_id,$mm,$nn,$value_id)
	{
		// === GET RECORD === //
		$record = $this->products_attributes_model->getValueById($value_id);
		$record['attr_id'] = $attr_id;
		
		$this->_processInsertValue($record);
	}
	
	/**
	 * Delete selected values.
	 * 
	 * @param integer $attr_id
	 * @return void
	 */
	public function Delete_Selected_Values($attr_id)
	{
		$this->products_attributes_model->DeleteSelectedValues(@$_POST['check']);
		
		redirect($this->_getBaseURI()."/values_list/$attr_id");
	}

}