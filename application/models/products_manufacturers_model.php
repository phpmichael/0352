<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for manufacturers table.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Products_manufacturers_model extends Base_model
{
	//name of table
	protected $c_table = 'products_manufacturers';
	
	/**
	 * Return list of manufacturers.
	 *
	 * @param bool $none 
	 * @return array
	 */
	public function getManufacturersList($none=TRUE)
	{
		$records = $this->db->get($this->c_table)->result_array();
		
		$list = multi2singleArray('id','name',$records);

        if($none) $list[0] = language('none');

        ksort($list);

		return $list;
	}
	
	/**
	 * Return manufacturer name by ID.
	 *
	 * @param integer $id
	 * @return string
	 */
	public function getManufacturerName($id)
	{
	    if(!$id) return "";
	    
	    $record = $this->getOneById($id);
	    
	    if(!$record) return "";
	    
	    return $record['name'];
	}

    /**
     * Return manufacturer's description by name
     * @param string $name
     * @return string
     */
    public function getDescriptionByName($name)
    {
        $record = $this->db->get_where($this->c_table, array('name' => $name))->row_array();
        if($record) return $record['description'];
        return '';
    }
	
	/**
	 * Delete record by ID.
	 * Override parent method.
	 * 
	 * @param integer $id
	 * @return void
	 */
	public function DeleteId($id)
	{
	    $this->db->update('products',array('manufacturer_id'=>0), array('manufacturer_id' => $id));
	    
	    parent::DeleteId($id);
	}
	
}