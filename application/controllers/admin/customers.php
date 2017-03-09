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
        if($this->input->post())
        {
            if($this->customers_model->storeForm($this->input->post(),'',intval(@$record['id'])))
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

    /**
     * Display customers map
     */
    public function map()
    {
        if($this->input->get('format') == 'json')
        {
            $limit = intval($this->input->get('limit'));
            $customers = $this->customers_model->getMapList($limit);

            $routeTo = $this->customers_model->getLatLngById(intval($this->input->get('routeToClientId')));

            echo json_encode(
                array(
                    'customers' => $customers,
                    'map' => array(
                        'center' => array(
                            'lat' => 49.556937,
                            'lng' => 25.637646
                        )
                    ),
                    'routeTo' => $routeTo
                )
            );
        }
        else
        {
            $data['tpl_page'] = $this->_getController().'/map';
            parent::_OnOutput($data);
        }
    }

}