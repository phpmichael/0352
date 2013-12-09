<?php
require_once(APPPATH.'controllers/abstract/admin_fb.php');

/** 
 * This is admin controller for books.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Books extends Admin_fb 
{
    protected $process_form_html_id = "books"; 
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	/**
	 * Validate and insert or update data.
	 * 
	 * @param char(16) $data_key
	 * @return void
	 */
	protected function _processInsert($data_key=FALSE,$form_mode='edit')
	{
		if($data_key) $this->load->vars($this->books_model->getOneById($data_key));
	    
		parent::_processInsert($data_key,$form_mode);
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
            $this->books_model->$method($this->input->post('check'));
            
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
	 * Update price for all products.
	 *
	 * @return void
	 */
	public function Whole_Prices_Update()
	{
	    $sign = $this->input->post('sign');
	    $value = $this->input->post('value');
	    $type = $this->input->post('type');
	    
	    $this->books_model->wholePricesUpdate($sign,$value,$type);
	    
	    redirect(aurl());
	}
}