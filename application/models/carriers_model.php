<?php
require_once(APPPATH.'models/posts_model.php');

/** 
 * This is model for carriers table.
 * Project: kurort-bukovel
 * 
 * @package carriers  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Carriers_model extends Posts_model
{
	//name of table
	protected $c_table = 'carriers';
	//name of primary field
	protected $id_column = 'data_key';
    
    /**
	 * Make sql creterias based on $filter_data.
	 * 
	 * @param $filter_data
	 * @return string
	 */
    protected function _buildWhere(array $filter_data = array())
    {
        $where = "1";
		
		//Price
		if( isset($filter_data['price_1']) && $filter_data['price_1'] )
		{
			$where .= " AND {$this->c_table}.price >= ".(float)($filter_data['price_1']);
		}
		if( isset($filter_data['price_2']) && $filter_data['price_2'] )
		{
			$where .= " AND {$this->c_table}.price <= ".(float)($filter_data['price_2']);
		}
		
		//With photo
		if( isset($filter_data['with_photo']) && $filter_data['with_photo'] )
		{
			$where .= " AND {$this->c_table}.photo1 != ''";
		}
        
		return $where;
    }
    
	
}