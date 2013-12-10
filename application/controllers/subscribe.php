<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for subscription.
 * 
 * @package subscribers  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Subscribe extends Front 
{
	//name of table
    protected $c_table = "subscribers";

    /**
     * Init required models, helpers, language sections, pages' titles, css files etc.
     *
     * @return \Subscribe
     */
	public function __construct()
	{
		parent::__construct();	
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','subscribe'));
		
		// === Load Models === //
		$this->load->model('subscribers_model');
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //


	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //
	
	
	public function Index()
	{	
	}
	
	/**
	 * Subscribe new customer (add his email to table).
	 * 
	 * @return void
	 */
	public function Insert_Email()
	{
		$this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'email', 
                     'label'   => parent::_getFieldTitle('email'), 
                     'rules'   => 'trim|required|max_length[255]|valid_email|callback__unique_field[email]'
                  )
            );

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			echo "<span class='red'>".validation_errors()."</span>";
		}
		else 
		{
			$this->subscribers_model->addEmail($this->input->post('email'));
			echo "<span class='green'>".language('your_email_address_added_in_mailing_list')."</span>";
		}
		exit;
	}
	
	/**
	 * Show unsubscribe form.
	 * 
	 * @return void
	 */
	public function Unsubscribe()
	{
		// === Main Data === //
		$this->_setPageTitle(language('unsubscribe'));
		
		parent::_OnOutput();
	}
	
	/**
	 * Unsubscribe customer (remove his email to table).
	 * 
	 * @return void
	 */
	public function Do_Unsubscribe()
	{
		$this->load->library('form_validation');
		
		$configValidation = array(
               array(
                     'field'   => 'email', 
                     'label'   => parent::_getFieldTitle('email'), 
                     'rules'   => 'trim|required|max_length[255]|valid_email|callback__value_exists[email]'
                  )
            );

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() == FALSE)
		{
			echo "<span class='red'>".validation_errors()."</span>";
		}
		else 
		{
			$this->subscribers_model->unsubscribe($this->input->post('email'));
			echo "<span class='green'>".language('your_email_address_removed_from_mailing_list')."</span>";
		}
		exit;
	}
	
}