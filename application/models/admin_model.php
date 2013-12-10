<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for some general functionality in backend.
 * 
 * @package backend  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Admin_model extends Base_model
{
	//name of table
	protected $c_table;
	
	/**
	 * Set used table.
	 *
	 * @param string $c_table
	 * @return void
	 */
	public function init($c_table)
	{
	    $this->c_table = $c_table;
	}
	
	/**
	 * Select data for display in main records list.
	 * 
	 * @param integer $per_page
	 * @param string $where
	 * @param string $orderby
	 * @param string $orderseq
	 * @param integer $offset
	 * @return array
	 */
	public function get($per_page = 10, $where = '',$orderby = '', $orderseq = '', $offset = 0)
	{
		$multilang_select = $this->_buildMultilangSelect();
		$multilang_join = $this->_buildMultilangJoin();
	    
		if(!$where) $where = '1';

		$sql = "SELECT SQL_CALC_FOUND_ROWS {$this->c_table}.* $multilang_select FROM `".$this->c_table."` $multilang_join WHERE $where ORDER BY `$orderby` $orderseq LIMIT $offset,$per_page";
		
		$data['query'] = $this->db->query($sql);
		$data['total_rows']  = current($this->db->query("SELECT FOUND_ROWS() AS numrows")->row_array());
		
		return $data;
	}
	
	/**
	 * Build search criteria for _ListData method.
	 * 
	 * @param array $post
	 * @return string
	 */
	public function searchData($post)
	{
		// New Search
		if( isset($post['keyword']) && $post['keyword'] ) 
		{
			$field = $this->prepareFieldForSearch($post['search_by']);
			$value = $this->db->escape_like_str($post['keyword']);
		    
		    $where = $field." LIKE '%".$value."%'";

			//Add Search to Session
			$sessdata[$this->c_table.'_search_by'] = $post['search_by'];
			$sessdata[$this->c_table.'_keyword'] = $post['keyword'];
			$this->CI->session->set_userdata($sessdata);
		}
		// Reset Search
		elseif($this->CI->uri->segment($this->CI->_getSegmentsOffset()+3) == 'reset')
		{
			$this->CI->session->unset_userdata($this->c_table.'_search_by');
			$this->CI->session->unset_userdata($this->c_table.'_keyword');
			redirect($this->CI->_getBaseURI());
		}
		// Get Search From Session
		elseif( $this->CI->session->userdata($this->c_table.'_keyword') )
		{
			$field = $this->prepareFieldForSearch($this->CI->session->userdata($this->c_table.'_search_by'));
			$value = $this->db->escape_like_str($this->CI->session->userdata($this->c_table.'_keyword'));
		    
		    $where = $field." LIKE '%".$value."%'";
		}
		// No Any Search
		else 
		{
		    $where = '';
		}

		return $where;
	}
	
	/**
	 * Add filters.
	 *
	 * @return string
	 */
	public function applyFilters()
	{
		load_model('filters_model');
		
		$filters = $this->CI->_getSegmentFilters();
		
		// New Filters
		if( $filters && !stristr($filters,'reset') ) 
		{
			$filters = $this->CI->filters_model->extract($filters);
		    
			//Add Filters to Session
			$sessdata[$this->c_table.'_filters'] = $filters;
			$this->CI->session->set_userdata($sessdata);
		}
		// Reset Filters
		elseif( $filters && stristr($filters,'reset') )
		{
			$filters = array();
		    
		    $this->CI->session->unset_userdata($this->c_table.'_filters');
			redirect(aurl());
		}
		// Get Filters From Session
		elseif( $filters = $this->CI->session->userdata($this->c_table.'_filters') )
		{
			
		}
		else 
		{
		    $filters = array();
		}
		
		$where = '';
		
		$groups_with_OR_connector = $this->CI->filters_model->getGroupsWithOrConnector();
		
		$group_filters = array();
		
		foreach ($filters as $filter_id)
		{
			$filter = $this->CI->filters_model->getOneById($filter_id);
			
			if($filter['active'])
			{
    			if( in_array($filter['filter_group_id'],$groups_with_OR_connector) )
    			{
    			    $group_filters[$filter['filter_group_id']][] = $filter['query'];
    			}
    			else 
    			{
    			    $where .= ' AND '.$filter['query'];   
    			}
			}
		}
		
		foreach ($group_filters as $queries)
		{
		    $where .= ' AND ('.implode(' OR ',$queries).')';
		}

		return $where;
	}
	
	/**
	 * Return list of available themes.
	 *
	 * @param bool $admin
	 * @return array
	 */
	public function getThemesList($admin=FALSE)
	{
		$themes_list = array();
		
		$themes_dir = APPPATH.'views/themes/';
		if($admin) $themes_dir .= 'admin/';
    	
    	//open dir
    	$dirHandle = opendir($themes_dir);
    	
        while($item = readdir($dirHandle)) 
        {
        	if( $item!="." && $item!=".." ) 
            { 
            	if(is_dir($themes_dir.$item) && $item!='admin' )
            	{
            		$themes_list[$item] = $item;
            	}
            }
        }
        closedir($dirHandle);
        
        return $themes_list;
	}
	
}