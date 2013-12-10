<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for shipping table.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Shipping_model extends Base_model
{
	//name of table
	protected $c_table = 'shipping';
	//name of primary field
	protected $id_column = 'data_key';
	
	/**
	 * Set shipping method.
	 *
	 * @param string(16) $data_key
	 * @return bool
	 */
	public function setShipping($data_key)
	{
		if( !($shipping = $this->getOneById($data_key)) ) 
	    {
	    	
	    	$sessdata['shipping_selected'] = FALSE;
	    	$this->session->unset_userdata($sessdata);
	    	
	    	return FALSE;
	    }
		else 
		{
			$sessdata['shipping_selected'] = $shipping;
			$this->session->set_userdata($sessdata);
		
			return TRUE;
		}
	}

    /**
     * Return currently selected shipping.
     *
     * @param bool|string $field
     * @return mixed
     */
	public function getSelectedShipping($field=FALSE)
	{
		$shipping = $this->session->userdata('shipping_selected');	
		
		if($field && isset($shipping[$field])) return $shipping[$field];
		else return $shipping;
	}
	
	/**
	 * Return shipping list.
	 *
	 * @return array
	 */
	public function getShippingList()
	{
		$shipping_arr = $this->getAll();
		
		if(empty($shipping_arr)) return array();
		
		$shipping_list = array(''=>'');
		
		foreach ($shipping_arr as $item)
		{
			$shipping_list[$item['data_key']] = $item['title'];
			if( $item['cost'] != 0.00 ) $shipping_list[$item['data_key']] .= ' - '.exchange($item['cost']);
		}
		
		return $shipping_list;
	}
	
}