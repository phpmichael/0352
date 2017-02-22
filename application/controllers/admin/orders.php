<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for orders.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Orders extends Admin 
{
	//name of table
    protected $c_table = "orders";

    /**
     * Constructor for Orders controller.
     *
     * @return \Orders
     */
	public function __construct()
	{
		parent::__construct();
		
		// RELOAD: Segments for OrderBy/OrderSeq/Offset/Item
		$this->segment_orderseq = $this->uri->segment($this->_getSegmentsOffset()+4,'desc');

		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('orders_model');
		$this->load->model('products_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin','cart','orders'));
		
		// === Labels === //
		$this->fields_titles['order'] = language('order');
		$this->fields_titles['customer_id'] = language('customer');
		$this->fields_titles['total'] = language('total');
		$this->fields_titles['status'] = language('status');
		$this->fields_titles['date'] = language('date');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('orders');
		$this->page_titles['edit'] = language('edit');
		$this->page_titles['calendar'] = 'Orders Calendar';
		//default page title
		$this->_setDefaultPageTitle();
		
		// === CSS Styles === //
		$this->css_files = array(
		      'css/order-details.css',
		);
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	/**
	 * Build right top admin menu.
	 * Overrides parent method.
	 * 
	 * @return string
	 */
	public function _built_right_menu()
	{
		return '';
	}

	/**
	 * Validate and update data.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsert(array $record=array())
	{
		$this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'status', 
                     'label'   => parent::_getFieldTitle('status'), 
                     'rules'   => 'trim|required|numeric'
                  )
            );

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			$record['tpl_page'] = $this->_getController().'/edit';
		    parent::_OnOutput($record);
		}
		else
		{
			$this->orders_model->setStatus($record['id'],$this->input->post('status'));
			
			redirect($this->_getBaseURI());
		}
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

    /**
	 * Edit order.
	 * 
	 * @return void
	 */
    public function Edit()
	{
		$this->load->model('formbuilder_model');
	    $this->load->helper('formbuilder');
	    
	    //add formbuilder styles
	    $this->css_files = array(
		      'css/fb/styles.css',
		      $this->_getTheme().'fb/styles.css',
		);
		
	    
	    $id = $this->segment_item;

		// === GET RECORD === //
		$record = $this->orders_model->getOneById($id);
		
		$this->_processInsert($record);
	}

	/**
	 * Show orders like calendar
	 *
	 */
	public function Calendar()
	{
		if( ($start = intval($this->input->get('start'))) && ($end = intval($this->input->get('end'))) )
		{
			$items = $this->orders_model->calendar($start, $end);

			echo json_encode($items);
		}
		else
		{
			$data['tpl_page'] = $this->_getController().'/calendar';

			parent::_OnOutput($data);
		}
	}

}