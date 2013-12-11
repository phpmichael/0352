<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for products attributes.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Products_attributes_model extends Base_model
{
	//name of table
	protected $c_table = 'products_available_attributes';
	
	private $tables = array(
		'attributes' => 'products_available_attributes',
		'attributes_values' => 'products_available_attributes_values',
		'products_attributes' => 'products_attributes',
	);
	
	
    /**
	 * Returns records from table.
	 * 
	 * @return array
	 */
	private function getAvailableAttributes()
	{
		$this->c_table = $this->tables['attributes'];
		
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect());
		$this->_buildMultilangJoin(FALSE);
		
		$this->db->order_by('name');
	    return $this->db->get('products_available_attributes')->result_array();
	}
	
	/**
	 * Returns attributes list. In format id=>name.
	 * 
	 * @return array
	 */
	public function getAvailableAttributesList()
	{
		$records = $this->getAvailableAttributes();
	   
		return multi2singleArray('id','name',$records);
	}
	
	/**
	 * Returns values for attribute.
	 * 
	 * @param integer $attr_id
	 * @return array
	 */
	public function getAvailableValues($attr_id)
	{
		$this->c_table = $this->tables['attributes_values'];
		
		//multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect());
		$this->_buildMultilangJoin(FALSE);
		
		$records = $this->db->get_where($this->c_table,array('attr_id'=>$attr_id))->result_array();
		
		return $records;
	}
	
	/**
	 * Returns values list for attribute. In format id=>value.
	 * 
	 * @param integer $attr_id
	 * @return array
	 */
	public function getAvailableValuesList($attr_id)
	{
		$records = $this->getAvailableValues($attr_id);
		
		return multi2singleArray('id','value',$records);
	}
	
	/**
	 * Returns product's attribute values.
	 * 
	 * @param integer $product_id
	 * @param integer $attr_id
	 * @return array
	 */
	private function getProductAttributeValues($product_id,$attr_id)
	{
		$this->c_table = $this->tables['attributes_values'];
		
		//multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect());
		$this->_buildMultilangJoin(FALSE);
		
		$this->db->join( "{$this->tables['products_attributes']} AS pa" , "pa.value_id = {$this->c_table}.id" );
		
		$this->db->order_by($this->c_table.'.id');
		
		$records = $this->db->get_where($this->c_table,array('pa.attr_id'=>$attr_id,'pa.product_id'=>$product_id))->result_array();
		
		return $records;
	}
	
	/**
	 * Returns values list for attribute. In format id=>value.
	 * 
	 * @param integer $product_id
	 * @param integer $attr_id
	 * @return array
	 */
	public function getProductAttributeValuesList($product_id,$attr_id)
	{
		$records = $this->getProductAttributeValues($product_id,$attr_id);
		
		return multi2singleArray('id','value',$records);
	}
	
	/**
	 * Returns attribute record by ID.
	 * 
	 * @param integer $id
	 * @return array
	 */
	private function getAttributeById($id)
	{
		$this->c_table = $this->tables['attributes'];
		
		return $this->getOneById($id);
	}
	
	/**
	 * Return attribute name by ID.
	 *
	 * @param integer $id
	 * @return string
	 */
	public function getAttributeNameById($id)
	{
		$attribute = $this->getAttributeById($id);
		
		return parent::getCurrentLangField($attribute,'name');
	}
	
	/**
	 * Returns attribute's value record by ID.
	 * 
	 * @param integer $id
	 * @return array
	 */
	public function getValueById($id)
	{
		$this->c_table = $this->tables['attributes_values'];
		
		return $this->getOneById($id);
	}
	
	/**
	 * Return value text by ID.
	 *
	 * @param integer $id
	 * @return string
	 */
	public function getValueTextById($id)
	{
		$value = $this->getValueById($id);
		
		return parent::getCurrentLangField($value,'value');
	}
	
	/**
	 * Insert or update attribute's value. Depends if ID field is set.
	 * 
	 * @param array $post
	 * @return void
	 */
	public function insertOrUpdateValue($post)
	{
		$this->c_table = $this->tables['attributes_values'];
		
		parent::insertOrUpdate($post);
	}
	
	/**
	 * Delete attributes by IDs.
	 * 
	 * @param array $delArr
	 * @return void
	 */
	public function DeleteSelectedAttributes($delArr)
	{
		if( !empty($delArr) )
		{
			foreach ($delArr as $id=>$selected)
			{
				//delete values (with multilang data)
				$values = $this->getAvailableValues($id);
				$this->c_table = $this->tables['attributes_values'];
				foreach ($values as $value)
				{
					$this->DeleteId($value['id']);
				}
				$this->c_table = $this->tables['attributes'];
				
				//delete from products_values
				$this->db->delete($this->tables['products_attributes'], array('attr_id' => $id));
				
				//delete attribute (with multilang data)
				$this->c_table = $this->tables['attributes'];
				$this->DeleteId($id);
			}
		}
	}
	
	/**
	 * Delete attribute's values by IDs.
	 * 
	 * @param array $delArr
	 * @return void
	 */
	public function DeleteSelectedValues($delArr)
	{
		if( !empty($delArr) )
		{
			$this->c_table = $this->tables['attributes_values'];
		    
		    foreach ($delArr as $id=>$selected)
			{
				$this->DeleteId($id);
				
				//delete from products_values
				$this->db->delete($this->tables['products_attributes'], array('value_id' => $id));
			}
		}
	}
	
	/**
	 * Return product's attributes with values.
	 *
	 * @param integer $product_id
	 * @return array
	 */
	public function getProductAttributesWithValues($product_id)
	{
		if(!$this->db->table_exists($this->tables['attributes'])) return array();
		
		$this->c_table = $this->tables['attributes'];
		
		$multilang_join = $this->_buildMultilangJoin();
    	$multilang_select = $this->_buildMultilangSelect();
	    
	    $sql = "
	    SELECT {$this->tables['attributes']}.id {$multilang_select} FROM {$this->tables['products_attributes']} 
	    JOIN {$this->tables['attributes']} ON {$this->tables['products_attributes']}.attr_id={$this->tables['attributes']}.id
	    {$multilang_join}
	    WHERE {$this->tables['products_attributes']}.product_id = ?
	    GROUP BY {$this->tables['attributes']}.id
	    ORDER BY {$this->tables['attributes']}.id";
	    
	    $records = $this->db->query($sql,array($product_id))->result_array();
	    //dump($this->db->last_query());exit;
	    $list = array();
	    foreach ($records as $record)
	    {
	        $list[$record['id']]['name'] = $record['name'];
	        $list[$record['id']]['values'] = $this->getProductAttributeValuesList($product_id,$record['id']);
	    }
	    //dump($list);exit;
	    return $list;
	}
	
	/**
	 * Set attributes for product.
	 *
	 * @param integer $product_id
	 * @param array $attributes
	 * @return void
	 */
	public function setProductAttributes($product_id,$attributes)
	{
		//delete current product's attributes
		$this->db->delete($this->tables['products_attributes'], array('product_id' => $product_id));
		
		//add new attributes
		$this->c_table = $this->tables['products_attributes'];
		
		foreach ($attributes as $attr_id=>$values)
		{
			foreach ($values as $value_id)
			{
				parent::insert(array('product_id'=>$product_id,'attr_id'=>$attr_id,'value_id'=>$value_id));
			}
		}
	}
}