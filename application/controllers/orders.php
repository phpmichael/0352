<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for orders.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Orders extends Front 
{
	/**
	 * Init required models, helpers, language sections, pages' titles, css files etc.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// === Load Libraries === //
		$this->load->library('cart');
		
		// === Load Models === //
		$this->load->model('products_model');
		$this->load->model('orders_model');
		$this->load->model('pages_model');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','cart','orders'));
		
		// === Page Titles === //
		$this->page_titles['history'] = language('my_orders_history');
		$this->page_titles['confirm'] = language('confirm_order');
		$this->page_titles['fill_customer_info'] = language('your_information');
		//default page title
		$this->_setDefaultPageTitle();
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// ============= ACTION METHODS ================ //

	/**
	 * Show orders history.
	 *
	 * @return void
	 */
	public function history()
	{
	    $this->_CheckLogged();
	    
	    // === CSS Styles === //
		$this->css_files = array(
		      'css/order-details.css',
		);
	    
	    $data['orders'] = $this->orders_model->getMy();
	    
	    parent::_OnOutput($data);
	}
	
	/**
	 * Fill and store customer information.
	 *
	 */
	public function fill_customer_info()
	{
		$this->load->model('formbuilder_model');
	    $this->load->helper('formbuilder');
	    
	    //add formbuilder styles
	    $this->css_files = array(
		      'css/fb/styles.css',
		      $this->_getTheme().'fb/styles.css',
		);
	    
		//if customers submitted data
	    if($this->input->post())
		{
		    //add or change customer info
		    $data_key = $this->formbuilder_model->storeForm($this->input->post(),"orders_customer_info",$this->session->userdata('orders_customer_info_id'));
		    
		    if($data_key) 
		    {
		        $sessdata['orders_customer_info'] = $this->input->post();
		        $sessdata['orders_customer_info_id'] = $data_key;
		        $this->session->set_userdata($sessdata);
		        
		        redirect($this->_getBaseURI().'/confirm');
		    }
		    //if invalid data
		    else $this->formbuilder_model->setFormData($this->input->post());
		}
		//if there is already stored customer info (ie back to this page after it filled)
		elseif ( $this->session->userdata('orders_customer_info_id') )
		{
		    $this->formbuilder_model->setFormData($this->session->userdata('orders_customer_info'));
		}
	    
	    // === Currenr Location === //
		$data['current_location_arr'] =
		array(
			$this->_getBaseURL()."products"=>language('catalog'),
			$this->_getBaseURL()."cart"=>language('shopping_cart'),
			$this->_getBaseURI()."/".$this->_getMethod()=>'[page_title]'
		);
		
		parent::_OnOutput($data);
	}
	
	/**
	 * Show page with order details for confirm.
	 *
	 * @return void
	 */
	public function confirm()
	{
	    //if login not required to make order
	    if( @$this->settings_model['order_not_require_login'] )
	    {
	        //if no filled customer info
    	    if( !$this->session->userdata('orders_customer_info_id') )
    		{
    		    redirect($this->_getBaseURL()."orders/fill_customer_info");
    		}
	    }
	    else 
	    {
	        //if customer not logged - redirect to registration
    	    if( !$this->_is_logged() )
    		{
    			$sessdata['redirect_after_registration'] = $this->_getBaseURI()."/confirm";
    			$this->session->set_userdata($sessdata);
    		    redirect($this->_getBaseURL()."customers/register");
    		}
	    }
		
		// === Currenr Location === //
		$data['current_location_arr'] =
		array(
			$this->_getBaseURL()."products"=>language('catalog'),
			$this->_getBaseURL()."cart"=>language('shopping_cart')
		);
		
		if( @$this->settings_model['order_not_require_login'] ) $data['current_location_arr'][$this->_getBaseURI()."/fill_customer_info"] = language('your_information');
		$data['current_location_arr'][$this->_getBaseURI()."/".$this->_getMethod()] = '[page_title]';
	    
	    parent::_OnOutput($data);
	}
	
	/**
	 * Make order.
	 * 
	 * @return void
	 */
	public function place()
	{
	    //if login not required to make order
	    if( @$this->settings_model['order_not_require_login'] )
	    {
	        //if no filled customer info
    	    if( !$this->session->userdata('orders_customer_info_id') )
    		{
    		    redirect($this->_getBaseURL()."orders/fill_customer_info");
    		}
	    }
	    else $this->_CheckLogged();
	    
	    //calculate order total before store it (b'se after store coupon uses count reduced)
	    $order_total = $this->orders_model->calcOrderTotal();
	    
	    //store order
	    $order_id = $this->orders_model->store();
	    
	    //if no filled customer info
	    if( !($post = $this->session->userdata('orders_customer_info')) )
	    {
            //get logged customer's data
            $post = $this->customers_model->getLogged();
	    }
	    else //if it is
	    {
	        //remove customer info from session
	        $sessdata['orders_customer_info'] = FALSE;
	        $sessdata['orders_customer_info_id'] = FALSE;
	        $this->session->unset_userdata($sessdata);
	    }
	    
	    $post['order_content'] = $this->orders_model->show($order_id);
	    $post['order_total'] = exchange($order_total);
	    
	    //mailing
		$this->load->model('auto_responders_model');
		
		//send invoice
		$this->auto_responders_model->send(3,$post['email'],$post);
		
		//send notification
		$this->auto_responders_model->send(4,$this->settings_model['site_email'],$post);
		
		//clear cart
	    $this->cart->destroy();
	    
	    //get "order placed" page
	    $page = $this->pages_model->getByLink('order-placed');
	    
		//redirect
	    redirect($this->_getBaseURL(). 'page/'.$page['slug']);
	}
	
}