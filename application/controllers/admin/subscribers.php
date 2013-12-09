<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for subscribers.
 * 
 * @package subscribers  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Subscribers extends Admin 
{
	//name of table
    protected $c_table = "subscribers";
	
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
		$this->load->model('subscribers_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Labels === //
		$this->fields_titles['email'] = language('email');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('subscribers');
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
		
		$configValidation = array(
               array(
                     'field'   => 'email', 
                     'label'   => parent::_getFieldTitle('email'), 
                     'rules'   => 'trim|required|max_length[255]|valid_email|callback__unique_field_for_edit[email,'.$id.']'
                  )
            );

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			$record['tpl_page'] = $this->_getController().'/add';
		    parent::_OnOutput($record);
		}
		else
		{
			$post = array_merge($record,$_POST);
			
			$this->subscribers_model->insertOrUpdate($post);
			
			redirect($this->_getBaseURI());
		}
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Add subscriber.
	 * 
	 * @return void
	 */
	public function Add()
	{
		$this->_processInsert();
	}
	
	/**
	 * Edit subscriber.
	 * 
	 * @return void
	 */
	public function Edit()
	{
		$id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->subscribers_model->getOneById($id);
		
		$this->_processInsert($record);
	}
	
	/**
	 * Returns emails list in CSV format.
	 * 
	 * @return string
	 */
	public function Download_CSV()
	{
		$this->load->helper('download');
		$this->load->dbutil();

		$this->db->select("email");
		$query = $this->db->get($this->c_table);

		$delimiter = ";";
		$newline = "\r\n";
		$data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
		
		$file_name = "Subscribers_".date('Y-m-d_H:i:s').".csv";
		
		force_download($file_name, $data);
	}
	
}