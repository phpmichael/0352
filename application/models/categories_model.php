<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for categories table.
 * 
 * @package messageboard  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Categories_model extends Base_model
{
	//name of table
	protected $c_table = 'categories_list';
	
	// === General === //
	
	/**
	 * Returns category title by ID.
	 * 
	 * @param integer $category_id
	 * @return string
	 */
	public function getTitle($category_id)
	{
		$data = $this->getOneById($category_id);
		
		if(!$data) return FALSE;
		
		//if multilang array
		if(is_array($data['category'])) 
		{
		    $lang_code = strtoupper($this->CI->_getInterfaceLang(TRUE));
		    return $data['category'][$lang_code];
		}
		
		return $data['category'];
	}
	
	/**
	 * Return category ID by its title.
	 *
	 * @param string $title
	 * @return integer|bool
	 */
	public function getIdByTitle($title)
	{
		$lang_code = strtoupper($this->CI->_getInterfaceLang(TRUE));
		
		$records = $this->get("lang_gen_category.{$lang_code}='".$this->db->escape_str($title)."'");
		
		if(!$records) return FALSE;
		else return $records[0][$this->id_column];
	}
	
	/**
	 * Return info of category with prefix 'search_category_'.
	 *
	 * @param integer $category_id
	 * @return array
	 */
	public function getSearchCategoryData($category_id)
	{
		$data = array();
		
		$record = $this->getOneById($category_id);
		
		if($record)
		{
			$data['search_category_id'] = $record['id'];
			$data['search_category_title'] = $record['category'];
			if(isset($record['description'])) $data['search_category_description'] = $record['description'];
		}
		
		return $data;
	}
	
	/**
	 * Returns category's children records by ID.
	 * 
	 * @param integer|bool $parent_id
	 * @param bool $full
	 * @return array
	 */
	public function getChildren($parent_id=0,$full=FALSE)
	{
		//multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect());
		$this->_buildMultilangJoin(FALSE);
	    
	    if($parent_id===FALSE) //show all categories
	    {
	    	$this->db->order_by('parent_id, sort','asc');
	    	$data = $this->db->get($this->c_table)->result_array();
	    }
	    else 
	    {
	    	$this->db->order_by('sort','asc');
	    	$data = $this->db->get_where($this->c_table,array("parent_id"=>$parent_id))->result_array();
	    }
	    
	    if($full) return $data;
		
		return multi2singleArray($this->id_column,'category',$data);
	}
	
	/**
	 * Returns all categories list.
	 * 
	 * param bool $full
	 * @return array
	 */
	public function getAllCategoriesList($full=FALSE)
	{
		$categories = $this->getChildren(FALSE,$full);
		$categories[0] = "";
		ksort($categories);
		return $categories;
	}
	
	/**
     * Return categories tree.
     *
     * @param integer $parent_id
     * @return array
     */
    public function getTree($parent_id=0)
    {
    	$categories = $this->getChildren($parent_id);
    	$categories_tree = array();
    	
    	foreach ($categories as $category_id=>$category)
    	{
    		$categories_tree[$category_id]['id'] = $category_id;
    		$categories_tree[$category_id]['category'] = $category;
    		$categories_tree[$category_id]['children'] = $this->getTree($category_id);
    	}
    	
    	return $categories_tree;
    }
	
	/**
	 * Returns parent records by ID.
	 * 
	 * @param integer $category_id
	 * @return array
	 */
	public function getParents($category_id)
	{
	    if(!$category_id) return array();
		
		$list = array();
		
		$list[] = $cat = $this->getOneById($category_id);
		
		while(isset($cat['parent_id']) && $cat['parent_id'])
		{
			$list[] = $cat = $this->getOneById($cat['parent_id']);
		}
		
		return array_reverse($list);
	}
	
	/**
	 * Used to build breadcrumb (where user located on website).
	 * 
	 * @param integer $category_id
	 * @param string $controller
	 * @return array
	 */
	public function getLocation($category_id,$controller)
	{
		$CI =& get_instance();
	    
	    $categories_location_arr = array();
		
		$categories_arr = $this->GetParents($category_id);
		
		foreach ($categories_arr as $key=>$val)
		{
			if(!empty($val)) $categories_location_arr[$CI->_getBaseURL().$controller."/index/category/".$val['id']] = lowercase($val['category']);
		}
		
		return $categories_location_arr;
	}
	
	// === Admin === //
	
	/**
	 * Reset Sorting (after category deleted).
	 * 
	 * @param integer $parent_id
	 * @return void
	 */
	protected function reset_sort($parent_id)
	{
		parent::reset_sort(array('parent_id' => $parent_id));
	}
	
	/**
	 * Generate value for sort column.
	 * 
	 * @param integer $parent_id
	 * @return void
	 */
	protected function last_sort_val($parent_id)
	{		
		return parent::last_sort_val(array('parent_id' => $parent_id));
	}
	
	/**
	 * Insert data. Returns ID field.
	 * Overloads parent method.
	 * 
	 * @param array $post
	 * @return integer
	 */
	public function Insert($post)
	{
		$post['sort'] = $this->last_sort_val($post['parent_id']);
		
		return parent::Insert($post);
	}
	
	/**
	 * Delete few records by IDs array and reset sorting.
	 * Overloads parent method.
	 * 
	 * @param array $delArr
	 * @param integer $parent_id
	 * @return void
	 */
	public function DeleteSelected($delArr,$parent_id)
	{
		if( !empty($delArr) )
		{
			foreach ($delArr as $id=>$selected)
			{
				$this->recursiveDelete($id);
			}
		}
		
		$this->reset_sort($parent_id);
	}
	
	/**
	 * Delete record with children records.
	 * 
	 * @param integer $id
	 * @return void
	 */
	private function recursiveDelete($id)
	{
		$children = $this->db->get_where($this->c_table, array('parent_id'=>$id))->result_array();
		
		if(!empty($children))
		{
			foreach ($children as $record)
			{
				$this->recursiveDelete($record['id']);
			}
		}
			
		$this->DeleteId($id);
	}
	
	/**
	 * Sort records.
	 * 
	 * @param array $sortables
	 * @param integer $parent_id
	 * @return void
	 */
	public function Sort($sortables,$parent_id)
	{	
		parent::Sort($sortables,array('parent_id'=>$parent_id));
	}
	
}