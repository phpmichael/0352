<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for discount_coupons table.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Discount_coupons_model extends Base_model
{
	//name of table
	protected $c_table = 'discount_coupons';
	
	/**
	 * Set discount code.
	 *
	 * @param string $code
	 * @return bool
	 */
	public function setDiscountCoupon($code)
	{
	    if( !($coupon = $this->getValidCoupon($code)) ) return FALSE;
		
		//store coupon in session
		$sessdata['discount_coupon_code'] = $code;
		$this->session->set_userdata($sessdata);
		
		return TRUE;
	}
	
	/**
	 * Check if valid coupon's code. Find coupon by code and check if it valid. Return coupon.
	 *
	 * @param string $code
	 * @return array|bool
	 */
	public function getValidCoupon($code)
	{
		if( !preg_match("/^[a-zA-Z0-9]+$/",$code) ) //check if coupon is alphanumeric chars only
		{
			$this->setError("Coupon code id not valid.");
			return FALSE;
		}
		elseif( !($coupon = $this->getCouponByCode($code)) ) 
		{
			$this->setError("Coupon with this code not found.");
			return FALSE;
		}
		elseif( $coupon['used']>= $coupon['possible_uses'] ) //coupon has limited number of uses
		{
			$this->setError("Coupon could not be used anymore.");
			return FALSE;
		}
		elseif( $coupon['amount']> $this->getOrderAmount() ) //coupon discount could not be greater than order amount
		{
			$this->setError("This coupon valid just for order total not less than ".exchange($coupon['amount']));
			return FALSE;
		}
		
		return $coupon;
	}
	
	/**
	 * Search coupon by code.
	 *
	 * @param string $code
	 * @return array
	 */
	private function getCouponByCode($code)
	{
		return $this->db->get_where($this->c_table,array('code'=>$code))->row_array();
	}
	
	/**
	 * Calculate discount amount for percent coupon.
	 *
	 * @param array $coupon
	 * @return float
	 */
	private function calcCouponDiscount(&$coupon)
	{
		//if coupon available for special products
		if( @$this->settings_model['use_coupon_for_specials'] ) 
		{
			$order_total = $this->getOrderAmount();//get regular cart total
		}
		else//if coupons doesn't available for special products
		{
			$order_total = 0.00;
			
			foreach ($this->CI->cart->contents() as $item)
			{
				//don't calculate price for special products
				$item_price = ( ($old_price = $this->products_model->getOldPrice($item['id']))>0 ) ? 0.00 : $item['price'];
				
				$order_total += ( $item_price * $item['qty'] );//price*qty
			}
		}
		
		if( $coupon['percents'] ) $coupon['amount'] = ($order_total*$coupon['percents'])/100;
		
		return round($coupon['amount'],2);
	}
	
	/**
	 * Reduce order amount. Minus coupon discount.
	 *
	 * @return float
	 */
	public function minusCouponDiscount()
	{
		$coupon = $this->getActiveDiscountCoupon();
		
		$coupon_discount = ($coupon) ? $coupon['amount'] : 0;

		return round($this->getOrderAmount()-$coupon_discount,2);
	}
	
	/**
	 * Remove coupon from session.
	 *
	 * @return void
	 */
	private function unsetCoupon()
	{
		$sessdata['discount_coupon_code'] = FALSE;
		$this->session->unset_userdata($sessdata);
	}
	
	/**
	 * Return currently used coupon code.
	 *
	 * @return array
	 */
	public function getActiveDiscountCoupon()
	{
		$code = $this->session->userdata('discount_coupon_code');	
		if(!$code) return FALSE;
		
		//check if coupon still valid (maybe somebody already used it when customer waiting :) )
		$coupon = $this->getValidCoupon($code);
		
		//if coupon is not valid anymore
		if( !$coupon )  
		{
			$this->unsetCoupon();
			return FALSE;
		}
		
		//for percent discount
		$this->calcCouponDiscount($coupon);
		
		//coupon discount could not be greater than order amount
		if( $this->getOrderAmount() < $coupon['amount'] ) 
		{
			$this->unsetCoupon();
			return FALSE;
		}
		
		return $coupon;
	}
	
	/**
	 * Return order amount.
	 *
	 * @return float
	 */
	private function getOrderAmount()
	{
		if( isset($this->CI->cart) ) return $this->CI->cart->total();
		return 0.00;
	}
	
	/**
	 * Return error from session and remove it.
	 *
	 * @return string
	 */
	public function getError()
	{
		//get error from session
		$error = $this->session->userdata('discount_coupon_error');
		
		//remove error from session 
		$sessdata['discount_coupon_error'] = FALSE;
		$this->session->unset_userdata($sessdata);
		
		return $error;
	}
	
	/**
	 * Set error in session.
	 *
	 * @param string $error
	 */
	private function setError($error)
	{
		$sessdata['discount_coupon_error'] = $error;
		$this->session->set_userdata($sessdata);
	}

    /**
     * Increase coupon uses.
     * @param string $code
     * @param int $used
     */
    public function increaseCouponUses($code,$used)
	{
		$this->db->update($this->c_table, array('used'=>($used+1)), array('code'=>$code) );
	}
	
	/**
	 * Insert data. Returns ID field.
	 * Override parent method.
	 * 
	 * @param array $post
	 * @return integer
	 */
	public function Insert($post)
	{
	    //generate coupon code
	    $post['code'] = random_string($post['coupon_format'],10);//CHECK IF UNIQUE !!!
	    
	    return parent::Insert($post);
	}
}