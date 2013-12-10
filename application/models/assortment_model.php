<?php
require_once(APPPATH.'models/posts_model.php');

/** 
 * This is model for assortment table.
 * 
 * @package assortment  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Assortment_model extends Posts_model
{
	//name of table
	protected $c_table = 'assortment';
	//name of primary field
	protected $id_column = 'data_key';
	//name of ...
	protected $c_type = "assortment";
    //name of tags table
	protected $tags_table = "tags";
	
	protected $per_page = 12;
	
	//name of categories table
	protected $categories_list_table = 'products_categories_list';
	
	/**
	 * Insert data.
	 * Overrides parent method.
	 * 
	 * @param array $post
	 * @return string(16)
	 */
    public function Insert($post)
    {
    	if(isset($post['category'])) return parent::Insert($post,explode("|",$post['category']));
    	else return parent::Insert($post);
    	
    }
    
    /**
	 * Update data.
	 * Overrides parent method.
	 * 
	 * @param array $post
	 * @return string(16)
	 */
    public function Update($post)
    {
    	if(isset($post['category'])) return parent::Update($post,explode("|",$post['category']));
    	else return parent::Update($post);
    }
	
	
	/**
	 * Make array of search/sort creterias.
	 * 
	 * @return array
	 */
    public function getFilterData()
    {
		//category filter
		$filter_data['category'] = $this->getCategoryFilter();
        
        //standard filters
		$filter_data['keywords'] = $this->CI->input->post('keywords',1);
		$filter_data['keywords'] = urlencode($filter_data['keywords']);
		$filter_data['sort_by'] = $this->CI->input->post('sort_by',1);
		$filter_data['sort_order'] = $this->CI->input->post('sort_order',1);
		
		//set default values for filters - requires for pagination
		if(!$filter_data['sort_by']) $filter_data['sort_by'] = 'pub_date';
		if(!$filter_data['sort_order']) $filter_data['sort_order'] = 'desc';
			
		//Request from Pagination
		$filter_data = $this->paginationFilter($filter_data);
		
		return $filter_data;
    }
    
    /**
	 * Make sql criterias based on $filter_data.
	 * 
	 * @param $filter_data
	 * @return string
	 */
    protected function _buildWhere(array $filter_data = array())
    {
        $where = "1";
    	
        if( isset($filter_data['category']) && $filter_data['category'] )
		{
			$where .= " AND {$this->posts_categories_table}.category_id=".intval($filter_data['category']);
		}
		if( isset($filter_data['keywords']) && ($keywords = $this->CI->security->xss_clean(trim(urldecode($filter_data['keywords'])))) )
		{
			$where .= " AND CONCAT(".$this->prepareFieldForSearch('name').",".$this->prepareFieldForSearch('country').",".$this->prepareFieldForSearch('type1').",".$this->prepareFieldForSearch('type2').",".$this->prepareFieldForSearch('type3').",".$this->prepareFieldForSearch('description').",".$this->prepareFieldForSearch('characteristics').",".$this->prepareFieldForSearch('assortment').",".$this->prepareFieldForSearch('accessories').") LIKE '%".$this->db->escape_str($keywords)."%'";
		}
        	
		return $where;
    }
	
}