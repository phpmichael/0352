<?php
require_once(APPPATH.'models/posts_model.php');

/** 
 * This is models for documents table.
 * 
 * @package documents
 * @author Michael Kovalskiy
 * @version 2014
 * @access public
 */
class Documents_model extends Posts_model
{
	//name of table
	protected $c_table = 'documents';
    //name of primary field
    protected $id_column = 'data_key';
    //name of ...
    protected $c_type = "document";
    //name of tags table
	protected $tags_table = "tags";
	//name of categories table
	protected $categories_list_table = 'documents_categories_list';
    
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
			$where .= " AND {$this->c_table}.category_id=".intval($filter_data['category']);
		}
		
		return $where;
    }

    /**
     * Make sql join criterias based on $filter_data.
     *
     * @param $filter_data
     * @return string
     */
    protected function _buildJoin(array $filter_data=array())
    {
        return "";
    }
}