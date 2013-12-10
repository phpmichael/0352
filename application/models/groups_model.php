<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for groups table.
 * 
 * @package customers  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Groups_model extends Base_model
{
	//name of table
	protected $c_table = 'groups';
	protected $_table_rights = 'groups_rights';
	protected $panels = array('admin','front');
	
	
	/**
	 * Delete record by ID.
	 * Override parent method.
	 * 
	 * @param integer $id
	 * @return void
	 */
	public function DeleteId($id)
	{
		$this->deleteGroupRights($id);
		
		//set customers' group - default if group deleted
		$this->db->update('customers',array('group_id'=>1),array('group_id'=>$id));
		
		parent::DeleteId($id);
	}
	
	/**
	 * Return list of groups.
	 *
	 * @return array
	 */
	public function getGroupsList()
	{
		$records = $this->db->get($this->c_table)->result_array();
		
		return multi2singleArray('id','name',$records);
	}
	
	/**
	 * Check if group has access to admin panel.
	 *
	 * @param integer $group_id
	 * @return bool
	 */
	public function hasAdminAccess($group_id)
	{
		$group = $this->db->get_where($this->c_table,array($this->id_column=>$group_id))->row_array();
		return (bool)$group['admin_access'];
	}
	
	// === Dashboard: Start === //
    /**
     * Generate widget for dashboard.
     *
     * @return string
     */
    public function dashboardWidget()
    {
    	$CI =& get_instance();
        
        $widget = parent::dashboardWidget();
    	
    	$widget['content'] .= "
    	<p>
    		".$CI->filters_model->filterAnchorByCode('admin_groups',language('groups_of_admins'),'groups')." - ".$this->count(array('admin_access'=>1))."
    	</p>
    	<p>
    		".$CI->filters_model->filterAnchorByCode('customers_groups',language('groups_of_customers'),'groups')." - ".$this->count(array('admin_access'=>0))."
    	</p>
    	";
    	
    	return $widget;
    }
    // === Dashboard: End === //
	
	
	// === RIGHTS STUFF === //
	
	/**
	 * Return list of available sections.
	 *
	 * @param string $panel admin or front
	 * @return array
	 */
	public function getAvailableSections($panel)
	{
		if(!in_array($panel,$this->panels)) return array();
	    
		$sections = explode(',',@$this->CI->settings_model['available_'.$panel.'_sections']);
		if(!$sections[0])unset($sections[0]);
	    
	    return $sections;
	}
	
	/**
	 * Check if section is available.
	 *
	 * @param string $section
	 * @param string $panel admin or front
	 * @return bool
	 */
	public function isAvailabeSection($section,$panel)
	{
		return in_array($section,$this->getAvailableSections($panel));
	}

    /**
     * Return list of available rights to set.
     *
     * @param $panel
     * @return array
     */
	public function getRightsList($panel)
	{
		if( $panel=='admin' ) return array('view','edit','add','delete','config','send');
		else return array('view','edit');
	}
	
	/**
	 * Return list of available rights for section.
	 *
	 * @param string $section
	 * @param string $panel admin or front
	 * @return array
	 */
	private function getAvailableSectionRights($section,$panel)
	{
		if($panel=='admin')
		{
    	    $rights = array('view','edit','add','delete');
    		
    		switch ($section)
    		{
    			case "settings":
    				$rights = array('edit');
    			break;
    			
    			case "themes":
    			case "ratings":
    			case "site_phones":
    			case "site_partners":
    				$rights = array('config');
    			break;
    			
    			case "auto_responders":
    				$rights = array('view','edit');
    			break;
    			
    			case "comments":
    				$rights = array('view','edit','delete','config');
    			break;
    			
    			case "orders":
    				$rights = array('view','edit','delete');
    			break;
    			
    			case "newsletters":
    				$rights = array('delete','send','config');
    			break;
    			
    			case "subscribers":
    				$rights[] = 'send';
    			break;
    			
    			case "poll":
    			case "photos":
    			case "articles":
    			case "news":
    			case "products":
    			case "companies":
    				$rights[] = 'config';
    			break;
    			
    			case "tags":
    				$rights = array('view','edit','delete');
    			break;
    			
    			case "tools":
    				$rights = array('view');
    			break;
    		}
		}
		else 
		{
		    //$rights = array('view');
		    $rights = array();
		    
		    switch ($section)
    		{
    			case "comments":
    				$rights = array('edit');
    			break;
    		}
		}
		
		return $rights;
	}
	
	/**
	 * Return list of available rights: section=>rights.
	 *
	 * @return array
	 */
	public function getAvailableRights()
	{
		$rights = array();
		
		foreach ($this->panels as $panel)
		{
		    $sections = $this->getAvailableSections($panel);
		    
            foreach ($sections as $section)
    		{
    			$rights[$panel][$section] = $this->getAvailableSectionRights($section,$panel);
    		}
		}
		
		return $rights;
	}
	
	/**
	 * Set group's rights for each section.
	 *
	 * @param integer $group_id
	 * @param array $rights
	 */
	public function editRights($group_id,$rights)
	{
	    //remove existing group's rights
		$this->deleteGroupRights($group_id);
		
		//set new rights
		foreach ($rights as $panel=>$sections)
		{
    		if(!in_array($panel,array('admin','front'))) continue;
    		
		    foreach ($sections as $section=>$rightsList)
    		{
    			if($this->isAvailabeSection($section,$panel))
    			{
    				foreach ($rightsList as $right)
    				{
    					if(in_array($right,$this->getAvailableSectionRights($section,$panel)))
    					{
    						$this->db->insert($this->_table_rights, array('group_id'=>$group_id,'section'=>$section,'right'=>$right,'panel'=>$panel));
    					}
    				}
    			}
    		}
    	}
	}
	
	/**
	 * Delete group's rights.
	 *
	 * @param integer $group_id
	 */
	private function deleteGroupRights($group_id)
	{
		$this->db->delete($this->_table_rights, array('group_id' => $group_id));
	}
	
	/**
	 * Return list of group's rights.
	 *
	 * @param integer $group_id
	 * @return array
	 */
	public function getGroupRights($group_id)
	{
		$sql = "SELECT * FROM {$this->_table_rights} WHERE group_id=? AND panel=?";
		
		$rights = array();
		
		foreach($this->panels as $panel)
		{
			$records = $this->db->query($sql,array($group_id,$panel))->result_array();
			
			foreach ($records as $record)
			{
				$section = $record['section'];
				$right = $record['right'];
				
				$rights[$panel][$section][] = $right;
			}
		}
		
		return $rights;
	}
	
	/**
	 * Check if group has right for section.
	 *
	 * @param integer $group_id
	 * @param string $section
	 * @param string $right
	 * @return bool
	 */
	/*public function hasRight($group_id,$section,$right,$panel=FALSE)
	{
		//if panel not set - then get current 
		if(!$panel) $panel = $this->CI->_getPanel();
	    
	    //if this section is available in settings
	    if(!$this->isAvailabeSection($section,$panel)) return FALSE;
		
		$sql = "SELECT id FROM {$this->_table_rights} WHERE group_id=? AND section=? AND `right`=? AND panel=?";
		
		return (bool) $this->db->query($sql,array($group_id,$section,$right,$panel))->row_array();
	}*/
	
	/**
	 * Check if logged user has right for section.
	 *
	 * @param string $section
	 * @param string $right
	 * @return bool
	 */
	public function userAccess($section,$right)
	{
		//get logged customer's group_id
	    //$group_id = $this->session->userdata('customer_group_id');
	    //if(!$group_id) return FALSE;
		
	    //return $this->hasRight($group_id,$section,$right);
	    
	    $rights = $this->session->userdata('customer_rights');
		
		return $this->allowedRight($section,$right,$rights);
	}
	
	/**
	 * Check if rights in allowed rights list.
	 *
	 * @param string $section
	 * @param string $right
	 * @param array $rights got by $this->getGroupRights
	 * @param bool|string $panel admin or front
	 * @return bool
	 */
	public function allowedRight($section,$right,$rights,$panel=FALSE)
	{
		//if panel not set - then get current 
		if(!$panel) $panel = $this->CI->_getPanel();
		
		//if this section is available in settings
	    if(!$this->isAvailabeSection($section,$panel)) return FALSE;
		
		return in_array($right,(array)@$rights[$panel][$section]);
	}
	
}