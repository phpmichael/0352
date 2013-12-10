<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for shop order.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Orders_model extends Base_model
{
	//name of table
	protected $c_table = 'orders';
	
	private $tables = array(
		'orders' => 'orders',
		'orders_cart' => 'orders_cart',
		'orders_cart_attributes' => 'orders_cart_attributes',
		'orders_customer_info' => 'orders_customer_info',
	);

	//order statuses
	private $statuses = array(
	   0 => 'pending',
	   1 => 'approved',
	   2 => 'payed',
	   3 => 'processing',
	   4 => 'declined',
	   5 => 'shipped',
	);
	
	/**
	 * Calculate order total.
	 *
	 * @return float
	 */
	public function calcOrderTotal()
	{
		//if there is active discount coupon - use it
	    if( $this->CI->discount_coupons_model->getActiveDiscountCoupon() ) 
		{
		    $total = $this->CI->discount_coupons_model->minusCouponDiscount();
		}
		//else - use regular discount
		else 
		{
		    $total = $this->CI->discounts_model->minusDiscount();
		}
		
		//add shipping amount
		$total += $this->shipping_model->getSelectedShipping('cost');
		
		return $total;
	}
	
 
	/**
	 * Store order.
	 * 
	 * @return integer
	 */
	public function store()
	{
		$cart_items = $this->CI->cart->contents();
		
		if( empty($cart_items) ) return FALSE;
	    
		//add order info
	    $order['customer_id'] = $this->CI->session->userdata('customer_id');
	    $order['orders_customer_info_id'] = $this->CI->session->userdata('orders_customer_info_id');
		$order['subtotal'] = $this->CI->cart->total();
		$order['total'] = $this->calcOrderTotal();
		
		//if there is active discount coupon 
		if( $discount_coupon = $this->CI->discount_coupons_model->getActiveDiscountCoupon() )
		{
			$order['discount_coupon'] = $discount_coupon['code'];
			$order['discount_percent'] = $discount_coupon['percents'];
			$order['discount_amount'] = $discount_coupon['amount'];
			
			//increase coupon uses (this line should go after order total calculation)
			$this->CI->discount_coupons_model->increaseCouponUses($discount_coupon['code'],$discount_coupon['used']);
		}
		//if regular discount
		else 
		{
			$order['discount_percent'] = $this->CI->discounts_model->getDiscountPercent();
			$order['discount_amount'] = $this->CI->discounts_model->getDiscountAmount();
		}
		
		//if there is selected shipping method
		if( $this->CI->shipping_model->getSelectedShipping() )
		{
			$order['shipping_id'] = $this->CI->shipping_model->getSelectedShipping('data_key');
			$order['shipping_title'] = $this->CI->shipping_model->getSelectedShipping('title');
			$order['shipping_amount'] = $this->CI->shipping_model->getSelectedShipping('cost');
		}

	    $order_id = parent::insert($order);
	    
	    //add order's products
	    foreach ($cart_items as $item)
	    {
	    	$this->c_table = $this->tables['orders_cart'];
	    	
	    	$data['order_id'] = $order_id;
	        $data['product_id'] = $item['id'];
	        $data['qty'] = $item['qty'];
	        $data['price'] = $item['price'];
	        
	        $order_cart_id = parent::insertOrUpdate($data);
	        
	        //add product's attributes
	        if(isset($item['options']))
	        {
	        	$this->c_table = $this->tables['orders_cart_attributes'];
	        	
	        	foreach ($item['options'] as $option_key=>$option_value)
	        	{
	        		$attribute['order_cart_id'] = $order_cart_id;
	        		$attribute['attr_id'] = $option_key;
	        		$attribute['value_id'] = $option_value;
	        		
	        		parent::insertOrUpdate($attribute);
	        	}
	        }
	    }
	    
	    $this->c_table = $this->tables['orders'];
	    
	    return $order_id;
	}
	
	/**
	 * Return ordered products list.
	 *
	 * @param integer $order_id
	 * @return array
	 */
	private function getOrderCart($order_id)
	{
	    return $this->db->query("SELECT * FROM {$this->tables['orders_cart']} WHERE order_id = ?",array($order_id))->result_array();
	}
	
	/**
	 * Return order box.
	 *
	 * @param integer $order_id
	 * @return string
	 */
	public function show($order_id)
	{
	    $order = $this->getOneById($order_id);
	    $orders_cart = $this->getOrderCart($order_id);
	    
	    foreach ($orders_cart as $key=>$record)
	    {
	    	$orders_cart[$key]['product_name'] = $this->CI->products_model->getNameById($record['product_id']);
	        
	    	$attributes = array();
	    	
	        if($this->db->table_exists($this->tables['orders_cart_attributes'])) $attributes = $this->db->query("SELECT * FROM {$this->tables['orders_cart_attributes']} WHERE order_cart_id=?",array($record['id']))->result_array();
	    	
	    	if(!empty($attributes))
	    	{
		    	foreach ($attributes as $attribute)
		    	{
		    		$orders_cart[$key]['options'][$attribute['attr_id']] = $attribute['value_id'];
		    	}
	    	}
	    }
	    //dump($orders_cart);exit;
	    return load_theme_view('orders/details',array('orders_cart'=>$orders_cart,'order'=>$order),TRUE);
	    
	   /* $str = "
	    <style type='text/css'>
	    table.table-order-deatils
	    {
	       width:100%;
	       border-collapse:separate;
	       border-spacing:5px;
	       border:1px solid #999;
	    }
	    table.table-order-deatils th, table.table-order-details td{
	       padding:2px;
	       border:1px solid #999;
	    }
	    table.table-order-details td.a-right{
	       text-align:right;
	    }
	    </style>
	    ";
	    
	    $str .= "<table width='100%' class='table-order-deatils'>";
	    $str .= "<tr><th width='65%'>".language('thing_name')."</th><th width='10%'>".language('quantity')."</th><th width='10%'>".language('price')."</th width='15%'><th>".language('subtotal')."</th></tr>";
	    foreach ($orders_cart as $item)
	    {
	        $product_name = utf8_wordwrap($this->CI->products_model->getNameById($item['product_id']),40," ");
	        
	        $str .= "<tr><td>{$product_name}</td><td class='a-right'>{$item['qty']}</td><td class='a-right'>{$item['price']}</td><td class='a-right'>".$item['qty']*$item['price']."</td></tr>";
	    }
	    
	    $str .= "</table>";
	    
	    return $str;*/
	}
	
	/**
	 * Return order total.
	 *
	 * @param integer $order_id
	 * @return float
	 */
	/*public function getTotal($order_id)
	{
	    $record = $this->getOneById($order_id);
	    return $record['total'];
	}*/
	
	/**
	 * Return status text by ID (translated).
	 *
	 * @param integer $status
	 * @return string
	 */
	public function getStatusText($status)
	{
	    return language($this->statuses[$status]);
	}
	
	/**
	 * Return array of statuses (translated).
	 *
	 * @return array
	 */
	public function getStatuses()
	{
	    foreach ($this->statuses as $status=>$text)
	    {
	        $statuses[$status] = language($text);
	    }
	    return $statuses;
	}
	
	/**
	 * Set order's status.
	 *
	 * @param integer $order_id
	 * @param integer $status
	 * @return void
	 */
	public function setStatus($order_id,$status)
	{
	    $data['id'] = $order_id;
	    $data['status'] = $status;
	    parent::insertOrUpdate($data);
	}
	
	/**
     * Delete order by ID.
     *
     * @param integer $order_id
     * @return void
     */
    public function DeleteId($order_id)
    {
        //delete from orders_cart_attributes
        if($this->db->table_exists($this->tables['orders_cart_attributes']))
        {
	        $orders_cart = $this->getOrderCart($order_id);
	        foreach ($orders_cart as $orders_cart_item)
	        {
	            $this->db->delete($this->tables['orders_cart_attributes'], array('order_cart_id' => $orders_cart_item['id']));
	        }
        }
        
        //delete from orders_cart
        $this->db->delete($this->tables['orders_cart'], array('order_id' => $order_id));
        
        //delete customer info
        $order = $this->getOneById($order_id);
        if( @$order['orders_customer_info_id'] ) $this->db->delete($this->tables['orders_customer_info'], array('data_key' => $order['orders_customer_info_id']));
        
        //delete from orders
        parent::DeleteId($order_id);
    }
	
	/**
	 * Return customer's orders.
	 *
	 */
	public function getMy()
	{
	    $this->db->order_by("id", "desc");
		
    	return $this->db->get_where($this->c_table,array('customer_id' => $this->CI->session->userdata('customer_id')))->result();
	}
	
	/**
	 * Return information of customer.
	 *
	 * @param integer $orders_customer_info_id
	 * @return array
	 */
	public function getOrderCustomerInfo($orders_customer_info_id)
	{
	    return $this->db->get_where($this->tables['orders_customer_info'],array('orders_customer_info_id' => $orders_customer_info_id))->result_array();
	}
	
	// === Dashboard: Start === //
    /**
     * Generate widget for dashboard.
     *
     * @return string
     */
    public function dashboardWidget()
    {
    	$widget = parent::dashboardWidget();
    	
    	$widget['content'] .= "
    	<p>
    		".$this->CI->filters_model->filterAnchorByCode('pending_orders',language('amount_of_pending'),'orders')." - ".$this->count(array('status'=>0))."
    	</p>
    	";
    	
    	return $widget;
    }
    // === Dashboard: End === //
	
}