<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for customers.
 * 
 * @package customers  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Customers extends Admin 
{
	//name of table
    protected $c_table = "customers";
	//show records per page
    protected $per_page = 10;

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Customers
     */
	public function __construct()
	{
		parent::__construct();

		// RELOAD: Segments for OrderBy/OrderSeq/Offset/Item
		$this->segment_orderseq = $this->uri->segment($this->_getSegmentsOffset()+4,'desc');

		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('customers_model');
		$this->load->model('groups_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin','users'));
		
		// === Labels === //
		$this->fields_titles['name'] = language('name');
		$this->fields_titles['surname'] = language('surname');
		$this->fields_titles['email'] = language('email');
		$this->fields_titles['password'] = language('password');
		$this->fields_titles['repassword'] = language('repassword');
		$this->fields_titles['phone'] = language('phone');
		$this->fields_titles['phone2'] = language('phone2');
		$this->fields_titles['website'] = language('website');
		$this->fields_titles['city'] = language('city');
		$this->fields_titles['address'] = language('address');
		$this->fields_titles['zip_code'] = language('zip_code');
		$this->fields_titles['reg_date'] = language('reg_date');
		$this->fields_titles['is_admin'] = language('is_admin');
		$this->fields_titles['group_id'] = language('group');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('users');
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
		$this->load->library('form_validation');
		
		$id = intval(@$record['id']);
		
		if( !$id )
		{//register
			$configValidation1 = array(
               array(
                     'field'   => 'password', 
                     'label'   => parent::_getFieldTitle('password'), 
                     'rules'   => 'trim|required|min_length[5]|max_length[16]|md5'
                  ),
               array(
                     'field'   => 'repassword', 
                     'label'   => parent::_getFieldTitle('repassword'), 
                     'rules'   => 'trim|required|matches[password]'
                  )
            );
		}
		else 
		{//update
			$configValidation1 = array(
               array(
                     'field'   => 'password', 
                     'label'   => parent::_getFieldTitle('password'), 
                     'rules'   => 'trim|min_length[5]|max_length[16]|md5'
                  )
            );
            
            if($this->input->post('password'))
            {
            	$configValidation1[] = array(
                     'field'   => 'repassword', 
                     'label'   => parent::_getFieldTitle('repassword'), 
                     'rules'   => 'trim|required|matches[password]'
                  );
            }
		}
		
		$configValidation2 = array(
               array(
                     'field'   => 'email', 
                     'label'   => parent::_getFieldTitle('email'), 
                     'rules'   => 'trim|required|max_length[255]|valid_email|callback__unique_field_for_edit[email,'.$id.']'
                  ),
               array(
                     'field'   => 'name', 
                     'label'   => parent::_getFieldTitle('name'), 
                     'rules'   => 'trim|required|xss_clean'
                  ),
               array(
                     'field'   => 'surname', 
                     'label'   => parent::_getFieldTitle('surname'), 
                     'rules'   => 'trim|required|xss_clean'
                  ),
               array(
                     'field'   => 'phone', 
                     'label'   => parent::_getFieldTitle('phone'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'phone2', 
                     'label'   => parent::_getFieldTitle('phone2'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'website', 
                     'label'   => parent::_getFieldTitle('website'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'city', 
                     'label'   => parent::_getFieldTitle('city'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'address', 
                     'label'   => parent::_getFieldTitle('address'), 
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'zip_code', 
                     'label'   => parent::_getFieldTitle('zip_code'), 
                     'rules'   => 'trim|xss_clean'
                  )
            );
            
        $configValidation = array_merge($configValidation1,$configValidation2);

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			$record['tpl_page'] = $this->_getController().'/add';
		    parent::_OnOutput($record);
		}
		else
		{
			$post = array_merge($record,$_POST);
			
			if(!$post['password']) unset($post['password']);
			
			$this->customers_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI());
		}
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Add customer.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit customer.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->customers_model->getOneById($id);
		
		$this->_processInsert($record);
	}

}