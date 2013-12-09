<?php
require_once(APPPATH.'models/posts_model.php');

/** 
 * This is model for company table.
 * 
 * @package messageboard  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Companies_model extends Posts_model
{
	//name of table
	protected $c_table = "companies";
    //name of ...
	protected $c_type = "company";
    
    /**
	 * Make array of search/sort creterias.
	 * 
	 * @return array
	 */
    public function getFilterData()
    {
    	$filter_data = parent::getFilterData();
    	
    	//category filter
		if(is_array(@$filter_data['category'])) $filter_data['category'] = $this->getCategoryFilter();
		
		return $filter_data;
    }
    
    /**
	 * Make sql creterias based on $filter_data.
	 * 
	 * @param $filter_data
	 * @return string
	 */
    protected function _buildWhere($filter_data = array())
    {
		$filter_data['keywords'] = trim(urldecode(@$filter_data['keywords']));
    	
    	$where = "name!=''";
		
		if(@$filter_data['category'])
		{
			$where .= " AND {$this->posts_categories_table}.category_id=".intval($filter_data['category']);
		}
		if($filter_data['keywords'])
		{
			$where .= " AND CONCAT(name,'|',email,'|',website,'|',city,'|',region,'|',address,'|',short_description,'|',services,'|',long_description) LIKE '%".$this->db->escape_str($filter_data['keywords'])."%'";
		}
		
		return $where;
    }
    
}