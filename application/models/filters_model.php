<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for filters.
 * 
 * @package filters  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Filters_model extends Base_model
{
	//name of table
	protected $c_table = 'filters';
	
	/**
	 * Return list of filters groups.
	 *
	 * @param bool $just_active
	 * @param bool|string $section
	 * @return array
	 */
	private function getGroups($just_active=FALSE,$section=FALSE)
	{
		$this->c_table = 'filters_groups';
		
		//multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect());
		$this->_buildMultilangJoin(FALSE);
		
		$criterias = array();
		if($just_active) $criterias['active'] = 1;
		if($section) $criterias['section'] = $section;
		
		$this->db->order_by("sort");
		
		return $this->db->get_where($this->c_table,$criterias)->result_array();
	}
	
	/**
	 * Return list of filters groups in format id=>title.
	 *
	 * @param bool $just_active
	 * @param bool|string $section
	 * @return array
	 */
	public function getGroupsList($just_active=FALSE,$section=FALSE)
	{
		return multi2singleArray('id','title',$this->getGroups($just_active,$section));
	}
	
	/**
	 * Returns group record by ID.
	 * 
	 * @param integer $id
	 * @return array
	 */
	public function getGroupById($id)
	{
		$this->c_table = 'filters_groups';
		
		return $this->getOneById($id);
	}
	
	/**
	 * Returns filters for group.
	 * 
	 * @param bool $just_active
	 * @param bool $just_current_panel
	 * @param integer $filter_group_id
	 * @return array
	 */
	public function getFiltersForGroup($filter_group_id,$just_active=FALSE,$just_current_panel=FALSE)
	{
		$this->c_table = 'filters';
		
		//multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect());
		$this->_buildMultilangJoin(FALSE);
		
		$criterias = array('filter_group_id'=>$filter_group_id);
		if($just_active) $criterias['active'] = 1;
		if($just_current_panel) $this->db->where_in('panel',array($this->CI->_getPanel(),'both'));
		
		$this->db->order_by("sort");
		
		$records = $this->db->get_where($this->c_table,$criterias)->result_array();
		
		return $records;
	}
    
	/**
	 * Insert or update group. Depends if ID field is set.
	 * 
	 * @param array $post
	 * @return void
	 */
	public function insertOrUpdateGroup($post)
	{
		$this->c_table = 'filters_groups';
		
		//if new insert
		if( !@$post[$this->id_column] ) $post['sort'] = $this->lastSortGroup();
		
		parent::insertOrUpdate($post);
	}
	
	/**
	 * Insert or update filter. Depends if ID field is set.
	 * 
	 * @param array $post
	 * @return void
	 */
	public function insertOrUpdateFilter($post)
	{
		$this->c_table = 'filters';
		
		//if new insert
		if( !@$post[$this->id_column] ) $post['sort'] = $this->lastSortFilter($post['filter_group_id']);
		
		parent::insertOrUpdate($post);
	}
	
	/**
	 * Delete groups by IDs.
	 * 
	 * @param array $delArr
	 * @return void
	 */
	public function DeleteSelectedGroups($delArr)
	{
		if( !empty($delArr) )
		{
			foreach ($delArr as $id=>$selected)
			{
				//delete filters (with multilang data)
				$filters = $this->getFiltersForGroup($id);
				$this->c_table = 'filters';
				foreach ($filters as $filter)
				{
					$this->DeleteId($filter['id']);
				}
				
				//delete group (with multilang data)
				$this->c_table = 'filters_groups';
				$this->DeleteId($id);
			}
			
			$this->resetSortGroups();
		}
	}
	
	/**
	 * Delete filters by IDs.
	 * 
	 * @param array $delArr
	 * @param integer $filter_group_id
	 * @return void
	 */
	public function DeleteSelectedFilters($delArr,$filter_group_id)
	{
		if( !empty($delArr) )
		{
			$this->c_table = 'filters';
		    
		    foreach ($delArr as $id=>$selected)
			{
				$this->DeleteId($id);
			}
			
			$this->resetSortFilters($filter_group_id);
		}
	}
	
	/**
	 * Extract filters string (from URL).
	 *
	 * @param string $filters
	 * @return array
	 */
	public function extract($filters)
	{
	    $filters = strtr(urldecode($filters),array('&#40;'=>'','&#41;'=>''));//&#40; equal "(", &#41; equal ")"
		
		return explode('-',$filters);
	}
	
	/**
	 * Implode filters array in string (for using in URL).
	 *
	 * @param array $filters
	 * @return string
	 */
	private function implode($filters)
	{
	    if(empty($filters)) return '(reset)';// (reset) removes filters from session
	    return '('.implode('-',$filters).')';
	}
	
	
	/**
	 * Return group=>filters tree for defined section.
	 *
	 * @param string $section
	 * @return array
	 */
	public function getFiltersForSection($section)
	{
	    $groups = $this->getGroups(TRUE,$section);
	    
	    foreach ($groups as &$group)
	    {
	        $filters = $this->getFiltersForGroup($group['id'],TRUE,TRUE);
	        if(!empty($filters)) $group['filters'] = $filters;
	        else unset($group);
	    }
	    
	    return $groups;
	}
	
	/**
	 * Return  array of currently used filters.
	 *
	 * @return array
	 */
	private function getUsedFilters()
	{
	    if($this->CI->_getPanel()=='admin') $filters = $this->CI->session->userdata($this->CI->_getCurrentTable().'_filters');
	    
	    if(!$filters) $filters = array();
	    
	    return $filters;
	}
	
	/**
	 * Build filter link: add/remove $filter_id for/from currently used filters.
	 *
	 * @param integer $filter_id
	 * @param string $filter_title
	 * @return string
	 */
	public function filterAnchor($filter_id,$filter_title)
	{
	    $filters = $this->getUsedFilters();
	    
	    if(!in_array($filter_id,$filters))// if not used
	    {
	        $filters[] = $filter_id;
	        return ' + '.anchor($this->filterLink($filters),$filter_title);
	    }
	    else //if used
	    {
	        $filters = array_diff($filters,array($filter_id));
	        return anchor($this->filterLink($filters),'x').' '.$filter_title;
	    }
	}
	
	/**
	 * Build filter link by filter code.
	 *
	 * @param string $filter_code
	 * @param string $filter_title
	 * @param string $controller
	 * @param string $action
	 * @param string $orderby
	 * @param string $orderseq
	 * @param integer $offset
	 * @return string
	 */
	public function filterAnchorByCode($filter_code,$filter_title,$controller,$action='index',$orderby='id',$orderseq='asc',$offset=0)
	{
	    if(!$this->available()) return $filter_title;
	    
	    $CI =& get_instance();
	    
	    $this->db->select('id');
	    $record = $this->db->get_where('filters', array('code' => $filter_code))->row_array();
	    
	    if(!$record) return $filter_title;
	    
	    $filters = array($record['id']);
	    
	    return anchor(alink($CI->_getBaseURL().$controller,$action,$orderby,$orderseq,$offset).'/0/'.$this->implode($filters),$filter_title);
	}
	
	/**
	 * Add filters to link.
	 *
	 * @param array $filters
	 * @return string
	 */
	private function filterLink($filters)
	{
	    return alink(FALSE,FALSE,FALSE,FALSE,0).'/0/'.$this->implode($filters);
	}
	
	/**
	 * Return link for clear used filters.
	 *
	 * @return string
	 */
	public function resetFilterAnchor()
	{
	    if(!$this->getUsedFilters()) return '';
	    return anchor($this->filterLink(array()),language('remove_all_filters'));
	}
	
	/**
	 * Return array of groups with "OR" connector.
	 *
	 * @return array
	 */
	public function getGroupsWithOrConnector()
	{
	    if(!$this->available()) return array();
	    
	    $this->db->select("id");
	    $records = $this->db->get_where('filters_groups',array('active'=>1,'connector'=>'OR'))->result_array();
	    
	    $results = array();
	    
	    foreach ($records as $record)
	    {
	        $results[] = $record['id'];
	    }
	    
	    return $results;
	}
	
	/**
	 * Sort filters groups.
	 * 
	 * @param array $sortables
	 * @return void
	 */
	public function SortGroups($sortables)
	{
		$this->c_table = 'filters_groups';
		
		parent::Sort($sortables);
	}
	
	/**
	 * Sort filters.
	 * 
	 * @param array $sortables
	 * @return void
	 */
	public function SortFilters($sortables,$filter_group_id)
	{
		$this->c_table = 'filters';
		
		parent::Sort($sortables,array('filter_group_id'=>$filter_group_id));
	}
	
	/**
	 * Reset Groups Sorting (after record deleted).
	 * 
	 * @return void
	 */
	protected function resetSortGroups()
	{
	    $this->c_table = 'filters_groups';
	    
	    parent::reset_sort();
	}
	
	/**
	 * Reset Filters Sorting (after record deleted).
	 * 
	 * @param integer $filter_group_id
	 * @return void
	 */
	protected function resetSortFilters($filter_group_id)
	{
	    $this->c_table = 'filters';
	    
	    parent::reset_sort(array('filter_group_id'=>$filter_group_id));
	}
	
	/**
	 * Generate value for sort column.
	 * 
	 * @return integer
	 */
	protected function lastSortGroup()
	{
	    $this->c_table = 'filters_groups';
	    
	    return parent::last_sort_val();
	}
	
	/**
	 * Generate value for sort column.
	 * 
	 * @param integer $filter_group_id
	 * @return integer
	 */
	protected function lastSortFilter($filter_group_id)
	{
	    $this->c_table = 'filters';
	    
	    return parent::last_sort_val(array('filter_group_id'=>$filter_group_id));
	}
	
	/**
	 * Check if using filters available.
	 *
	 * @return bool
	 */
	public function available()
	{
	    if( $this->db->table_exists('filters_groups') && $this->db->table_exists('filters') ) return TRUE;
	    return FALSE;
	}
	
}