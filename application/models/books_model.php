<?php
require_once(APPPATH.'models/products_model.php');

/** 
 * This is model for books table.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Books_model extends Products_model
{
	//name of table
	protected $c_table = 'books';
	//name of primary field
	protected $id_column = 'data_key';
	
	//pagination
	protected $per_page = 9;
	
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
	 * Make sql creterias based on $filter_data.
	 * 
	 * @param $filter_data
	 * @return string
	 */
    protected function _buildWhere(array $filter_data = array())
    {
        $where = parent::_buildWhere($filter_data);
		
		//Name
		if( isset($filter_data['name']) && $filter_data['name'] )
		{
			$where .= " AND {$this->c_table}.name LIKE '%".$this->db->escape_str($filter_data['name'])."%'";
		}
		
		//Author
		if( isset($filter_data['author']) && $filter_data['author'] )
		{
			$where .= " AND {$this->c_table}.author LIKE '%".$this->db->escape_str($filter_data['author'])."%'";
		}
        
        //Price
		if( isset($filter_data['price_1']) && $filter_data['price_1'] )
		{
			$where .= " AND {$this->c_table}.price >= ".(float)($filter_data['price_1']);
		}
		if( isset($filter_data['price_2']) && $filter_data['price_2'] )
		{
			$where .= " AND {$this->c_table}.price <= ".(float)($filter_data['price_2']);
		}
		
		//Year
		if( isset($filter_data['year_1']) && $filter_data['year_1'] )
		{
			$where .= " AND {$this->c_table}.year >= ".(float)($filter_data['year_1']);
		}
		if( isset($filter_data['year_2']) && $filter_data['year_2'] )
		{
			$where .= " AND {$this->c_table}.year <= ".(float)($filter_data['year_2']);
		}
		
		//Language
		if( isset($filter_data['language']) && !empty($filter_data['language']) )
		{
			$where .= $this->_buildOrWhereForArray('language',$filter_data['language']);
		}
		
		//Manufacturer ID
		if( isset($filter_data['manufacturer_id']) && ($manufacturer_id = intval($filter_data['manufacturer_id'])) )
		{
		    $where .= " AND {$this->c_table}.manufacturer_id='".$manufacturer_id."'";
		}
        
		return $where;
    }
    
    /**
	 * Make array of search/sort creterias.
	 * 
	 * @return array
	 */
    public function getFilterData()
    {
		$filter_data = $this->CI->input->post(NULL,TRUE);
		
		//category filter
		$filter_data['category'] = $this->getCategoryFilter();
		
    	if( isset($filter_data['keywords']) ) $filter_data['keywords'] = urlencode($filter_data['keywords']);
		
    	if(!@$filter_data['per_page']) $filter_data['per_page'] = $this->per_page;
		//set default values for filters - requires for pagination
		if( !@$filter_data['sort_by'] ) $filter_data['sort_by'] = 'pub_date';
		if( !@$filter_data['sort_order'] ) $filter_data['sort_order'] = 'desc';
		
		if(!in_array(@$filter_data['display_style'],array('list','grid'))) $filter_data['display_style'] = 'list';
			
		//Request from Pagination
		$filter_data = $this->paginationFilter($filter_data);
		
		return $filter_data;
    }
}