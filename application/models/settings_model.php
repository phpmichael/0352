<?php

/** 
 * This is settings model.
 * 
 * @package settings  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Settings_model extends CI_Model implements ArrayAccess
{
	//name of table
	protected $c_table = "settings";
	
	//name of primary field
	protected $id_column = "param";
	
	private $data;
    
	/**
	 * Init settings.
	 * 
	 * @uses self::data
	 * @return \Settings_model
	 */
    public function __construct()
    {
        $records = $this->db->get($this->c_table)->result_array();
        
        foreach ($records as $record)
        {
            $this->data[$record['param']] = $record['value'];
        }
    }
    
    /**
	 * Returns settings array.
	 * 
	 * @uses self::data
	 * @return array
	 */
    public function toArray()
    {
    	return $this->data;
    }
    
    // === ArrayAccess Implementation === //

    /**
     * Check if item exists.
     * @param mixed $key
     * @return bool
     */
    public function offsetExists($key)
    {
    	return isset($this->data[$key]);
    }

    /**
     * Get item.
     * @param mixed $key
     * @return mixed
     */
    public function offsetGet($key)
    {
    	return $this->data[$key];
    }

    /**
     * Set item.
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet($key,$value)
    {
    	if($this->offsetExists($key)) $this->db->update($this->c_table,array('value'=>$value),array('param'=>$key));
    	else $this->db->insert($this->c_table,array('param'=>$key,'value'=>$value));
    	
    	$this->data[$key] = $value;
    }

    /**
     * Unset item.
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
    	$this->data[$key] = '';
    	$this->db->delete($this->c_table,array('param'=>$key));
    }
	
}