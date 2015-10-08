<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * Formbuilder.
 * 
 * @package formbuilder  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Formbuilder_model extends Base_model
{
	//name of main table for store forms info
	protected $c_table = 'forms';
	
	//form display mode, available ("view" and "edit")
	private $form_mode = "edit";
	
	//id [of used form]
	private $form_id;
	
	//table for store posted data [of used form]
	private $form_store_table;
	
	//path for store images [of used form]
	private $form_files_store_path;
	
	//inputs' values [of used form]
	private $form_data = array();
	
	//stored data id [of used form]
	private $data_key = FALSE;
	
	//javascript includes
	private $includes = array();

    //store if javascript already included (for loader in head)
    private $js_included = FALSE;
	
	//number of input row (need for set background color)
	private $list_row_number = 0;
	
	private $multilang_tree = FALSE;
	
	/**
	 * Return form_id by html_id.
	 * @param string $html_id
	 * @return integer
	 */
	public function getFormIdByHtmlId($html_id)
	{
		$record = $this->db->get_where('forms', array( "html_id" => $html_id ))->row_array();
		if(empty($record)) return FALSE;
		return $record['id'];
	}
	
	/**
	 * Return table where form's data stored.
	 *
	 * @param integer $form_id
	 * @return string
	 */
	public function getFormStoreTable($form_id)
	{
	    $record = $this->db->get_where('forms', array( "id" => $form_id ))->row_array();
		if(empty($record)) return FALSE;
		return ($record['store_in_table'])?$record['store_in_table']:'form_store';
	}
	
	/**
	 * Returns form record by ID.
	 * 
	 * @param integer $id
	 * @return array
	 */
	public function getFormById($id)
	{
		$this->c_table = 'forms';
		
		return $this->getOneById($id);
	}
	
	/**
	 * Returns container record by ID.
	 * 
	 * @param integer $id
	 * @return array
	 */
	public function getContainerById($id)
	{
		$this->c_table = 'form_containers';
		
		return $this->getOneById($id);
	}
	
	/**
	 * Returns input record by ID.
	 * 
	 * @param integer $id
	 * @return array
	 */
	public function getInputById($id)
	{
		$this->c_table = 'form_inputs';
		
		return $this->getOneById($id);
	}
	
	/**
	 * Insert or update form. Depends if ID field is set.
	 * 
	 * @param array $post
	 * @return integer
	 */
	public function insertOrUpdateForm($post)
	{
		$this->c_table = 'forms';
		
		return parent::insertOrUpdate($post);
	}
	
	/**
	 * Insert or update container. Depends if ID field is set.
	 * 
	 * @param array $post
	 * @return integer
	 */
	public function insertOrUpdateContainer($post)
	{
		$this->c_table = 'form_containers';
		
		//if new insert
		if( !@$post[$this->id_column] ) $post['sort'] = $this->lastSortContainer($post['form_id'],$post['container_id']);
		
		return parent::insertOrUpdate($post);
	}
	
	// === Sort Stuff: Start === //
	
	/**
	 * Insert or update input. Depends if ID field is set.
	 * 
	 * @param array $post
	 * @return integer
	 */
	public function insertOrUpdateInput($post)
	{
		$this->c_table = 'form_inputs';
		
		//if new insert
		if( !@$post[$this->id_column] ) $post['sort'] = $this->lastSortInput($post['form_id'],$post['container_id']);
		
		return parent::insertOrUpdate($post);
	}
	
	/**
	 * Generate value for sort column.
	 * 
	 * @param integer $form_id
	 * @param integer $container_id
	 * @return integer
	 */
	protected function lastSortContainer($form_id,$container_id)
	{
	    $this->c_table = 'form_containers';
	    
	    if($container_id) return parent::last_sort_val(array('container_id'=>$container_id));
	    else return parent::last_sort_val(array('form_id'=>$form_id, 'container_id'=>0));
	}
	
	/**
	 * Generate value for sort column.
	 * 
	 * @param integer $form_id
	 * @param integer $container_id
	 * @return integer
	 */
	protected function lastSortInput($form_id,$container_id)
	{
	    $this->c_table = 'form_inputs';
	    
	    if($container_id) return parent::last_sort_val(array('container_id'=>$container_id));
	    else return parent::last_sort_val(array('form_id'=>$form_id, 'container_id'=>0));
	}
	
	
	/**
	 * Move item in tree (change sort for containers and inputs).
	 *
	 * @param string $item_type container|input
	 * @param integer $item_id 
	 * @param integer $form_id move to from with this id
	 * @param string $ref_type container|input|form 
	 * @param integer $ref_id
	 * @param string $move_type last|before|after
	 * @return bool
	 */
	public function moveFormItem($item_type,$item_id,$form_id,$ref_type,$ref_id,$move_type)
	{
		if( !in_array($item_type,array('container','input')) ) return FALSE;
		if( !in_array($ref_type,array('container','input','form')) ) return FALSE;
		
		if( $item_type=='container' ) 
		{
			$table = 'form_containers';
			$item = $this->getContainerById($item_id);
		}
		else 
		{
			$table = 'form_inputs';
			$item = $this->getInputById($item_id);
		}
		
		
		if($move_type=='last')//inside
		{
			$method = "lastSort".strtoupper($item_type);
			
			$container_id = ($form_id==$ref_id)?0:$ref_id;
			
			$sort = $this->$method($form_id,$container_id);
			
			$this->db->update( $table, array('form_id'=>$form_id, 'container_id'=>$container_id, 'sort'=>$sort ), array('id'=>$item_id) );
		}
		elseif($move_type=='before')
		{
			$subling = $this->db->get_where($table,array('id'=>$ref_id,))->row_array();
			//increment sort
			$this->incSort($table,$subling['form_id'],$subling['container_id'],$subling['sort']);
			
			//update item parent and sort
			$this->db->update( $table, array('form_id'=>$subling['form_id'], 'container_id'=>$subling['container_id'], 'sort'=>$subling['sort'] ), array('id'=>$item_id) );
		}
		elseif($move_type=='after')
		{
			$subling = $this->db->get_where($table,array('id'=>$ref_id,))->row_array();
			//increment sort
			$this->incSort($table,$subling['form_id'],$subling['container_id'],$subling['sort']+1);
			
			//update item parent and sort
			$this->db->update( $table, array('form_id'=>$subling['form_id'], 'container_id'=>$subling['container_id'], 'sort'=>$subling['sort']+1 ), array('id'=>$item_id) );
		}
		
		//reset sorting
		$method = "resetSort".strtoupper($item_type);
		
		$this->$method($item['form_id'],$item['container_id']);
		
		//update `form_id` for container's children
		if( $item_type=='container' && $item['form_id'] != $form_id )
		{
		    //$this->db->update( 'form_containers', array('form_id'=>$form_id), array('container_id'=>$item_id) );
		    $this->updateFormIdForChildren($form_id,$item_id);
		}
		
		return TRUE;
	}
	
	/**
	 * Move answer in answersets tree.
	 *
	 * @param integer $answer_id 
	 * @param integer $answerset_id move to answerset with this id
	 * @param string $ref_type answersets_value|answerset 
	 * @param integer $subling_id
	 * @param string $move_type last|before|after
	 * @return bool
	 */
	public function moveAnswersetValue($answer_id,$answerset_id,$ref_type,$subling_id,$move_type)
	{
		if( !in_array($ref_type,array('answersets_value','answerset')) ) return FALSE;
		
		$table = 'form_answersets_values';
		$answer = $this->getAnswersetValueById($answer_id);
		
		
		if($move_type=='last')//inside
		{
			$sort = $this->lastSortAnswersetValue($answerset_id);
			
			$this->db->update( $table, array('answerset_id'=>$answerset_id, 'sort'=>$sort ), array('id'=>$answer_id) );
		}
		elseif($move_type=='before')
		{
			$subling = $this->db->get_where($table,array('id'=>$subling_id,))->row_array();
			//increment sort
			$this->incAnswersetValueSort($answerset_id,$subling['sort']);
			
			//update item parent and sort
			$this->db->update( $table, array('answerset_id'=>$answerset_id, 'sort'=>$subling['sort'] ), array('id'=>$answer_id) );
		}
		elseif($move_type=='after')
		{
			$subling = $this->db->get_where($table,array('id'=>$subling_id,))->row_array();
			//increment sort
			$this->incAnswersetValueSort($answerset_id,$subling['sort']+1);
			
			//update item parent and sort
			$this->db->update( $table, array('answerset_id'=>$answerset_id, 'sort'=>$subling['sort']+1 ), array('id'=>$answer_id) );
		}
		
		//reset sorting
		$this->resetSortAnswersetValue($answer['answerset_id']);
		
		return TRUE;
	}
	
	/**
	 * Change `form_id` values for children if container moved inside different form.
	 *
	 * @param integer $form_id
	 * @param integer $container_id
	 */
	private function updateFormIdForChildren($form_id,$container_id)
	{
	    $tree = $this->getTree($form_id,$container_id);
	    
	    foreach ($tree as $item)
	    {
	        $this->db->update('form_'.$item['main_type'].'s',array('form_id'=>$form_id),array('id'=>$item['id']));
	        
	        if( isset($item['children']) && !empty($item['children']) ) $this->updateFormIdForChildren($form_id,$item['id']);
	    }
	}
	
	/**
	 * Increment sort value for all items start from $start_sort.
	 *
	 * @param string $table
	 * @param integer $form_id
	 * @param integer $container_id
	 * @param integer $start_sort
	 */
	private function incSort($table,$form_id,$container_id,$start_sort)
	{
        $this->db->order_by('sort','asc');
        $records = $this->db->get_where($table,array('form_id'=>$form_id,'container_id'=>$container_id,'sort >='=>$start_sort))->result_array();

        foreach ($records as $record)
        {	
			$this->db->update($table,array('sort'=>$record['sort']+1),array('id'=>$record['id']));
		}
	}
	
	/**
	 * Increment answers sort for all items start from $start_sort.
	 *
	 * @param integer $answerset_id
	 * @param integer $start_sort
	 */
	private function incAnswersetValueSort($answerset_id,$start_sort)
	{
        $this->db->order_by('sort','asc');
        $records = $this->db->get_where('form_answersets_values',array('answerset_id'=>$answerset_id,'sort >='=>$start_sort))->result_array();

        foreach ($records as $record)
        {	
			$this->db->update('form_answersets_values',array('sort'=>$record['sort']+1),array('id'=>$record['id']));
		}
	}
	
	
	// === Sort Stuff: End === //
	
	/// ==== Copy Form Item: Start === ///
    /**
     * Copy form's item.
     * @param string $item_type
     * @param int $item_id
     * @param int $form_id
     * @param int $container_id
     * @return bool|int
     */
    public function copyFormItem($item_type,$item_id,$form_id,$container_id=0)
	{
		if( !in_array($item_type,array('container','input')) ) return FALSE;
		
		if( $item_type=='container' ) $item = $this->getContainerById($item_id);
		else $item = $this->getInputById($item_id);
		
		$item['main_type'] = $item_type;
		
		//get all langs' text 
	    $item = $this->getMultilangFields($item);
		
		return $this->importItem($item,$form_id,$container_id);
	}
	/// ==== Copy Form Item: End === ///
    
    /**
     * Return form tree.
     *
     * @param integer $form_id
     * @param integer $container_id
     * @return array
     */
    public function getTree($form_id=0,$container_id=0)
    {
    	if(!$form_id) 
    	{
    		$tree = $this->getForms();
    		
    		foreach ($tree as &$form)
    		{
    			$children = $this->getTree($form['id']);
    			
    			if(!empty($children)) $form['children'] = $children;
    		}
    		
    		return $tree;
    	}
    	else 
    	{
    		$tree = $this->getContainers($form_id,$container_id);
	    	
    		if(empty($tree)) return $this->getInputs($form_id,$container_id);
	    	
	    	foreach ($tree as &$container)
	    	{
	    		$children = $this->getTree($form_id,$container['id']);
	    		
	    		if(!empty($children)) $container['children'] = $children;
	    	}
    	}
    	
    	return $tree;
    }
    
    /**
     * Return list of all forms.
     *
     * @return array
     */
    private function getForms()
    {
    	//multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect().', cast("form" as char) as main_type ');
		$this->_buildMultilangJoin(FALSE);
	    
		$this->db->order_by('id','asc');
	    $records = $this->db->get($this->c_table)->result_array();
	    
	    return $records;
    }
    
    /**
	 * Returns containers list.
	 * 
	 * @param integer $form_id
	 * @param integer $container_id
	 * @return array
	 */
	private function getContainers($form_id,$container_id=0)
	{
		$this->c_table = 'form_containers';
	    
	    //multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect().', cast("container" as char) as main_type ');
		$this->_buildMultilangJoin(FALSE);
	    
		$this->db->order_by('sort','asc');
	    if($container_id) $records = $this->db->get_where($this->c_table,array("container_id"=>$container_id))->result_array();//subcontainers
	    else $records = $this->db->get_where($this->c_table,array("form_id"=>$form_id,'container_id'=>0))->result_array();//root containers
		
	    //get all langs' text (need for export)
	    if($this->multilang_tree) $records = array_map(array($this,'getMultilangFields'),$records);

		return $records;
	}
	
	/**
	 * Returns inputs list.
	 * 
	 * @param integer $form_id
	 * @param integer $container_id
	 * @return array
	 */
	private function getInputs($form_id=0,$container_id=0)
	{
		if(!$form_id && !$container_id) return array();
		
		$this->c_table = 'form_inputs';
	    
	    //multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect().', cast("input" as char) as main_type ');
		$this->_buildMultilangJoin(FALSE);
	    
		$this->db->order_by('sort','asc');
	    if($container_id) $records = $this->db->get_where($this->c_table,array("container_id"=>$container_id))->result_array();//just inputs for defined container
	    else $records = $this->db->get_where($this->c_table,array("form_id"=>$form_id))->result_array();//all form inputs
		
		//prefill value for inputs
		foreach ($records as &$record)
		{
		    $name = $this->getInputName($record);
		    
		    if( preg_match("/^(\w+)\[LANG\]$/",$name,$matches) )//if multilang input, for example - title[LANG]
		    {
		    	if( isset($this->form_data[$matches[1]]) ) $record['value'] = $this->form_data[$matches[1]];//array with keys EN,NL,UA,RU etc
		    	
		    	//translate javascript tool
		    	$this->addInclude('js-multilang-help-tools');
		    }
		    elseif( isset($this->form_data[$name]) )
		    {
		        $value = $this->form_data[$name];
		        
		        //if checkboxes values separated by "|"
		        if( $record['type']=='checkbox' && $record['answerset_id'] && !is_array($value) && stristr($value,'|') ) $value = explode('|',$value);
		        
		        $record['value'] = $value;
		    }
		    
		    //include javascripts depending if there are some types of inputs on screen
		    if( $record['type']=='file' ) $this->addInclude('js-lightbox'); //for preview large image
		    elseif( $record['type']=='richtext' ) $this->addInclude('js-tinymce'); //tinymce editor for richtext
		    elseif( $record['type']=='date' ) 
		    {
		        $this->addInclude('js-meio-mask'); 
		        $this->addInclude('js-init-mask'); 
		    }
		}
	    
		//get all langs' text (need for export)
	    if($this->multilang_tree) $records = array_map(array($this,'getMultilangFields'),$records);
	    
	    //get attached answerset (need for export)
	    if($this->multilang_tree) 
	    {
	    	foreach ($records as &$record)
	    	{
	    		if($record['answerset_id'])//if isset answerset_id
	    		{
	    			$answerset = $this->getAnswersetById($record['answerset_id']);
	    			
	    			if($answerset)//if there is attached answerset 
	    			{
	    				$record['answerset'] = $answerset;
	    				$record['answerset_values'] = $this->getAnswersetsValues($record['answerset_id']);
	    			}
	    		}
	    	}
	    }
		
		return $records;
	}
	
	/**
	 * Return all form's inputs with defined type.
	 *
	 * @param integer $form_id
	 * @param string $type
	 * @param bool $just_names
	 * @return array
	 */
	private function getInputsByType($form_id,$type,$just_names=TRUE)
	{
		$inputs = array();
		
		$records = $this->db->get_where('form_inputs',array("form_id"=>$form_id,'type'=>$type))->result_array();
		
		if($just_names) foreach ($records as $record)	$inputs[] = $record['name'];
		else $inputs = $records;
		
		return $inputs;
	}
	
	/**
	 * Add javascript include on screen.
	 *
	 * @param string $include
	 */
	private function addInclude($include)
	{
		if( !in_array($include, $this->includes) ) $this->includes[] = $include;
	}
	
	/**
	 * Return list of javascript includes.
	 *
	 * @return array
	 */
	public function getIncludes()
	{
		return $this->includes;
	}

    /**
     * Getter for $this->js_included
     */
    public function getJsIncluded()
    {
        return $this->js_included;
    }

    /**
     * Setter for $this->js_included
     */
    public function setJsIncluded()
    {
        $this->js_included = TRUE;
    }
	
	/**
	 * Show form as tree.
	 *
	 * @param integer $form_id
	 * @param integer $container_id
	 * @return string
	 */
	public function showTree($form_id=0,$container_id=0)
    {
    	$tree = $this->getTree($form_id,$container_id);
    	
    	$str = "<ul>";
    
    	foreach ($tree as $item)
    	{
    		$id = $item['id'];
    		$label = $item['label'];
    		$type = $item['main_type'];
    		
    		switch ($type)
    		{
    			case "form":
    				$method = 'forms_edit';
    			break;
    			case "container":
    				$method = 'containers_edit';
    			break;
    			case "input":
    				$method = 'inputs_edit';
    			break;	
    		}
    		
    		if($method=='forms_edit') $url = site_url($this->CI->_getBaseURI()."/{$method}/{$id}");
    		else $url = site_url($this->CI->_getBaseURI()."/{$method}/{$form_id}/{$container_id}/{$id}");
    		
    		$link = "<a href='{$url}'>{$label}</a>";
    		
    		$str .= "
			<li id='li-{$type}-{$id}' rel='{$type}'>
				".$link."
			";
			
			if( isset($item['children']) )
			{
    			$form_id = ($type=='form')? $id : $form_id;
    			$sub_container_id = ($type=='form')? 0 : $id;
    			
    			//recursion
    			$str .= $this->showTree($form_id,$sub_container_id);
			}
			
			$str .= "
			</li>
			";
    	}
    	
    	$str .= "</ul>";
    	
    	return $str;
    }
    
    
    /**
	 * Delete form by $form_id.
	 * 
	 * @param integer $form_id
	 * @return void
	 */
	public function deleteFormById($form_id)
	{
		//if form has containers - delete them 
		if( $containers = $this->getContainers($form_id) )
		{
			foreach ($containers as $container)
			{
				$this->deleteContainerById($container['id']);
			}
		}
		//if form has inputs - delete them
		elseif ( $inputs = $this->getInputs($form_id) )
		{
			foreach ($inputs as $input)
			{
				$this->deleteInputById($input['id']);
			}
		}
		
		//delete form (with multilang data)
		$this->c_table = 'forms';
		$this->deleteId($form_id);
		
		
		//delete stored form's data
		//$this->db->delete('forms_store', array('form_id' => $form_id));// not sure if data should be deleted on form delete
	}
	
	/**
	 * Delete container by $container_id.
	 * 
	 * @param integer $container_id
	 * @return void
	 */
	public function deleteContainerById($container_id)
	{
		//if container has subcontainers - deleted them
		if( $subcontainers = $this->getContainers(0,$container_id) )
		{
			foreach ($subcontainers as $subcontainer)
			{
				$this->deleteContainerById($subcontainer['id']);
			}
		}
		//if containers has inputs - delete them
		elseif( $inputs = $this->getInputs(0,$container_id) )
		{
			foreach ($inputs as $input)
			{
				$this->deleteInputById($input['id']);
			}
		}
		
		$record = $this->getContainerById($container_id);
		
		//delete container  (with multilang data)
		$this->c_table = 'form_containers';
		$this->deleteId($container_id);
		
		$this->resetSortContainer($record['form_id'],$record['container_id']);
	}
	
	/**
	 * Delete input by $input_id.
	 * 
	 * @param integer $input_id
	 * @return void
	 */
	public function deleteInputById($input_id)
	{
		$record = $this->getInputById($input_id);
	    
	    $this->c_table = 'form_inputs';
		$this->deleteId($input_id);

		$this->resetSortInput($record['form_id'],$record['container_id']);
	}
	
	/**
	 * Reset containers sorting (after record deleted).
	 * 
	 * @param integer $form_id
	 * @param integer $container_id
	 * @return void
	 */
	protected function resetSortContainer($form_id,$container_id)
	{
	    $this->c_table = 'form_containers';
	    
	    if($container_id) parent::reset_sort(array('container_id'=>$container_id));
	    else parent::reset_sort(array('form_id'=>$form_id,'container_id'=>0));
	}
	
	/**
	 * Reset inputs sorting (after record deleted).
	 * 
	 * @param integer $form_id
	 * @param integer $container_id
	 * @return void
	 */
	protected function resetSortInput($form_id,$container_id)
	{
	    $this->c_table = 'form_inputs';
	    
	    if($container_id) parent::reset_sort(array('container_id'=>$container_id));
	    else parent::reset_sort(array('form_id'=>$form_id,'container_id'=>0));
	}
	
	/// ==== Answersets Stuff: Start === ///
	
	/**
	 * Returns answerset record by ID.
	 * 
	 * @param integer $id
	 * @return array
	 */
	public function getAnswersetById($id)
	{
		$this->c_table = 'form_answersets';
		
		return $this->getOneById($id);
	}
	
	/**
	 * Returns answerset value record by ID.
	 * 
	 * @param integer $id
	 * @return array
	 */
	public function getAnswersetValueById($id)
	{
		$this->c_table = 'form_answersets_values';
		
		return $this->getOneById($id);
	}
	
	/**
	 * Insert or update answerset. Depends if ID field is set.
	 * 
	 * @param array $post
	 * @return integer
	 */
	public function insertOrUpdateAnswerset($post)
	{
		$this->c_table = 'form_answersets';
		
		return parent::insertOrUpdate($post);
	}
	
	/**
	 * Insert or update answerset value. Depends if ID field is set.
	 * 
	 * @param array $post
	 * @return integer
	 */
	public function insertOrUpdateAnswersetValue($post)
	{
		$this->c_table = 'form_answersets_values';
		
        //if new insert
		if( !@$post[$this->id_column] ) $post['sort'] = $this->lastSortAnswersetValue($post['answerset_id']);		
		
		return parent::insertOrUpdate($post);
	}
	
	/**
	 * Generate value for sort column.
	 * 
	 * @param integer $answerset_id
	 * @return integer
	 */
	protected function lastSortAnswersetValue($answerset_id)
	{
	    $this->c_table = 'form_answersets_values';
	    
	    return parent::last_sort_val(array('answerset_id'=>$answerset_id));
	}
	
	/**
	 * Reset Answersets values Sorting (after record deleted).
	 * 
	 * @param integer $answerset_id
	 * @return void
	 */
	protected function resetSortAnswersetValue($answerset_id)
	{
	    $this->c_table = 'form_answersets_values';
	    
	    parent::reset_sort(array('answerset_id'=>$answerset_id));
	}
	
	/**
     * Return list of all answersets.
     *
     * @return array
     */
    private function getAnswersets()
    {
    	$this->c_table = 'form_answersets';
    	
    	//multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect().', cast("answerset" as char) as main_type ');
		$this->_buildMultilangJoin(FALSE);
	    
		$this->db->order_by('id','asc');
	    $records = $this->db->get($this->c_table)->result_array();
	    
	    return $records;
    }
    
    /**
	 * Returns answerset values by $answerset_id.
	 * 
	 * @param integer $answerset_id
	 * @return array
	 */
	public function getAnswersetsValues($answerset_id)
	{
		if(!$answerset_id) return array();
		
		//Check if answerset has generic answers
		$answerset = $this->getAnswersetById($answerset_id);
		if(empty($answerset)) return array();
		if($answerset['generic_answers']) return $this->getGenericAnswers($answerset['generic_answers']);
		
		$this->c_table = 'form_answersets_values';
	    
	    //multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect().', cast("answersets_value" as char) as main_type ');
		$this->_buildMultilangJoin(FALSE);
	    
		$this->db->order_by('sort','asc');
	    $records = $this->db->get_where($this->c_table,array("answerset_id"=>$answerset_id))->result_array();
	    
	    //get all langs' text (need for export)
	    if($this->multilang_tree) $records = array_map(array($this,'getMultilangFields'),$records);
		
		return $records;
	}
	
	/**
	 * Return list of answers.
	 *
	 * @param string $params
	 * @return array
	 */
	private function getGenericAnswers($params)
	{
		$params = explode("|",$params);
		
		$name = @$params[0];
		
		if(!$name) return FALSE;
		
		switch($name)
		{
			case "articles_categories":
			case "products_categories":
			case "documents_categories":
				$parent_id = intval(@$params[1]);

                $model_name = $name."_model";
				load_model($model_name);
				
				$records = $this->CI->$model_name->getChildren($parent_id);
				
				if(empty($records)) return array();
				
				$i=1;
				foreach ($records as $value=>$label)
				{
					$answers[$i]['id'] = $i;
					$answers[$i]['label'] = $label;
					$answers[$i]['value'] = $value;
					$i++;
				}
			break;
			
			case "products_manufacturers":
				load_model("products_manufacturers_model");
				
				$records = $this->CI->products_manufacturers_model->getManufacturersList();
				
				if(empty($records)) return array();
				
				$i=1;
				foreach ($records as $value=>$label)
				{
					$answers[$i]['id'] = $i;
					$answers[$i]['label'] = $label;
					$answers[$i]['value'] = $value;
					$answers[$i]['generic'] = TRUE;
					$i++;
				}
			break;
		}
		
		return $answers;
	}
	
	/**
	 * Return answersets tree array.
	 *
	 * @return array
	 */
	public function getAnswersetTree()
	{
		$answersets = $this->getAnswersets();
		
		foreach ($answersets as &$answerset)
		{
			$answerset['children'] = $this->getAnswersetsValues($answerset['id']);
		}
		
		return $answersets;
	}

    /**
     * Show answersets as tree.
     *
     * @param array $tree
     * @return string
     */
	public function showAnswersetTree($tree = array())
    {
    	if(empty($tree)) $tree = $this->getAnswersetTree();
    	
    	$str = "<ul>";
    
    	foreach ($tree as $item)
    	{
    		$id = $item['id'];
    		$label = $item['label'];
    		$type = $item['main_type'];
    		
    		switch ($type)
    		{
    			case "answerset":
    				$method = 'answersets_edit';
    			break;
    			case "answersets_value":
    				$method = 'answersets_values_edit';
    			break;	
    		}
    		
    		if($method=='answersets_edit') $url = site_url($this->CI->_getBaseURI()."/{$method}/{$id}");
    		else $url = site_url($this->CI->_getBaseURI()."/{$method}/{$item['answerset_id']}/{$id}");
    		
    		$link = "<a href='{$url}'>{$label}</a>";
    		
    		$str .= "
			<li id='li-{$type}-{$id}' rel='{$type}'>
				".$link."
			";
			
			if( isset($item['children']) && !empty($item['children']) && empty($item['generic_answers']) )
			{
    			//recursion
    			$str .= $this->showAnswersetTree($item['children']);
			}
			
			$str .= "
			</li>
			";
    	}
    	
    	$str .= "</ul>";
    	
    	return $str;
    }
    
    /**
	 * Delete answerset by $answerset_id.
	 * 
	 * @param integer $answerset_id
	 * @return void
	 */
	public function deleteAnswersetById($answerset_id)
	{
		if( $answers = $this->getAnswersetsValues($answerset_id) )
		{
			foreach ($answers as $answer)
			{
				if(!isset($answer['generic'])) $this->DeleteAnswersetValueById($answer['id']);
			}
		}
		
		//delete answerset  (with multilang data)
		$this->c_table = 'form_answersets';
		$this->deleteId($answerset_id);
	}
    
    /**
	 * Delete answerset value by $answerset_value_id.
	 * 
	 * @param integer $answerset_value_id
	 * @return void
	 */
	public function deleteAnswersetValueById($answerset_value_id)
	{
		$record = $this->getAnswersetValueById($answerset_value_id);
	    
	    $this->c_table = 'form_answersets_values';
		$this->deleteId($answerset_value_id);

		$this->resetSortAnswersetValue($record['answerset_id']);
	}
	
	/**
	 * Attach answerset to select,radio or checkbox.
	 *
	 * @param integer $answerset_id
	 * @param integer $input_id
	 */
	public function attachAnswersetToInput($answerset_id,$input_id)
	{
	    $this->c_table = 'form_inputs';
	    $post['answerset_id'] = $answerset_id;
	    $post['id'] = $input_id;
	    
	    parent::insertOrUpdate($post);
	}
	
	/**
	 * Detach answerset from select,radio or checkbox.
	 *
	 * @param integer $input_id
	 */
	public function detachAnswersetFromInput($input_id)
	{
	    $this->attachAnswersetToInput(0,$input_id);
	}
	
	/**
	 * Return list of inputs with this $answerset_id.
	 *
	 * @param integer $answerset_id
	 * @return array
	 */
	public function getInputsWithAnswerset($answerset_id)
	{
		if(!$answerset_id) return array();
		
		$this->c_table = 'form_inputs';
	    
	    //multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect());
		$this->_buildMultilangJoin(FALSE);
	    
		$records = $this->db->get_where($this->c_table,array("answerset_id"=>$answerset_id))->result_array();
	    
		return $records;
	}
	
	/**
	 * Return answerset_id by label_lang_id.
	 *
	 * @param integer $label_lang_id
	 * @return integer|bool
	 */
	public function getAnswersetIdByLabelLangId($label_lang_id)
	{
		$record = $this->db->get_where('form_answersets',array("label_lang_id"=>intval($label_lang_id)))->row_array();
		
		if($record) return $record['id'];
		else return FALSE;
	}
	
	/**
	 * Return record from answersets_values by fields "value" and "answerset_id".
	 * This needs for answersets with special values.
	 *
	 * @param string $value
	 * @param integer $answerset_id
	 * @return array
	 */
	private function getAnswersetValueByValue($value,$answerset_id)
	{
		$answerset_value = $this->db->get_where('form_answersets_values',array("value"=>$value,'answerset_id'=>intval($answerset_id)))->row_array();
		
		return $this->getAnswersetValueById($answerset_value['id']);
	}

    /**
     * Return answers' labels by stored values.
     * This needs for show selected answers.
     *
     * @param string $values
     * @param string $format
     * @param bool|string $input_name
     * @param bool|int $form_id
     * @return mixed
     */
	public function getAnswersetLabelsByValues($values,$format="array",$input_name=FALSE,$form_id=FALSE)
	{
		$values = explode("|",$values);
		$labels = array();
		
		if(!empty($values))
		{
			foreach ($values as $value)
			{
				if(preg_match("/^a_(\d+)$/",$value,$matches))
				{
					$answerset_value = $this->getAnswersetValueById($matches[1]);
					if(is_array($answerset_value['label'])) $answerset_value = $this->justCurrentLang($answerset_value);
					if($answerset_value) $labels[] = $answerset_value['label'];
				}
				elseif($input_name && $form_id) 
				{
					$form_id = $this->convertHtmlId2FormId($form_id);
					
					$input = $this->getInputByName($input_name,$form_id);
					if($input && $input['answerset_id'])
					{
						$answerset_value = $this->getAnswersetValueByValue($value,$input['answerset_id']);
						if($answerset_value) $labels[] = $answerset_value['label'];
					}
				}
			}
		}
		
		if($format=='comma_separated' || $format==',') $labels = join(", ",$labels);
		
		return $labels;
	}
	
	/// ==== Answersets Stuff: End === ///
	
	/// ==== Build Form Stuff: Start === ///
	
	/**
	 * Return mode for display form.
	 *
	 * @return string
	 */
	public function getFormMode()
	{
		return $this->form_mode;
	}
	
	/**
	 * Set mode for display form.
	 *
	 * @param string $mode
	 */
	public function setFormMode($mode)
	{
		$this->form_mode = $mode;
	}
	
	/**
	 * Return form.id for form.html_id
	 *
	 * @param integer|string $form_id
	 * @return integer
	 */
	private function convertHtmlId2FormId($form_id)
	{
		//if $form_id is "html_id" of form
		if( !preg_match("/^\d+$/",$form_id) ) $form_id = $this->getFormIdByHtmlId($form_id);
		
		return $form_id;
	}
	
	/**
	 * Build form.
	 *
	 * @param integer|string $form_id
	 * @param bool|string(16) $data_key
     * @return bool
	 */
	public function buildForm($form_id,$data_key=FALSE)
	{		
		$form_id = $this->convertHtmlId2FormId($form_id);
		
		$form = $this->initForm($form_id,$data_key);
		
		if(empty($form)) return FALSE;
		
		$form['children'] = $this->getTree($form_id);
		//dump($form);
		load_theme_view($this->getScreensPath().'container/form',array('item'=>$form));

        return TRUE;
	}

    /**
     * Initialize form.
     *
     * @param integer $form_id
     * @param bool|string(16) $data_key
     * @return array
     */
	private function initForm($form_id,$data_key=FALSE)
	{
	    $form = $this->getFormById($form_id);
		
		if(empty($form)) return FALSE;
	    
	    $this->form_id = $form['id'];
		$this->form_store_table = $form['store_in_table'];
		$this->form_files_store_path = ( ($this->form_store_table)? $this->form_store_table : 'form_store/'.$this->form_id );
		
		if($data_key) 
		{
		    $this->data_key = $data_key;
		    $this->setFormDataByKey($data_key);
		}
		
		return $form;
	}
	
	/**
	 * Return form's data_key.
	 *
	 * @return string(16)
	 */
	public function getDataKey()
	{
	    return $this->data_key;
	}
	
	/**
	 * Return path where files stored.
	 *
	 * @return string
	 */
	public function getFormFilesStorePath()
	{
	    return $this->form_files_store_path;
	}
	
	
	/**
	 * Build string with extra parameters for inputs.
	 *
	 * @param array $item
	 * @return string
	 */
	public function buildInputExtra($item)
	{
		$style = "";
		$extra = "";
		
		if($item['height']) $style .= " height:{$item['height']}{$item['height_units']}; ";
		if($item['width']) $style .= " width:{$item['width']}{$item['width_units']}; ";
		
		if($item['html_id']) $extra .= " id='{$item['html_id']}' ";
		if($item['html_class']) $extra .= " class='{$item['html_class']}' ";
		if(isset($item['alt'])) $extra .= " alt='{$item['alt']}' ";
		
		if($style) $extra .= " style='{$style}' ";
		
		return $extra;
	}
	
	/**
	 * Return skip_rule attribute for item.
	 *
	 * @param array $item
	 * @return string
	 */
	public function outputSkipRule($item)
	{
		if( $item['skip_rule'] && $this->getFormMode()=='edit' ) return 'skip_rule = "'.$item['skip_rule'].'"';
		return '';
	}
	
	/**
	 * Return path to elements screens.
	 *
	 * @return string
	 */
	public function getScreensPath()
	{
	    return 'formbuilder/screens/';
	}
	
	/**
	 * Return path to input's parts.
	 *
	 * @return string
	 */
	public function getInputPartsPath()
	{
	    return $this->getScreensPath().'input/parts/';
	}
	
	/**
	 * Return path to template's parts.
	 *
	 * @return string
	 */
	public function getTemplatePartsPath()
	{
	    return $this->getScreensPath().'template/parts/';
	}
	
	/**
	 * Return name for input (if not didn't set - generate it)
	 *
	 * @param array $item
	 * @return string
	 */
	public function getInputName(array $item)
	{
	    return (($item['name'])?$item['name']:'q_'.$item['id']);
	}
	
	/**
	 * Return value of answer (if not didn't set - generate it)
	 *
	 * @param array $answer
	 * @return string
	 */
	public function getAnswerValue(array $answer)
	{
	    return (($answer['value']!=='')?$answer['value']:'a_'.$answer['id']);
	}
	
	/**
	 * Return CSS id for answer.
	 *
	 * @param array $item
	 * @param array $answer
	 * @return string
	 */
	public function getAnswerCSSId(array $item,array $answer)
	{
	    return 'q_'.$item['id'].'_a_'.$answer['id'];
	}

	/**
	 * Return input by its name and form_id.
	 *
	 * @param string $name
	 * @param integer|string $form_id
	 * @return array
	 */
	private function getInputByName($name,$form_id)
	{
	    if( !$form_id || !$name ) return FALSE;
	    
	    $form_id = $this->convertHtmlId2FormId($form_id);
	    
	    $this->c_table = 'form_inputs';
	    
	    $input = $this->db->get_where($this->c_table,array('form_id'=>$form_id,'name'=>$name))->row_array();
		
		return $this->getOneById($input['id']);
	}
	
	/**
	 * Return input's label by its name and form_id.
	 *
	 * @param string $name
	 * @param integer|string $form_id
	 * @return array
	 */
	public function getInputLabelByName($name,$form_id)
	{
		$input = $this->getInputByName($name,$form_id);
		if(isset($input['label'])) return $input['label'];
		return FALSE;
	}
	
	/**
	 * Remove "required" validation from skipped inputs.
	 *
	 * @param array $data
	 * @param array $inputs
	 */
	private function setNotRequiredSkippedInputs($data,&$inputs)
	{
	    foreach ($inputs as &$input)
	    {
	        $not_required = FALSE;
	        
	        if( $input['skip_rule'] && $this->runSkipRule($data,$input['skip_rule']) ) 
	        {
	            $not_required = TRUE;
	        }
            elseif( $input['container_id'] && $this->checkParentContainerSkip($data,$input['container_id']) ) 
            {
                $not_required = TRUE;
            }
            
            if($not_required)
            {
                $input['validation'] = str_replace("required","",$input['validation']);
	            $input['validation'] = str_replace("||","|",$input['validation']);
            }
	    }
	}
	
	/**
	 * Check if parent container skipped recursive.
	 *
	 * @param array $data
	 * @param integer $container_id
	 * @return bool
	 */
	private function checkParentContainerSkip($data,$container_id)
	{
	    $container = $this->getContainerById($container_id);
        if( $container['skip_rule'] && $this->runSkipRule($data,$container['skip_rule']) ) return TRUE;
        elseif ( $container['container_id'] ) return $this->checkParentContainerSkip($data,$container['container_id']);
        else return FALSE;
	}
	
	/**
	 * Check skip rule.
	 *
	 * @param array $data
	 * @param string $skip_rule
	 * @return bool
	 */
	private function runSkipRule($data,$skip_rule)
	{
	    //TODO: validate skip rule before run
	    //...
	    
	    //TODO: if not isset $data[$var] set it FALSE (checkboxes and radios) than "@" from next line cold be removed
	    
	    $skip_rule = preg_replace("/FD\.(\w+)/","\$data['\\1']",$skip_rule);
	            
        @eval("\$skip = ({$skip_rule});");
        
        return $skip;
	}
	
	/**
	 * Validate form.
	 *
	 * @param array $data
	 * @param integer $form_id
	 * @return bool
	 */
	private function validateForm(&$data,$form_id)
	{
		//get all form's inputs
		$inputs = $this->getInputs($form_id);
	    
	    $this->setNotRequiredSkippedInputs($data,$inputs);

	    if(empty($inputs)) return FALSE;
	    
	    $configValidation = array();
	    
	    //validate category
	    if( isset($data['category']) && is_array($data['category']) )
	    {
	    	$configValidation[] = array(
                     'field'   => 'category[]', 
                     'label'   => language('category'), 
                     'rules'   => 'trim|integer|callback__isset_category'
                  );
	    }
	    
	    //generate validation array
	    foreach ($inputs as $input)
	    {
            $name = $this->getInputName($input);
            $value = @$data[$name];
	        
	        //preparation data
	        switch ($input['type']) 
	        {
	        	case "date":
	        	    //change data format
	        		if(preg_match("[^(\d{2})/(\d{2})/(\d{4})$]",$value,$matches)) $data[$name] = $matches[3].'-'.$matches[2].'-'.$matches[1];
	        	break;
	        };
	        
	        //if there is slug
	        if ($input['name']=='slug_from')
	        {
	        	if( $slug_lang_id = intval(@$data['slug_lang_id']) )
	        	{
		        	foreach (get_multilang_codes() as $lang_code)
		        	{
		        		$configValidation[] = array(
	                     'field'   => "slug[{$lang_code}]", 
	                     'label'   => "Slug ({$lang_code})", 
	                     'rules'   => 'trim|max_length[250]|callback__unique_slug['.$lang_code.','.$this->form_store_table.','.$slug_lang_id.']'
	                  );
		        	}
	        	}
	        	else 
	        	{
	        		$configValidation[] = array(
                     'field'   => "slug", 
                     'label'   => "Slug", 
                     'rules'   => 'trim|max_length[250]|callback__unique_field_for_edit[slug,'.(@$data['data_key']).']'
                  );
	        	}
	        }
	        
	        //if no validation for input
	        if(!$input['validation']) continue;
	        
	        //for "callback__unique_field_for_edit[field,{data_key}]"
	        $input['validation'] = str_replace("{data_key}",@$data['data_key'],$input['validation']);
	        
	        if(stristr($input['name'],"[LANG]"))//if multilang field - add validation for each lang
	        {
	        	foreach (get_multilang_codes() as $lang_code)
	        	{
	        		$configValidation[] = array(
                     'field'   => str_replace("[LANG]","",$input['name'])."[{$lang_code}]", 
                     'label'   => $input['label']." ({$lang_code})", 
                     'rules'   => $input['validation']
                  );
	        	}
	        }
	        else 
	        {
	        	$configValidation[] = array(
                     'field'   => $input['name'], 
                     'label'   => $input['label'], 
                     'rules'   => $input['validation']
                  );
	        }
	    }
	    //dump($configValidation);exit;
	    
	    //if no validation rules - than valid
	    if(empty($configValidation)) return TRUE;
	    
	    $this->CI->load->library('form_validation');
	    
	    $this->CI->form_validation->set_rules($configValidation);

	    //check if valid
        //while CodeIgniter validate $_POST and xss_clean it, use this trick $data -> $_POST and $_POST -> $data
        $_POST = $data;
	    $valid = $this->CI->form_validation->run();
        $data = $_POST;

        return $valid;
	}

    /**
     * Upload files on form screen.
     * Don't set name of file = "image", could be re-uploaded in posts model.
     *
     * @param array $form
     * @param array $data
     * @param bool|string(16) $data_key
     */
	private function uploadFiles($form,&$data,$data_key=FALSE)
    {
		//dump($_FILES);exit;
    	
    	$this->CI->load->library('uploader_lib');
		
		$short_path = ($form['store_in_table'])? $form['store_in_table'] : 'form_store/'.$form['id'];
		
		$config = array(
    		  'short_path' => $short_path
    		);
		
    	foreach ($_FILES as $file_field=>$file_info)
        {
        	//if no file selected
        	if(empty($file_info['tmp_name'])) continue;
            
            $input = $this->getInputByName($file_field,$form['id']);
        	//if no input in this form
        	if(!$input) continue;
        	
        	//remove OLD file
        	if($data_key) $this->removeFile($form['id'],$file_field,$data_key);
        	
        	
        	if( $input['image_small_height'] ) $config['small_height'] = $input['image_small_height'];
        	if( $input['image_small_width'] ) $config['small_width'] = $input['image_small_width'];
        	$config['small_crop'] = $input['image_small_crop'];
        	
        	if( $input['image_medium_height'] ) $config['medium_height'] = $input['image_medium_height'];
        	if( $input['image_medium_width'] ) $config['medium_width'] = $input['image_medium_width'];
        	$config['medium_crop'] = $input['image_medium_crop'];
        	if( $input['image_medium_height'] || $input['image_medium_width'] ) $config['medium_dir'] = "m/";
        	
        	if( $input['image_big_height'] ) $config['big_height'] = $input['image_big_height'];
        	if( $input['image_big_width'] ) $config['big_width'] = $input['image_big_width'];
        	$config['big_crop'] = $input['image_big_crop'];
    		
    		$this->uploader_lib->initialize($config);
        	
        	$file_name = $this->uploadFile($file_field);
        	if($file_name) $data[$file_field] = $file_name;
        }
    }
    
    /**
     * Upload file.
     *
     * @param string $file_field
     * @return string
     */
    private function uploadFile($file_field)
    {
		return $this->uploader_lib->uploadFile($file_field);
    }
    
    /**
     * Remove store file.
     *
     * @param integer $form_id
     * @param string $file_field
     * @param string(16) $data_key
     */
    public function removeFile($form_id,$file_field,$data_key)
    {
        $this->initForm($form_id,$data_key);
        
        //put real file here
        $this->CI->load->library('uploader_lib');
        
        $short_path = ($this->form_store_table)? $this->form_store_table : 'form_store/'.$form_id;
		
		$config = array(
    		  'short_path' => $short_path
    		);
    		
        $this->uploader_lib->initialize($config);
        
        $this->uploader_lib->unlinkFile($this->form_data[$file_field]);
        
        
        if($this->form_store_table)
	    {
	        $this->db->update($this->form_store_table,array($file_field=>''),array('data_key'=>$data_key));
	    }
	    else 
	    {
            $this->db->update('form_store',array('value'=>''),array('form_id'=>$form_id,'data_key'=>$data_key,'field'=>$file_field));
	    }
    }
    
    /**
     * Remove all stored files for form.
     *
     * @param integer|string $form_id
     * @param string(16) $data_key
     */
    public function removeFiles($form_id,$data_key)
    {
    	$form_id = $this->convertHtmlId2FormId($form_id);
    	
    	$names = $this->getInputsByType($form_id,'file');
    	
    	foreach ($names as $file_field)
    	{
    		$this->removeFile($form_id,$file_field,$data_key);
    	}
    }
    
    /**
     * Build URL for removing file.
     *
     * @param string $file_field
     * @return string
     */
    public function getRemoveFileURL($file_field)
    {
        return site_url($this->CI->_getBaseURL().'formbuilder/remove_file/'.$this->form_id.'/'.$file_field.'/'.$this->data_key);
    }

    /**
     * Check if $data_key exists in table of form.
     *
     * @param string(16) $data_key
     * @param bool|string $table
     * @return bool
     */
    private function isDataKeyExists($data_key,$table=FALSE)
    {
        if(!$table) $table = 'form_store';
        
        return (bool)$this->db->get_where($table,array('data_key'=>$data_key))->row_array();
    }
    
    /**
     * Generate and add slug to data.
     *
     * @param array $data
     * @return array
     */
    private function addSlug2data(array $data)
    {
        //if there is defined from what var generate slug and this var exists
        if( ($slug_from = @$data['slug_from']) && isset($data[$slug_from]) )
		{
			if( is_array($data[$slug_from]) ) 
			{
				foreach (get_multilang_codes() as $lang_code)
				{
				    $_POST['slug'][$lang_code] = $data['slug'][$lang_code] = $this->doSlug($data[$slug_from][$lang_code]);
				}
			}
			else $_POST['slug'] = $data['slug'] = $this->doSlug($data[$slug_from]);
		}
		
		return $data;
    }

    /**
     * Store form data.
     *
     * @param array $data
     * @param integer $form_id
     * @param bool|string(16) $data_key
     * @return string(16)
     */
	public function storeForm($data,$form_id,$data_key=FALSE)
	{
	    $form_id = $this->convertHtmlId2FormId($form_id);
	    
	    //get form by ID
		$form = $this->getFormById($form_id);

		//if there is no form with this ID
	    if(empty($form)) return FALSE;
	    
	    //check $data_key (if it really exists in database)
	    if( $data_key && !$this->isDataKeyExists($data_key,$form['store_in_table']) ) return FALSE;

	    //generate and add slug
	    $data = $this->addSlug2data($data);
	    
	    //checkboxes doesn't posted at all while not checked
		$data = $this->setCheckboxesUnchecked($data,$form_id); 
	    
	    //init form
	    $this->initForm($form_id,$data_key);
	    
	    //if edit form - merge existed data with posted
	    if($data_key) $data = array_merge($this->form_data,$data);

	    //validate _POST
	    $valid = $this->validateForm($data,$form_id);

	    //if _POST not valid
	    if(!$valid) return FALSE;

	    //prepare multi-answers
	    $data = $this->prepareValueOfMultiAnswers($data);
	    
	    //upload files
	    $this->uploadFiles($form,$data,$data_key);
	    
	    //if form has separate table for storing data
	    if( $form['store_in_table'] )
	    {
	        $model_name = $form['store_in_table'].'_model';
	        if( file_exists(APPPATH."models/{$model_name}.php") )
	        {
	            $model = load_model($model_name);
	        }
	        
	        $post = $data;
	        
	        //config storing
	        $this->c_table = $form['store_in_table'];
	        $this->id_column = 'data_key';
	        
	        if($data_key) 
	        {
	            $post['data_key'] = $data_key;
	            
	            if( isset($model) ) $model->Update($post);
	            else $this->Update($post);
	        }
	        else 
	        {
	            if( isset($model) ) $post['data_key'] = $model->Insert($post);
	            else $post['data_key'] = $this->Insert($post);
	        }
	        
	        $this->id_column = 'id';
	    }
	    //if form has not separate table - store in general table
	    else 
	    {
    	    $this->c_table = 'form_store';
    	    
    	    $post['form_id'] = $form_id;
    	    
    	    if($data_key)
    	    {
    	        $post['data_key'] = $data_key;
    	        
    	        //delete old data (for edit)
    	        $this->db->delete($this->c_table,array('data_key'=>$data_key));
    	    }
    	    else $post['data_key'] = $this->generateDataKey();
    	    
    	    foreach ($data as $key=>$value)
    	    {
    	        if($key=='captcha') continue;
    	    	
    	    	$post['field'] = $key;
    	        $post['value'] = $value;
    	        
    	        $this->Insert($post);
    	    }
	    }
	    
	    return $post['data_key'];
	}
	
	/**
	 * Set checkboxes unchecked (because _POST doesn't send checkboxes at all while they not checked).
	 *
	 * @param array $data
	 * @param integer $form_id
	 * @return array
	 */
	private function setCheckboxesUnchecked($data,$form_id)
	{
		//get names of all form's checkboxes
		$names = $this->getInputsByType($form_id,'checkbox');	
		
		foreach ($names as $name) if(!isset($data[$name])) $data[$name] = 0;
		
		return $data;
	}
	
	/**
	 * Prepare data for insert in table.
	 *
	 * @param array $data
	 * @return array
	 */
	private function prepareValueOfMultiAnswers($data)
	{
		foreach ($data as &$value)
	    {
			//protect from misunderstand as multi-answers by script
	    	//$value = str_replace('|','/',$value);//could be used in youtube url [width|height]
	        
	        //separate multi-answers with "|" (checkbox values)
    	    if( is_array($value) ) 
    	    {
    	    	if( !array_intersect(array_keys($value),get_multilang_codes()) )//if not multilang
    	    	{
    	    		$value = implode('|',$value);
    	    	}
    	    }
	    }
	    
	    return $data;
	}
	
	/**
	 * Prefill form with stored data (for edit). 
	 *
	 * @param string(16) $data_key
	 */
	private function setFormDataByKey($data_key)
	{
	    if($this->form_store_table)
	    {
	        $this->form_data = $this->db->get_where($this->form_store_table,array('data_key'=>$data_key))->row_array();
	        
	        //get multilang fields
	        $this->form_data = $this->getMultilangFields($this->form_data);
	    }
	    else 
	    {
            $this->db->select('field, value');
            $records = $this->db->get_where('form_store',array('data_key'=>$data_key))->result_array();
            if(!empty($records)) $this->form_data = multi2singleArray('field','value',$records);
	    }
	}
	
	/**
	 * Prefill form with any array (for error while validation)
	 *
	 * @param array $data
	 */
	public function setFormData($data)
	{
		$this->form_data = $data;
	}
	
	/**
	 * Return number for inputs row (for odd and even class).
	 *
	 * @return integer
	 */
	public function getListRowNumber()
	{
		return $this->list_row_number;
	}
	
	/**
	 * Increase inputs' row number.
	 *
	 */
	public function incListRowNumber()
	{
		$this->list_row_number++;
	}
	
	/// ==== Build Form Stuff: End === ///
	
	
	/// ==== Generate SQL for create table: Start === ///
	
	/**
	 * Generate SQL for creating table based on form's inputs.
	 *
	 * @param integer $form_id
     * @return string
	 */
	private function generateFormCreateTableSQL($form_id)
	{
		if(!$form_id) return FALSE;
		
		$form = $this->getFormById($form_id);
		
		if(!$form || !$form['store_in_table']) return FALSE;
		
		$inputs = $this->getInputs($form_id);
		
		if(empty($inputs)) return FALSE;
		
		/*dump($form);
		dump($inputs);
		exit;*/
		
		$sql = "
		CREATE TABLE IF NOT EXISTS `{$form['store_in_table']}` (
			`data_key` CHAR(16) NOT NULL,
			`pub_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,";
		
		foreach ($inputs as $input)
		{
			if(!$input['name']) continue;
			
			if( $input['type']=='password' ) $size = 32;//md5
			elseif( $input['type']=='file' ) $size = 40;//32 (md5) + (4 or 5 extension)
			elseif( preg_match("/max_length\[(\d+)\]/",$input['validation'],$matches) ) $size = $matches[1];//set max_length as size
			else $size = 255;
			
			if( stristr($input['name'],"[LANG]") ) 
				$sql .= "
			`".str_replace("[LANG]","",$input['name'])."_lang_id` INT(11) NOT NULL DEFAULT 0,";
			elseif( stristr($input['validation'],'numeric') )
				$sql .= "
			`{$input['name']}` DECIMAL(7,2) NOT NULL DEFAULT '0.00',";
			elseif( stristr($input['validation'],'natural') )
				$sql .= "
			`{$input['name']}` INT(5) UNSIGNED NOT NULL DEFAULT '0',";
			elseif( in_array($input['type'],array('text','password','select','radio','checkbox','file')) ) 
				$sql .= "
			`{$input['name']}` VARCHAR({$size}) NOT NULL,";
			elseif( in_array($input['type'],array('textarea','richtext')) )
				$sql .= "
			`{$input['name']}` TEXT NOT NULL,";
			elseif( in_array($input['type'],array('time')) )
				$sql .= "
			`{$input['name']}` TIME NOT NULL,";
			elseif( in_array($input['type'],array('date')) )
				$sql .= "
			`{$input['name']}` DATE NOT NULL,";
		}
		
		$sql .= "
			PRIMARY KEY (`data_key`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		";
		//dump($sql);exit;
		return $sql;
	}
	
	/**
	 * Create table for saving form data.
	 *
	 * @param integer $form_id
	 */
	public function createTable($form_id)
	{
		$sql = $this->generateFormCreateTableSQL($form_id);
		
		$this->db->query($sql);
	}
	/// ==== Generate Form SQL: End === ///
	
	/// ==== List Form data: Start === ///
	/**
	 * Return list of inputs that could be used as fields for admin output list.
	 *
	 * @param integer $form_id
	 * @return array
	 */
	public function getFieldsList($form_id)
	{
	    $inputs = $this->getInputs($form_id);
	    if(empty($inputs)) return array();
	    
	    $fields = array(
	       'data_key'=>'ID',
	       'pub_date'=>language('publish_date')
	    );
	    
	    foreach ($inputs as $input)
	    {
	        if($input['show_on_list']=='no') continue;
	        
	        $name = str_replace("[LANG]","",$input['name']);
	        if(!$name) continue;
	        $fields[$name] = $input['label'];
	    }
	    
	    return $fields;
	}
	
	/**
	 * Return list of cols info for admin output list.
	 *
	 * @param integer $form_id
	 * @return array
	 */
	public function getColsList($form_id)
	{
	    $fields = $this->getFieldsList($form_id);
	    
	    $cols = array();
	    
	    foreach ($fields as $field=>$title)
	    {
	        switch ($field)
	        {
	            case "data_key":
	                $width = 150;
	            break;
	        }
	        
	        $cols[] = array(
                            'field' => $field,
                            'width' => $width,
                        );
	    }
	    
	    return $cols;
	}
	
	/**
	 * Return form title by ID.
	 *
	 * @param integer $form_id
	 * @return string
	 */
	public function getFormTitle($form_id)
	{
	    $form = $this->getFormById($form_id);
	    if(!$form) return FALSE;
	    if(is_array($form['label'])) $form = $this->justCurrentLang($form);
	    return $form['label'];
	}
	/// ==== List Form data: End === ///
	
	/// ==== Export Form: Start === ///
	/**
	 * Export full form in another database.
	 *
	 * @param integer $form_id
	 * @param string $dbname
	 */
	public function exportFormToDb($form_id,$dbname)
	{
		$data = $this->getFormDataForExport($form_id);
		
		$this->importFormData($data,$dbname);
	}
	
	/**
	 * Export form to file "./[FORM_ID].form".
	 *
	 * @param integer $form_id
	 */
	public function exportFormToFile($form_id)
	{
	    $data = $this->getFormDataForExport($form_id);
	    
	    file_put_contents('./'.$form_id.'.form',serialize($data));
	}
	
	/**
	 * Import form from file "./[FORM_ID].form".
	 *
	 * @param integer $form_id
	 */
	public function importFormFromFile($form_id)
	{
	    $content = file_get_contents('./'.$form_id.'.form');
	    
	    if(!$content) die("Couldn't read file.");
	    
	    $data = unserialize($content);
	    
	    $this->importFormData($data);
	}
	
	/**
	 * Return form info and tree data for export.
	 *
	 * @param integer $form_id
	 * @return array
	 */
	private function getFormDataForExport($form_id)
	{
	    $this->CI->lang_gen_model->setReturnAllColumns(FALSE);
		$this->multilang_tree = TRUE;
		
		//get form's info
		$form = $this->initForm($form_id);
		unset($form['id'],$form['label_lang_id']);
		
		//get form's tree (containers,inputs)
		$tree = $this->getTree($form_id);
		
		return array('form'=>$form,'tree'=>$tree);
	}

    /**
     * Import form.
     *
     * @param array $data
     * @param bool|string $dbname
     */
	private function importFormData($data,$dbname=FALSE)
	{
	    if($dbname)
	    {
    	    //set use dbname for formbuilder and lang_gen models
    		$this->changeDbName($dbname);
    		$this->CI->lang_gen_model->changeDbName($dbname);
	    }
	    
	    $form = $data['form'];
	    $tree = $data['tree'];
		
		//check if form with already exists 
		if($this->getFormIdByHtmlId($form['html_id'])) die("Form with HTML id = '{$form['html_id']}' already exists.");
		
		//import form's info
		$form_id = $this->insertOrUpdateForm($form);
		//import form's tree
		$this->importTree($tree,$form_id);
	}
	
	/**
	 * Import form's tree.
	 *
	 * @param array $tree
	 * @param integer $form_id
	 * @param integer $container_id
	 */
	private function importTree(array $tree,$form_id,$container_id=0)
    {
    	foreach ($tree as $item)
    	{
    		$this->importItem($item,$form_id,$container_id);
    	}
    }
	
    /**
     * Import item (container or input).
     *
     * @param array $item
     * @param integer $form_id
	 * @param integer $container_id
     * @return integer|bool
     */
    private function importItem(array $item,$form_id,$container_id=0)
    {
    	unset($item['id'],$item['label_lang_id'],$item['content_lang_id']);
    		
		$item['form_id'] = $form_id;
		$item['container_id'] = $container_id;
		
		$type = $item['main_type'];
		
		switch ($type)
		{
			case "container":
				$sub_container_id = $this->insertOrUpdateContainer($item);
				
				if( isset($item['children']) )	$this->importTree($item['children'],$form_id,$sub_container_id);
				
				return $sub_container_id;
			break;
			case "input":
				//remove content field if type is not `content`
				if($item['type']!='content') unset($item['content']);
				
				//import answerset 
				if($item['answerset_id'] && isset($item['answerset']))
				{
					//check if answerset already exists
					if(
						($lang_gen_id = $this->lang_gen_model->exists($item['answerset']['label'],'form_answersets'))
						&&
						($answerset_id = $this->getAnswersetIdByLabelLangId($lang_gen_id))
					)
					{
						$item['answerset_id'] = $answerset_id;
					}
					else 
					{
						unset($item['answerset']['id'],$item['answerset']['label_lang_id']);
						
						//insert answerset
    					$item['answerset_id'] = $this->insertOrUpdateAnswerset($item['answerset']);
    					
						if(!$item['answerset']['generic_answers'])
						{
	    					foreach ($item['answerset_values'] as $answerset_value)
	    					{
	    						unset($answerset_value['id'],$answerset_value['label_lang_id']);
	    						
	    						$answerset_value['answerset_id'] = $item['answerset_id'];
	    						
	    						//insert answerset value
	    						$this->insertOrUpdateAnswersetValue($answerset_value);
	    					}
						}
					}
				}
				
				//import input
				return $this->insertOrUpdateInput($item);
			break;	
		}

        return TRUE;
    }
	
	/// ==== Export Form: End === ///
	
}