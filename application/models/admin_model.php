<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for some general functionality in backend.
 * 
 * @package backend  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 * @property Base_model $model
 */
class Admin_model extends Base_model
{
    //what model use for c_table
    protected $model_name;
    protected $model;
    //name of post type
    protected $c_type;
    //name of table where stored categories for each post
    protected $posts_categories_table = 'posts_categories';
	
	/**
	 * Set used table.
	 *
	 * @param string $c_table
	 * @return void
	 */
	public function init($c_table)
	{
	    $this->c_table = $c_table;
        $this->model_name = str_replace('_list', '', $c_table).'_model';

        if(class_exists($this->model_name))
        {
            $this->model = $this->{$this->model_name};

            $this->id_column = $this->model->getIdColumn();
            if(method_exists($this->model,'getCtype'))
            {
                $this->c_type = $this->model->getCtype();
            }
        }
	}
	
	/**
	 * Select data for display in main records list.
	 * 
	 * @param integer $per_page
	 * @param string $where
	 * @param string $join
	 * @param string $orderby
	 * @param string $orderseq
	 * @param integer $offset
	 * @return array
	 */
	public function listData($per_page = 10, $where = '', $join = '', $orderby = '', $orderseq = '', $offset = 0)
	{
		$multilang_select = $this->_buildMultilangSelect();
		$multilang_join = $this->_buildMultilangJoin();
	    
		if(!$where) $where = '1';

		$sql = "SELECT SQL_CALC_FOUND_ROWS {$this->c_table}.* $multilang_select FROM `".$this->c_table."` $multilang_join $join WHERE $where ORDER BY `$orderby` $orderseq LIMIT $offset,$per_page";

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
            $session[$this->c_table.'_search_by'] = $post['search_by'];
            $session[$this->c_table.'_keyword'] = $post['keyword'];
        }
        if( isset($post['category']) && $post['category'] )
        {
            if($category = $this->model->getCategoryFilter())
            {
                $session[$this->c_table.'_category'] = $category;
            }
        }

        //Add search criterias to session
        if( isset($session) ) $this->CI->session->set_userdata($session);

        $where = '1';
        $join = '';

		// Get search criterias from session
        if( $this->CI->session->userdata($this->c_table.'_keyword') )
        {
            $where .= $this->_buildLikeWhere($this->CI->session->userdata($this->c_table.'_search_by'), $this->CI->session->userdata($this->c_table.'_keyword'));
        }
        if( $this->CI->session->userdata($this->c_table.'_category') )
        {
            $where .= $this->_buildCategoryWhere($this->CI->session->userdata($this->c_table.'_category'));
            $join .= $this->_buildCategoryJoin();
        }

		return array('where'=>$where, 'join'=>$join);
    }

    /**
     * Clean search session
     */
    public function resetSearch()
    {
        $this->CI->session->unset_userdata($this->c_table.'_search_by');
        $this->CI->session->unset_userdata($this->c_table.'_keyword');
        $this->CI->session->unset_userdata($this->c_table.'_category');
    }

    /**
     * Build like where for regular search
     * @param string $field
     * @param string $value
     * @return string
     */
    private function _buildLikeWhere($field, $value)
    {
        $field = $this->prepareFieldForSearch($field);
        $value = $this->db->escape_like_str($value);

        return " AND ".$field." LIKE '%".$value."%'";
    }

    /**
     * Build where sql for search by category
     * @param integer $category
     * @return string
     */
    private function _buildCategoryWhere($category)
    {
        if( in_array($this->c_table, array('photos')) )
            return " AND category_id=".intval($category);

        return " AND {$this->posts_categories_table}.category_id=".intval($category);
    }

    /**
     * Build join sql for category search
     * @return string
     */
    private function _buildCategoryJoin()
    {
        if( in_array($this->c_table, array('photos')) )
            return '';

        return " JOIN {$this->posts_categories_table} ON ( {$this->posts_categories_table}.post_id={$this->c_table}.{$this->id_column} AND {$this->posts_categories_table}.type='{$this->c_type}' )";
    }
	
	/**
	 * Add filters.
	 *
     * @param string $filters
	 * @return string
	 */
	public function applyFilters($filters)
	{
		load_model('filters_model');

		// New filters
		if( $filters )
		{
			$filters = $this->CI->filters_model->extract($filters);//to array
		    
			//Add filters to session
			$session[$this->c_table.'_filters'] = $filters;
			$this->CI->session->set_userdata($session);
		}
		else // Get filters from session
		{
            $filters = $this->CI->session->userdata($this->c_table.'_filters');
		}

        if( !$filters ) return '';
		
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
     * Clean filters session
     */
    public function resetFilters()
    {
        $this->CI->session->unset_userdata($this->c_table.'_filters');
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