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
     * @return \Subscribers
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
        if($this->input->post())
        {
            if($this->subscribers_model->storeForm($this->input->post(),'',@$record['id']))
            {
                redirect($this->_getBaseURI());
            }
        }

        $record['tpl_page'] = $this->_getController().'/add';
        parent::_OnOutput($record);
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