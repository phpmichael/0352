<?php
require_once(APPPATH.'models/posts_model.php');


/** 
 * This is model for jobs table.
 * 
 * @package messageboard  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Jobs_model extends Posts_model
{
	//name of table
	protected $c_table = "jobs";
	//name of ...
	protected $c_type = "job";

	/**
	 * Make array of search/sort criterias.
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
	 * Make sql criterias based on $filter_data.
	 * 
	 * @param $filter_data
	 * @return string
	 */
    protected function _buildWhere($filter_data = array())
    {
		$filter_data['keywords'] = trim(urldecode(@$filter_data['keywords']));
    	
    	$where = "title!=''";
		
		if(@$filter_data['category'])
		{
			$where .= " AND {$this->posts_categories_table}.category_id=".intval($filter_data['category']);
		}
		if(@$filter_data['position'])
		{
			$where .= " AND position='".$this->db->escape_str($filter_data['position'])."'";
		}
		if(@$filter_data['experience_from'])
		{
			$where .= " AND experience>='".$this->db->escape_str($filter_data['experience_from'])."'";
		}
		if(@$filter_data['experience_to'])
		{
			$where .= " AND experience<='".$this->db->escape_str($filter_data['experience_to'])."'";
		}
		if(@$filter_data['salary_from'])
		{
			$where .= " AND salary>='".$this->db->escape_str($filter_data['salary_from'])."'";
		}
		if(@$filter_data['salary_to'])
		{
			$where .= " AND salary<='".$this->db->escape_str($filter_data['salary_to'])."'";
		}
		if($filter_data['keywords'])
		{
			$where .= " AND CONCAT(title,'|',text,'|',position,'|',experience) LIKE '%".$this->db->escape_str($filter_data['keywords'])."%'";
		}
		
		return $where;
    }
    
}