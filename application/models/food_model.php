<?php
require_once(APPPATH.'models/posts_model.php');

/** 
 * This is model for food table.
 * Project: kurort-bukovel
 * 
 * @package food  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Food_model extends Posts_model
{
	//name of table
	protected $c_table = 'food';
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
		
		//Business lunch
		if( isset($filter_data['business_lunch']) && $filter_data['business_lunch'] )
		{
			$where .= " AND {$this->c_table}.business_lunch=1";
		}
		
		//With photo
		if( isset($filter_data['with_photo']) && $filter_data['with_photo'] )
		{
			$where .= " AND {$this->c_table}.photo1 != ''";
		}
		
		//Possible activities in the restaurant
		if( isset($filter_data['possible_activities']) && !empty($filter_data['possible_activities']) )
		{
			$where .= $this->_buildOrWhereForArray('possible_activities',$filter_data['possible_activities']);
		}
		
		//Cuisine
		if( isset($filter_data['cuisine']) && !empty($filter_data['cuisine']) )
		{
			$where .= $this->_buildOrWhereForArray('cuisine',$filter_data['cuisine']);
		}
        
		return $where;
    }
}