<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for wishlist.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Wishlist_model extends Base_model
{
	//name of table
	protected $c_table = 'wishlist';
	
	/**
	 * Add product to customer's wishlist.
	 *
	 * @param integer $customer_id
	 * @param integer|string $product_id
	 * @return integer|bool
	 */
	public function add($customer_id,$product_id)
	{
		if(!intval($customer_id) || !$product_id) return FALSE;
		
		$exists = $this->db->get_where($this->c_table,array('customer_id'=>$customer_id,'product_id'=>$product_id))->result_array();
		if($exists) return TRUE;
		
		return parent::Insert(array('customer_id'=>$customer_id,'product_id'=>$product_id));
	}
	
	/**
	 * Remove product from customer's wishlist.
	 *
	 * @param integer $customer_id
	 * @param integer $wishlist_id
	 * @return bool
	 */
	public function remove($customer_id,$wishlist_id)
	{
		if(!intval($customer_id) || !intval($wishlist_id)) return FALSE;
		
		$wishlist_item = parent::getOneById($wishlist_id);
		if($wishlist_item['customer_id']==$customer_id)
		{
			parent::DeleteId($wishlist_id);
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Returns customer's wishlist.
	 * 
	 * @return array
	 */
    public function getMy()
    {
    	$records = $this->db->get_where($this->c_table,array('customer_id' => $this->CI->session->userdata('customer_id')))->result_array();
    	
    	foreach ($records as &$record)
    	{
    		$record['product'] = $this->CI->products_model->getOneById($record['product_id']);
    	}
    	
    	return $records;
    }
    
    /**
	 * Delete product from all wishlists (when product deleted).
	 * 
	 * @param integer $product_id
	 * @return void
	 */
	public function deleteProductFromWishlists($product_id)
	{
		if(intval($product_id)) $this->db->delete($this->c_table, array('product_id' => $product_id));
	}
	
	/**
	 * Delete customer's wishlist (when customer deleted).
	 * 
	 * @param integer $customer_id
	 * @return void
	 */
	public function deleteCustomerWishlist($customer_id)
	{
		if(intval($customer_id)) $this->db->delete($this->c_table, array('customer_id' => $customer_id));
	}
	
	/**
	 * Check if product in wishlist.
	 *
	 * @param integer $product_id
	 * @return bool
	 */
	public function isProductInWishlist($product_id)
	{
	    $customer_id = $this->CI->session->userdata('customer_id');
	    if(!$customer_id) return FALSE;
	    return (bool)$this->db->get_where($this->c_table,array('customer_id'=>$customer_id,'product_id'=>$product_id))->result_array();
	}
	
}