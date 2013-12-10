<?php
require_once(APPPATH.'controllers/abstract/front.php');

/** 
 * This is controller for shop cart.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Cart extends Front 
{
    /**
     * Init required models, helpers, language sections, pages' titles, css files etc.
     *
     * @return \Cart
     */
	public function __construct()
	{
		parent::__construct();
		
		// === Load Libraries === //
		$this->load->library('cart');
		
		// === Load Models === //
		$this->load->model(array('products_model','orders_model'));
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','front','cart'));
		
		// === Page Titles === //
		$this->page_titles['index'] = language('shopping_cart');
		//default page title
		$this->_setDefaultPageTitle();
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// ============= ACTION METHODS ================ //

	/**
	 * Show full cart information.
	 *
	 * @return void
	 */
	public function index()
	{
	    // === Current Location === //
		$data['current_location_arr'] =
		array(
			$this->_getBaseURL()."products"=>language('catalog'),
			$this->_getBaseURI()=>'[page_title]'
		);
		
		parent::_OnOutput($data);
	}
	
	/**
	 * Add product to cart.
	 *
	 * @return void
	 */
	public function add()
	{
	    $post = $this->input->post();
	    $qty = max(1,intval($post['qty']));
	    $products_attributes = isset($post['products_attributes'])?$post['products_attributes']:array();
	    
	    $product = $this->products_model->getOneById($post['id']);
	    
	    if($product)
	    {
    	    $data = array(
    	       'id' => $post['id'],
    	       'name' => $product['name'],
    	       'price' => $product['price'],
    	       'qty' => $qty,
    	       'options' => $products_attributes
    	    );
    	    
    	    $this->cart->insert($data);
    	    
    	    die( json_encode(array('success'=>1,'message'=>language('added_to_cart'))) );
	    }
	    
	    die( json_encode(array('error'=>1,'message'=>language('error').' : '.language('could_not_add_to_cart'))) );
	}
	
	/**
	 * Update products' quantity.
	 *
	 * @return void
	 */
	public function update()
	{
	    $data = $this->input->post();
	    
	    $this->cart->update($data);
	    
	    //if user entered discount coupon code
	    if(isset($data['discount_coupon_code']) && !empty($data['discount_coupon_code']) )
	    {
	    	//apply code if valid
	    	$this->discount_coupons_model->setDiscountCoupon($data['discount_coupon_code']);
	    }
	    
	    //if there is selected shipping method
	    if( isset($data['shipping_id']) )
	    {
	    	$this->shipping_model->setShipping($data['shipping_id']);
	    }
	    
	    //if clicked button "order" go to "confirm order" page
	    if(isset($data['order'])) redirect($this->_getBaseURL().'orders/confirm');
	    //show cart
	    else redirect($this->_getBaseURI());
	}
	
	/**
	 * Show short cart information: just products quantity and total price.
	 *
	 * @return void
	 */
	public function short()
	{
	    $items_in_cart = $this->cart->total_items();
	    
	    if($items_in_cart==1) $items_in_cart_lang_code = '1_item_in_cart';
	    elseif($items_in_cart==2) $items_in_cart_lang_code = '2_items_in_cart';
	    elseif($items_in_cart==3) $items_in_cart_lang_code = '3_items_in_cart';
	    elseif($items_in_cart==4) $items_in_cart_lang_code = '4_items_in_cart';
	    else $items_in_cart_lang_code = 'items_in_cart';
	    
	    //Denied to cache (IE will cache without this part)
	    $this->notCacheHeaders();
        
        $data['items_in_cart_lang_code'] = $items_in_cart_lang_code;
	    
        load_theme_view($this->_getController().'/'.$this->_getMethod(),$data);
	}
	
	/**
	 * Show cart in dialog box.
	 *
	 */
	public function dialog()
	{    
        //Denied to cache (IE will cache without this part)
	    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	    
	    load_theme_view($this->_getController().'/'.$this->_getMethod(),array());
	}
	
}