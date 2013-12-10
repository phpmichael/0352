<?php
require_once(APPPATH.'models/posts_model.php');

/** 
 * This is models for products table.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Products_model extends Posts_model
{
	//name of table
	protected $c_table = 'products';
	//name of type
	protected $c_type = "product";
    //name of tags table
	protected $tags_table = "tags";
	//name of manufacturers table
	protected $manufacturers_table = "products_manufacturers";
	//name of categories table
	protected $categories_list_table = 'products_categories_list';
	
	//dir for medium images
	protected $medium_dir = "m/";
	
	/**
	 * Init additional models.
	 *
	 */
	public function __construct()
    {
        parent::__construct();
        
        $this->CI->load->model('products_manufacturers_model');
        $this->CI->load->model('products_attributes_model');
        $this->CI->load->model('discounts_model');
        $this->CI->load->model('discount_coupons_model');
        $this->CI->load->model('shipping_model');
    }

    /**
     * Returns one record by ID.
     * Overrides parent method.
     *
     * @param int $product_id
     * @return array
     */
    public function getOneById($product_id)
    {
    	$product = parent::getOneById($product_id);
    	if(!$product) return false;
    	
    	$product['manufacturer'] = $this->CI->products_manufacturers_model->getManyfacturerName($product['manufacturer_id']);
    	
    	$product['attributes_list'] = $this->CI->products_attributes_model->getProductAttributesWithValues($product_id);
    	
    	return $product;
    }
    
    /**
     * Return old_price of product (for special product)
     *
     * @param integer $product_id
     * @return float
     */
    public function getOldPrice($product_id)
    {
    	$product = $this->db->get_where($this->c_table, array( $this->id_column => $product_id ))->row_array();
    	if(empty($product)) return FALSE;
    	return $product['old_price'];
    }
    
    /**
	 * Insert or update data. Depends if ID field presents in array.
	 * Overrides parent method.
	 * 
	 * @param array $post
	 * @param array $categories
	 * @return integer
	 */
    public function insertOrUpdate($post,$categories)
    {
    	$product_id = parent::insertOrUpdate($post,$categories);
    	
    	//set attributes
    	if(isset($post['products_attributes'])) $this->CI->products_attributes_model->setProductAttributes($product_id,$post['products_attributes']);
    	
    	return $product_id;
    }
	
	/**
	 * Make array of search/sort criterias.
	 * 
	 * @return array
	 */
    public function getFilterData()
    {
    	//category filter
		$filter_data['category'] = $this->getCategoryFilter();
		
		//standard filters
		$filter_data['display_style'] = $this->CI->input->post('display_style',1);
		$filter_data['keywords'] = $this->CI->input->post('keywords',1);
		$filter_data['keywords'] = urlencode($filter_data['keywords']);
		$filter_data['tag'] = $this->CI->input->post('tag',1);
		$filter_data['tag'] = urlencode($filter_data['tag']);
		$filter_data['manufacturer'] = $this->CI->input->post('manufacturer',1);
		$filter_data['manufacturer'] = urlencode($filter_data['manufacturer']);
		$filter_data['sort_by'] = $this->CI->input->post('sort_by',1);
		$filter_data['sort_order'] = $this->CI->input->post('sort_order',1);
		$filter_data['per_page'] = $this->CI->input->post('per_page',1);
		
		//set default values for filters - requires for pagination
		if(!in_array($filter_data['display_style'],array('list','grid'))) $filter_data['display_style'] = 'list';
		if(!$filter_data['category']) $filter_data['category'] = 0;
		if(!$filter_data['per_page']) $filter_data['per_page'] = $this->per_page;
		
		if(!$filter_data['sort_by']) $filter_data['sort_by'] = 'pub_date';
		if(!$filter_data['sort_order']) $filter_data['sort_order'] = 'desc';
			
		//Request from Pagination
		$filter_data = $this->paginationFilter($filter_data);
		
		return $filter_data;
    }
    
    /**
	 * Make sql join criterias based on $filter_data.
	 * 
	 * @param $filter_data
	 * @return string
	 */
    protected function _buildJoin(array $filter_data=array())
    {
    	$join = parent::_buildJoin($filter_data);
    	
    	//filter by manufacturer
		if( (isset($filter_data['manufacturer']) && ($manufacturer = $this->CI->security->xss_clean(trim(urldecode($filter_data['manufacturer']))))) )
		{
			$join .= " JOIN {$this->manufacturers_table} ON {$this->manufacturers_table}.id = {$this->c_table}.manufacturer_id";
		}
		
		return $join;
    }
	
	/**
	 * Make sql criterias based on $filter_data.
	 * 
	 * @param $filter_data
	 * @return string
	 */
    protected function _buildWhere(array $filter_data = array())
    {
        $CI =& get_instance();
        
        $where = ($CI->settings_model['show_just_products_in_stock']) ? "in_stock='1'" : "1";
    	
    	if( isset($filter_data['category']) && $filter_data['category'] )
		{
			$where .= " AND {$this->posts_categories_table}.category_id=".intval($filter_data['category']);
		}
		if( isset($filter_data['keywords']) && ($keywords = $this->CI->security->xss_clean(trim(urldecode($filter_data['keywords'])))) )
		{
			$where .= " AND CONCAT(".$this->prepareFieldForSearch('name').",".$this->prepareFieldForSearch('description').") LIKE '%".$this->db->escape_str($keywords)."%'";
		}
		if(isset($filter_data['month']) && preg_match("/^\d{4}(-\d{2})?(-\d{2})?$/",$filter_data['month']))
    	{
    		$where .= " AND `date` LIKE '".$filter_data['month']."%'";
    	}
    	//filter by tag
		if( isset($filter_data['tag']) && ($tag = $this->CI->security->xss_clean(trim(urldecode($filter_data['tag'])))) )
		{
		    $where .= " AND {$this->tags_table}.table='{$this->c_table}' AND {$this->tags_table}.tag='".$this->db->escape_str($tag)."'";
		}
		//filter by manufacturer
		if( isset($filter_data['manufacturer']) && ($manufacturer = $this->CI->security->xss_clean(trim(urldecode($filter_data['manufacturer'])))) )
		{
		    $where .= " AND {$this->manufacturers_table}.name='".$this->db->escape_str($manufacturer)."'";
		}
		//filter by tags comma separated
		if( isset($filter_data['tags']) && ($tags = $this->CI->security->xss_clean(trim(urldecode($filter_data['tags'])))) )
		{
		    $tagsArr = explode(",",$tags);
		    
		    foreach ($tagsArr as $tag_key=>$tag)
		    {
		        $tag = $this->db->escape_str(trim($tag));
		        if(empty($tag)) unset($tagsArr[$tag_key]);
		        else $tagsArr[$tag_key] = $tag;
		    }
		    
		    $where .= " AND {$this->tags_table}.table='{$this->c_table}' AND {$this->tags_table}.tag IN ('".join("','",$tagsArr)."')";
		}
		//just featured products
		if( isset($filter_data['featured']) && $filter_data['featured'] )
		{
			$where .= " AND featured='1'";
		}
		//just specials products
		if( isset($filter_data['specials']) && $filter_data['specials'] )
		{
			$where .= " AND old_price>0";
		}
		//exclude some IDs
		if( isset($filter_data['exclude_ids']) && $filter_data['exclude_ids'] )
		{
			$filter_data['exclude_ids'] = array_map(array($this->db,'escape_str'),explode(',',$filter_data['exclude_ids']));
			
			$where .= " AND {$this->c_table}.{$this->id_column} NOT IN ('".join(',',$filter_data['exclude_ids'])."')";
		}
        	
		return $where;
    }
    
    /**
     * Return product's name by ID.
     *
     * @param integer $product_id
     * @return string|bool
     */
    public function getNameById($product_id)
    {
        /*$product = $this->getOneById($product_id);
        if (!$product) return FALSE;
        return parent::getCurrentLangField($product,'name');*/
        
        if(!$this->db->field_exists('name',$this->c_table))
        {
	        //multilang stuff
	    	$this->db->select($this->c_table.'.name_lang_id '.$this->_buildMultilangSelect());
			$this->_buildMultilangJoin(FALSE);
        }
	    	
	    $product = $this->db->get_where($this->c_table, array( "{$this->c_table}.{$this->id_column}" => $product_id ))->row_array();
	    
	    if (!$product) return FALSE;
	    
	    return $product['name'];
    }
    
    /**
     * Update prices for all products.
     *
     * @param string $sign +/-
     * @param float $value
     * @param string $type %/money
     * @return bool
     */
    public function wholePricesUpdate($sign,$value,$type)
    {
        if(empty($value)) return FALSE;
        
        $records = $this->getAll();
        
        foreach ($records as $record)
        {
            if($type=='money')
            {
                if($sign=='-')
                {
                    $record['price'] -= $value;
                }
                else 
                {
                    $record['price'] += $value;
                }
            } 
            else 
            {
                if($sign=='-')
                {
                    $record['price'] = $record['price'] - ($record['price']*$value/100);
                }
                else 
                {
                    $record['price'] = $record['price'] + ($record['price']*$value/100);
                }
            }
            
            $price = round($record['price'],2);
            
            $this->db->update($this->c_table, array('price'=>$price), array($this->id_column => $record[$this->id_column]) );
        }
        
        return TRUE;
    }
    
    /**
	 * Delete products by ID (and remove it from wishlists).
	 * 
	 * @param integer $product_id
	 * @return void
	 */
    public function DeleteId($product_id)
    {
    	//remove products from wishlists
    	$wishlist_model = load_model('wishlist_model');
    	$wishlist_model->deleteProductFromWishlists($product_id);
    	
    	//delete post
    	parent::DeleteId($product_id);
    }
    
    /**
	 * Set for each product available in stock or no.
	 * 
	 * @param array $arr
	 * @param integer $availability
	 * @return void
	 */
    private function changeStokeAvailability($arr,$availability)
	{
		if( !empty($arr) )
		{
			foreach ($arr as $id=>$selected)
			{
				$this->db->update($this->c_table, array('in_stock'=>$availability), array($this->id_column => $id) );
			}
		}
	}
	
	/**
	 * Set for each product available in stock.
	 *
	 * @param array $arr
	 * @return void
	 */
	public function setInStock($arr)
	{
	    $this->changeStokeAvailability($arr,1);
	}
	
	/**
	 * Set for each product not available in stock.
	 *
	 * @param array $arr
	 * @return void
	 */
	public function setNotInStock($arr)
	{
	    $this->changeStokeAvailability($arr,0);
	}
	
	/**
	 * Set/unset featured fetured products.
	 * 
	 * @param array $arr
	 * @param integer $featured
	 * @return void
	 */
    private function changeFeatured($arr,$featured)
	{
		if( !empty($arr) )
		{
			foreach ($arr as $id=>$selected)
			{
				$this->db->update($this->c_table, array('featured'=>$featured), array($this->id_column => $id) );
			}
		}
	}
	
	/**
	 * Set for each product featured.
	 *
	 * @param array $arr
	 * @return void
	 */
	public function setFeatured($arr)
	{
	    $this->changeFeatured($arr,1);
	}
	
	/**
	 * Set for each product not featured.
	 *
	 * @param array $arr
	 * @return void
	 */
	public function setNotFeatured($arr)
	{
	    $this->changeFeatured($arr,0);
	}
	
	/**
     * Return list of featured products.
     *
     * @param integer $limit
     * @return array
     */
    public function getFeatured($limit)
    {
    	$filter_data = array('featured'=>1,'per_page'=>$limit,'sort_by'=>'RAND()','sort_order'=>'ASC','offset'=>0);
    	
    	return $this->get('index',$filter_data);
    }
	
    /**
     * Return list of special products.
     *
     * @param integer $limit
     * @return array
     */
    public function getSpecials($limit)
    {
    	$filter_data = array('specials'=>1,'per_page'=>$limit,'sort_by'=>'RAND()','sort_order'=>'ASC','offset'=>0);
    	
    	return $this->get('index',$filter_data);
    }
    
    /**
     * Return records with tags like current record has.
     *
     * @param integer $post_id
     * @param integer $limit
     * @return array
     */
    public function getSimilarByTags($post_id,$limit)
    {
    	$tags = $this->CI->tags_model->getPostTagsStr($this->c_table,$post_id);
		return $this->getWithOneOfTags($tags,$limit,$post_id);
    }
    
    /**
     * Return list with at least one of the tags.
     *
     * @param string $tags (separated by comma)
     * @param integer $limit
     * @param string $exclude_ids (separated by comma)
     * @return array
     */
    public function getWithOneOfTags($tags,$limit,$exclude_ids='')
    {
        $filter_data = array('tags'=>$tags,'exclude_ids'=>$exclude_ids,'per_page'=>$limit,'sort_by'=>'RAND()','sort_order'=>'ASC','offset'=>0);
    	
    	return $this->get('index',$filter_data);
    }
    
    // === Dashboard: Start === //
    /**
     * Generate widget for dashboard.
     *
     * @return string
     */
    public function dashboardWidget()
    {
        $widget = parent::dashboardWidget();
    	
    	$widget['content'] .= "
    	<p>
    		".$this->CI->filters_model->filterAnchorByCode('products_in_stock',language('amount_of_in_stock'),$this->c_table,'index',$this->id_column)." - ".$this->count(array('in_stock'=>1))."
    	</p>
    	<p>
    		".$this->CI->filters_model->filterAnchorByCode('featured_products',language('amount_of_featured'),$this->c_table,'index',$this->id_column)." - ".$this->count(array('featured'=>1))."
    	</p>
    	<p>
    		".$this->CI->filters_model->filterAnchorByCode('special_offers_products',language('amount_of_specials'),$this->c_table,'index',$this->id_column)." - ".$this->count(array('old_price > '=>0.00))."
    	</p>
    	";
    	
    	return $widget;
    }
    // === Dashboard: End === //
}