<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for discounts table.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Discounts_model extends Base_model
{
	//name of table
	protected $c_table = 'discounts';
	
	private $products_count = 0;
	private $order_amount = 0.00;
	private $discount_percent = 0;
	private $discount_amount = 0.00;
	
	/**
	 * Init discounts model.
	 *
	 */
	public function __construct()
    {
        parent::__construct();
        
        $this->init();
    }
	
	/**
	 * Init order info.
	 *
	 * @param integer|bool $products_count
	 * @param float|bool $order_amount
	 * @return void
	 */
	public function init($products_count=FALSE,$order_amount=FALSE)
	{
		if( !$products_count && isset($this->CI->cart) ) $this->products_count = $this->CI->cart->total_items();
		if( !$order_amount && isset($this->CI->cart) ) $this->order_amount = $this->CI->cart->total();
		$this->discount_percent = $this->calcDiscountPercent();
		$this->discount_amount = $this->calcDiscountAmount();
	}
	
	/**
	 * Return discount in percents for order.
	 *
	 * @return integer
	 */
	private function calcDiscountPercent()
	{
	    if( $this->db->table_exists($this->c_table)) $record = $this->db->query("select * from {$this->c_table} where products_count<=? and order_amount<=? order by discount_percent desc",array($this->products_count,$this->order_amount))->row_array();
	    if(!@$record) return 0;
	    return $record['discount_percent'];
	}
	
	/**
	 * Return discount in percents.
	 *
	 * @return integer
	 */
	public function getDiscountPercent()
	{
		return $this->discount_percent;
	}
	
	/**
	 * Return discount amount.
	 *
	 * @return float
	 */
	private function calcDiscountAmount()
	{
		return round(($this->order_amount*$this->discount_percent)/100,2);
	}
	
	/**
	 * Return discount in amount.
	 *
	 * @return float
	 */
	public function getDiscountAmount()
	{
		return $this->discount_amount;
	}
	
	/*public function getDiscountText()
	{
		if(!$this->order_amount || !$this->discount_amount) return "";
		
		return exchange($this->discount_amount)." ({$this->discount_percent}%)";
	}*/
	
	/**
	 * Reduce order amount. Minus discount.
	 *
	 * @return float
	 */
	public function minusDiscount()
	{
		return round($this->order_amount-$this->discount_amount,2);
	}
}