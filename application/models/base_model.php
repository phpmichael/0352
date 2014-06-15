<?php

/** 
 * This is base (abstract) model for most models.
 * 
 * @package base  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
abstract class Base_model extends CI_Model 
{
	//name of table
	protected $c_table;
	//name of primary field
	protected $id_column = 'id';
	//instance of CodeIgniter
	protected $CI;
	//multilang table
	protected $lang_gen_table = 'lang_gen';
	//don't select next multilang fields
	protected $skip_multilang_fields = array();
	//if model based on formbuilder
	protected $process_form_html_id = '';

    /**
     * Base model constructor.
     *
     * @return \Base_model
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->CI =& get_instance();
        
        //set form id equal table name (if didn't set another in model)
        if( $this->id_column=='data_key' && !$this->process_form_html_id ) $this->process_form_html_id = $this->c_table;
    }
    
    /**
     * Return table ID column name.
     *
     * @return string
     */
    public function getIdColumn()
    {
    	return $this->id_column;
    }

	/**
	 * Insert or update data. Depends if ID field presents in array.
	 * 
	 * @param array $post
	 * @return integer
	 */
	public function insertOrUpdate($post)
    {
    	//UPDATE
		if( @$post[$this->id_column] )
		{
			return $this->Update($post);
		}
		//ADD
		else 
		{
			return $this->Insert($post);
		}
    }
    
    /**
	 * Update data. Based on ID field. Returns ID field.
	 * 
	 * @param array $post
	 * @return integer
	 */
    public function Update($post)
    {
		$post = $this->updateMultilangFields($post);
        
        $post = $this->prepareTablePost($post);
    	
    	$this->db->update($this->c_table, $post, array($this->id_column => $post[$this->id_column]) );
		
    	return $post[$this->id_column];
    }
    
    /**
	 * Insert data. Returns ID field.
	 * 
	 * @param array $post
	 * @return integer
	 */
    public function Insert($post)
    {
		//if primary key is "data_key" string(16) need to generate it
        if( $this->id_column=='data_key' && ( !isset($post['data_key']) || !$post['data_key'] ) ) $post['data_key'] = $this->generateDataKey();
        
        $post = $this->addMultilangFields($post);
        
        $post = $this->prepareTablePost($post);
		
    	$this->db->insert($this->c_table, $post);
		
    	//if primary key is "data_key" string(16)
    	if( $this->id_column=='data_key' ) return $post['data_key'];
    	//if primary key is integer
    	else return $this->db->insert_id();
    }
    
    /**
	 * Generate unique key (ID) for store forms.
	 *
	 * @return string(16)
	 */
	protected function generateDataKey()
	{
	    return strtoupper(substr(md5(microtime()),0,16));
	}
    
    /**
	 * Delete record by ID.
	 * 
	 * @param integer|string(16) $id
	 * @return void
	 */
    public function DeleteId($id)
    {
        //remove form files 
    	if( $this->process_form_html_id ) $this->formbuilder_model->removeFiles($this->process_form_html_id,$id);
    	
    	$post = $this->getOneById($id);
    	
    	$this->deleteMultilangFields($post);
        
        $this->db->delete($this->c_table, array($this->id_column => $id));
    }
    
    /**
	 * Delete few records by IDs array.
	 * 
	 * @param array $delArr
	 * @return void
	 */
    public function DeleteSelected($delArr)
	{
		if( !empty($delArr) )
		{
			foreach ($delArr as $id=>$selected)
			{
				$this->DeleteId($id);
			}
		}
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
        return $this->formbuilder_model->storeForm($data,$form_id,$data_key);
    }
    
	/**
	 * Returns one record by ID.
	 * 
	 * @param integer|string(16) $id
	 * @return array
	 */
    public function getOneById($id)
    {
    	//for frontend select just current language
    	if($this->CI->_isJustCurrentLang())
    	{
    		//multilang stuff
    		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect());
			$this->_buildMultilangJoin(FALSE);
	    	
	    	return $this->db->get_where($this->c_table, array( "{$this->c_table}.{$this->id_column}" => $id ))->row_array();
    	}
    	else //for backend - select all language for edit
    	{
    		$post = $this->db->get_where($this->c_table, array( $this->id_column => $id ))->row_array();
    		
    		//multilang stuff
	    	$post = $this->getMultilangFields($post);
	    	//dump($post);exit;
	    	return $post;
    	}
    }

    /**
     * Check if record with $id exists.
     * @param integer|string(16) $id
     * @return bool
     */
    public function existsId($id)
    {
        return (bool)$this->db->get_where($this->c_table, array( $this->id_column => $id ))->row_array();
    }
    
    /**
	 * Returns one record by unique column and its value (like email and its value).
	 * 
	 * @param string $field_name
	 * @param string $field_value
	 * @return array
	 */
    public function getOneByUnique($field_name,$field_value)
    {
    	//multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect());
		$this->_buildMultilangJoin(FALSE);
        
        return $this->db->get_where($this->c_table, array($field_name => $field_value))->row_array();
    }
    
    /**
	 * Returns all records of table.
	 * 
	 * @return array
	 */
    public function getAll()
    {
    	//multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect());
		$this->_buildMultilangJoin(FALSE);
        
        return $this->db->get($this->c_table)->result_array();
    }
    
    /**
     * Return list of random records.
     *
     * @param integer $limit
     * @param array $whereArr
     * @return array
     */
    public function getRandom($limit = 1, array $whereArr = array())
    {
    	//multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect());
		$this->_buildMultilangJoin(FALSE);
    	
    	$this->db->order_by('RAND()');
    	
    	$records = $this->db->get_where($this->c_table,$whereArr,$limit)->result_array();
    	
    	//if need just 1 record - return just it
    	if(!empty($records) && $limit==1) return $records[0];
    	
    	return $records;
    }
    
    /**
	 * Check each key of array if according field exists in table. Used before add/update data in table.
	 * 
	 * @param array $post
	 * @return array
	 */
    protected function prepareTablePost($post)
    {
    	foreach ($post as $key => $value)
    	{
			if( !$this->db->field_exists($key, $this->c_table) ) unset($post[$key]);
		}
		return $post;
    }

    /**
     * Returns records from table by defined criterias.
     *
     * @param bool|string $where
     * @param bool|string $order_by
     * @param string $order_direction
     * @param bool|int $limit
     * @param integer $offset
     * @return array
     */
    public function get($where = false,$order_by = false,$order_direction = 'ASC',$limit = false,$offset = 0)
    {
    	/*if($where) $this->db->where($where);
    	if($order_by) $this->db->order_by($order_by, $order_direction);
    	if($limit) $this->db->limit($limit, $offset);
		
    	$records = $this->db->get($this->c_table)->result_array();
		
		return $records;*/
    	
    	if(!$where) $where = 1;
    	if(!$order_by) $order_by = $this->id_column;
    	if(!$limit) $limit = 9999;
    	if(!$offset) $offset = 0;
    	
    	$multilang_select = $this->_buildMultilangSelect();
		$multilang_join = $this->_buildMultilangJoin();

		return $this->db->query("SELECT {$this->c_table}.* $multilang_select FROM `".$this->c_table."` $multilang_join WHERE $where ORDER BY $order_by $order_direction LIMIT $offset,$limit")->result_array();
    }
    
    /**
	 * Returns count of all records in table.
	 * 
	 * @return integer
	 */
    public function countAll()
    {
    	return $this->db->count_all($this->c_table);
    }
    
    /**
     * Return count of records.
     *
     * @param array $whereArr
     * @return integer
     */
    protected function count($whereArr=array())
	{
		$this->db->select("COUNT(*) AS numrows");
		
		if(!empty($whereArr)) $this->db->where($whereArr );
		
		$result = $this->db->get($this->c_table)->row_array();
		
		return intval($result['numrows']);	
	}
    
    /**
     * This is help method for search by few criterias.
     * Used in articles, news, posts models.
     *
     * @param array $filter_data
     * @return array
     */
    protected function explodeFilter(array $filter_data=array())
    {
    	//remove page (offset) param
        if( isset($filter_data['page']) ) unset($filter_data['page']);
    	
        //remove empty params
    	foreach ($filter_data as $key=>$val) if( empty($val) ) unset($filter_data[$key]);
    	
    	$filter_ex = array();
    	
    	//offset positions
    	$filter_ex['offset_uri_segment'] = $this->CI->_getSegmentsOffset()+4+2*count($filter_data);
    	//offset values
    	$filter_ex['offset'] = $this->CI->uri->segment($filter_ex['offset_uri_segment'],0);
    	
    	foreach ($filter_data as &$val)
    	{
    		if( is_array($val) ) $val = "Array(".join(",",$val).")";//if param is array - convert to string (for checkboxes)
    		else $val = urlencode($val);
    	}
    	
    	//convert to URI string
    	$filter_ex['filter_str'] = $this->CI->uri->assoc_to_uri($filter_data);
    	
    	//if empty some param (like keywords) then in url // will be replaced on / and this makes incorrect string to array convert
    	//$filter_ex['filter_str'] = str_replace('//','/+/',$filter_ex['filter_str']);//+ is encoded spacer
    	
    	return $filter_ex;
    }

    /**
     * Filter posts by category.
     *
     * @return string
     */
    protected function getCategoryFilter()
    {
        if( is_array($this->CI->input->post('category',1)) )
        {
            $search_categories = array_reverse($this->CI->input->post('category',1));
            $search_category = reset($search_categories);
            if($search_category==-1) $search_category = next($search_categories);
        }
        else $search_category = intval($this->CI->input->post('category',1));

        return $search_category;
    }
    
    /**
	 * Make translit non-english chars.
	 * 
	 * @param string $value
	 * @return array
	 */
	protected function doTranslit($value)
	{
		// Chars Array
        $letters = array(
			"а" => "a", 
			"б" => "b", 
			"в" => "v", 
			"г" => "g", 
			"д" => "d", 
			"е" => "e",
			"ё" => "e", 
			"є" => "ye", 
			"ж" => "zh", 
			"з" => "z", 
			"и" => "i", 
			"і" => "i", 
			"ї" => "yi", 
			"й" => "j", 
			"к" => "k", 
			"л" => "l", 
			"м" => "m", 
			"н" => "n", 
			"о" => "o", 
			"п" => "p", 
			"р" => "r", 
			"с" => "s", 
			"т" => "t", 
			"у" => "u", 
			"ф" => "f", 
			"х" => "h", 
			"ц" => "c", 
			"ч" => "ch", 
			"ш" => "sh", 
			"щ" => "sh", 
			"ы" => "i", 
			"ь" => "", 
			"ъ" => "", 
			"э" => "e", 
			"ю" => "yu", 
			"я" => "ya",
			"А" => "A", 
			"Б" => "B", 
			"В" => "V", 
			"Г" => "G", 
			"Д" => "D", 
			"Е" => "E",
			"Ё" => "E", 
			"Є" => "E", 
			"Ж" => "ZH", 
			"З" => "Z", 
			"И" => "I", 
			"І" => "I", 
			"Ї" => "YI", 
			"Й" => "J", 
			"К" => "K", 
			"Л" => "L", 
			"М" => "M", 
			"Н" => "N", 
			"О" => "O", 
			"П" => "P", 
			"Р" => "R",
			"С" => "S", 
			"Т" => "T", 
			"У" => "U", 
			"Ф" => "F", 
			"Х" => "H", 
			"Ц" => "C", 
			"Ч" => "CH", 
			"Ш" => "SH", 
			"Щ" => "SH", 
			"Ы" => "I", 
			"Ь" => "", 
			"Ъ" => "", 
			"Э" => "E", 
			"Ю" => "YU", 
			"Я" => "YA",
            
			"À" => "A",
			"Á" => "A",
			"Â" => "A",
			"Ã" => "A",
			"Ä" => "A",
			"Å" => "A",
			"Æ" => "AE",
			"Ç" => "C",
			"È" => "E",
			"É" => "E",
			"Ê" => "E",
			"Ë" => "E",
			"Ì" => "I",
			"Í" => "I",
			"Î" => "I",
			"Ï" => "I",
			"Ð" => "D",
			"Ñ" => "N",
			"Ò" => "O",
			"Ó" => "O",
			"Ô" => "O",
			"Õ" => "O",
			"Ö" => "O",
			"×" => "x",
			"Ø" => "O",
			"Ù" => "U",
			"Ú" => "U",
			"Û" => "U",
			"Ü" => "U",
			"Ý" => "Y",
			"Þ" => "b",
			"ß" => "ss",
			"à" => "a",
			"á" => "a",
			"â" => "a",
			"ã" => "a",
			"ä" => "a",
			"å" => "a",
			"æ" => "ae",
			"ç" => "c", 
			"è" => "e", 
			"é" => "e", 
			"ê" => "e", 
			"ë" => "e", 
			"ì" => "i", 
			"í" => "i", 
			"î" => "i", 
			"ï" => "i", 
			"ð" => "o", 
			"ñ" => "n", 
			"ò" => "o", 
			"ó" => "o", 
			"ô" => "o", 
			"õ" => "o", 
			"ö" => "o", 
			"ø" => "o", 
			"ù" => "u", 
			"ú" => "u", 
			"û" => "u", 
			"ü" => "u", 
			"ý" => "y", 
			"þ" => "b", 
			"ÿ" => "y", 						        
	        "Ą" => "A",
	        "ą" => "a",
	        "Ć" => "C",
	        "ć" => "c",
	        "Ę" => "E",
	        "ę" => "e",
	        "Ł" => "L",
	        "ł" => "l",
	        "Ń" => "N",
	        "ń" => "n",
	        "Ś" => "S",
	        "ś" => "s",
	        "Ź" => "Z",
	        "ź" => "z",       
	        "Ż" => "Z",
	        "ż" => "z", 
	        
	        "ğ" => "g", 
	        "ş" => "s", 
	        "ı" => "i", 
		);
		
		foreach($letters as $letterVal => $letterKey) 
		{
			$value = str_replace($letterVal, $letterKey, $value);
		}
		
        return $value;
	}
	
	/**
	 * Generate slug for page.
	 * 
	 * @param string $value
	 * @param string $separator
	 * @return string
	 */
	public function doSlug($value,$separator = '-')
	{
		//translit for russian and ukrainian
        $value = $this->doTranslit($value);
        
        //use - instead of _
        if ($separator == '-')
		{
			$search		= '_';
			$replace	= '-';
		}
		else
		{
			$search		= '-';
			$replace	= '_';
		}
		
		$trans = array(
						$search								=> $replace,
						"\s+"								=> $replace,
						"[^a-z0-9".$replace."]"				=> '',
						$replace."+"						=> $replace,
						$replace."$"						=> '',
						"^".$replace						=> ''
					   );

		//lowercase links
		$value = strip_tags(strtolower($value));
	
		//just [a-z0-9-]
		foreach ($trans as $key => $val)
		{
			$value = preg_replace("#".$key."#", $val, $value);
		}
		
		//limit to 250 chars
		$value = substr($value,0,250);
	
		return $value;
	}
	
	/**
	 * Returns page (record) by slug. 
	 * 
	 * @param string $slug
	 * @return string
	 */
	public function getBySlug($slug)
	{
		if($this->db->field_exists('slug',$this->c_table)) return $this->getOneByUnique('slug',$slug);
		
		$lang = $this->CI->_getInterfaceLang(TRUE);
		$lang_data = $this->CI->lang_gen_model->getSlugMultiData($lang,$slug,$this->c_table);
		
		if(empty($lang_data)) return FALSE;
		
		$record = $this->getOneByUnique('slug_lang_id',$lang_data['id']);
		
		return $this->getOneById($record[$this->id_column]);
	}
	
	
	
	// === Multilang Stuff: Start === //
    /**
     * Add multilang data for fields like [field]_lang_id.
     *
     * @param array $post
     * @return array
     */
    protected function addMultilangFields($post)
    {
        foreach ($post as $key => $value)
    	{
			if( $this->db->field_exists($key.'_lang_id', $this->c_table) ) 
			{
			    $mData = $post[$key];
			    
			    $mData['table'] = $this->c_table;
			    
			    if($key=='slug') $mData['is_slug'] = 1;
			    
			    $post[$key.'_lang_id'] = $this->CI->lang_gen_model->addMultilang($mData);
			}
		}
		return $post;
    }
    
    /**
     * Update multilang data for fields like [field]_lang_id.
     *
     * @param array $post
     * @return array
     */
    protected function updateMultilangFields($post)
    {
        foreach ($post as $key => $value)
    	{
			if( $this->db->field_exists($key.'_lang_id', $this->c_table) && isset($post[$key.'_lang_id']) ) 
			{
			    $post[$key]['table'] = $this->c_table;//need just on the case if field was added later, after data added
			    $post[$key.'_lang_id'] = $this->CI->lang_gen_model->updateMultilang($post[$key],$post[$key.'_lang_id']);
			}
		}
		return $post;
    }
    
    /**
     * Return array with multilang data for fields like [field]_lang_id.
     * @todo replace sql for each field on one sql (ie wih UNION)
     *
     * @param array $post
     * @return array
     */
    protected function getMultilangFields($post)
    {   
        foreach ($post as $key => $value)
    	{
			if(preg_match("/^(\w+)_lang_id$/",$key,$match)) 
			{
			    $post[$match[1]] = $this->CI->lang_gen_model->getMultilangData($post[$key]);
			}
		}
		
		if($this->CI->_isJustCurrentLang()) $post = $this->justCurrentLang($post);
		
		return $post;
    }
    
    /**
     * Delete data from multilang table.
     *
     * @param array $post
     * @return void
     */
    protected function deleteMultilangFields($post)
    {   
        foreach ($post as $key => $value)
    	{
			if( $this->db->field_exists($key.'_lang_id', $this->c_table)) 
			{
			    $this->CI->lang_gen_model->DeleteId($post[$key.'_lang_id']);
			}
		}
    }
    
    /**
     * On website needs value of multilang field just for active lang (front).
     *
     * @param array $post
     * @return array
     */
    protected function justCurrentLang($post)
    {
        $lang = strtoupper($this->CI->_getInterfaceLang(TRUE));
        
        foreach ($post as $key => $value)
    	{
			if(preg_match("/^(\w+)_lang_id$/",$key,$match)) 
			{
			    $post[$match[1]] = $post[$match[1]][$lang];
			}
		}
		return $post;
    }
    
    /**
     * Return join for multilang fields. 
     *
     * @param bool $return
     * @return string
     */
    protected function _buildMultilangJoin($return=TRUE)
    {
        $fields = $this->db->list_fields($this->c_table);
        $join = '';
        
        foreach ($fields as $field)
        {
            if(preg_match("/^(\w+)_lang_id$/",$field,$match)) 
            {
                if(in_array($match[1],$this->skip_multilang_fields)) continue;
                
                $multilang_table = 'lang_gen_'.$match[1];
                
                //if($return) $join .= " JOIN {$this->lang_gen_table} AS {$multilang_table} ON {$multilang_table}.id = {$this->c_table}.{$field}";
                //else $this->db->join( "{$this->lang_gen_table} AS {$multilang_table}" , "{$multilang_table}.id = {$this->c_table}.{$field}" );
                
                //Maybe need set "LEFT JOIN" instead of "JOIN", because if add new multilang column list doesn't work
                if($return) $join .= " LEFT JOIN {$this->lang_gen_table} AS {$multilang_table} ON {$multilang_table}.id = {$this->c_table}.{$field}";
                else $this->db->join("{$this->lang_gen_table} AS {$multilang_table}" , "{$multilang_table}.id = {$this->c_table}.{$field}", 'left' );
            }
        }
		
		return $join;
    }
    
    /**
     * Return select multilang fields like "lang_gen_name.UA as name". 
     *
     * @return string
     */
    protected function _buildMultilangSelect()
    {
        $fields = $this->db->list_fields($this->c_table);
        $select = '';
        
        foreach ($fields as $field)
        {
            if(preg_match("/^(\w+)_lang_id$/",$field,$match)) 
            {
                if(in_array($match[1],$this->skip_multilang_fields)) continue;
                
                $multilang_table = 'lang_gen_'.$match[1];
                $lang = strtoupper($this->CI->_getInterfaceLang(TRUE));
                $select .= ",{$multilang_table}.{$lang} AS {$match[1]}";
            }
        }
		
		return $select;
    }
    
    /**
     * Replace field like "name" on "lang_gen_name.UA", where UA is current language. 
     * Allows search by multilang fields.
     *
     * @param string $field
     * @return string
     */
    protected function prepareFieldForSearch($field)
    {
        $field = $this->db->escape_str($field);
        
        if($this->db->field_exists($field,$this->c_table)) return $field;
        else 
        {
            $lang = strtoupper($this->CI->_getInterfaceLang(TRUE));
            return "{$this->lang_gen_table}_{$field}.{$lang}";
        }
    }
    
    /**
     * Return value just for current language instead of array.
     *
     * @param array $record
     * @param string $field
     * @return string
     */
    protected function getCurrentLangField($record,$field)
    {
    	if(is_array($record[$field])) return $record[$field][strtoupper($this->CI->_getInterfaceLang(TRUE))];
    	
    	return $record[$field];
    }
    
    // === Multilang Stuff: End === //
    
    
    // === Dashboard: Start === //
    /**
     * Generate widget for dashboard.
     *
     * @return string
     */
    public function dashboardWidget()
    {
    	//get controller by table name
    	switch ($this->c_table) 
    	{
    		case "quiz_list":
    			$controller = "quiz";
    		break;
    		
    		case "poll_list":
    			$controller = "poll";
    		break;
    		
    		default:
    			$controller = $this->c_table;
    		break;
    	}
    	
    	//just for next list of controllers
    	if(
    		!in_array($controller,
    			array(
	    			'auto_responders',
	    			'pages',
	    			'companies',
	    			'customers',
	    			'groups',
	    			'links',
	    			'articles',
	    			'news',
	    			'faq',
	    			'photos',
	    			'quiz',
	    			'poll',
	    			//'lang',
	    			'comments',
	    			'products',
	    			'orders',
	    			'currency',
	    			'testimonials',
	    			'subscribers',
	    			'videos',
	    			'assortment',
	    			'books'
	    			)
	    	)
    	) return FALSE;
    	
    	$content = "";
    	
    	$content .= "<p>";
    	$content .= anchor_base($controller, language($controller.'_amount'));
    	$content .= " - " . $this->countAll();
    	$content .= "</p>";
    	
    	//add amount of categories if category model exists
    	switch ($this->c_table) 
    	{
    		case "companies":
    			$categories_model_name = "categories";
    		break;
    		
    		case "news":
    		case "articles":
    			$categories_model_name = "articles_categories";
    		break;
    		
    		case "products":
    			$categories_model_name = "products_categories";
    		break;
    		
    		case "photos":
    			$categories_model_name = "photos_categories";
    		break;
    		
    		default:
    			$categories_model_name = FALSE;
    		break;
    	}
    	
    	if($categories_model_name && userAccess($categories_model_name,'view')) 
    	{
    		$categories_model = load_model($categories_model_name."_model");
    		
    		$content .= "<p>";
	    	$content .= anchor_base($categories_model_name, language('categories_amount'));
	    	$content .= " - " . $categories_model->countAll();
	    	$content .= "</p>";
    	}
    	
    	$widget['title'] = language($this->c_table);
    	$widget['content'] = $content;
    	
    	return $widget;
    }
    // === Dashboard: End === //
    
    // === Sortables: Start === //
    /**
	 * Sort records.
	 * 
	 * @param array $sortables
	 * @param array $whereArr
	 * @return void
	 */
	public function Sort(array $sortables, array $whereArr = array())
	{
		$this->db->order_by('sort','asc');
		$records = $this->db->get_where($this->c_table,$whereArr)->result_array();
		
		foreach ($sortables as $sort=>$val)
		{
			$records[$val]['sort'] = $sort;

			$this->Update($records[$val]);
		}
	}
	
	/**
	 * Reset Sorting (after record deleted).
	 * 
	 * @param array $whereArr
	 * @return void
	 */
	protected function reset_sort(array $whereArr=array())
	{
		$this->db->order_by('sort','asc');
		$records = $this->db->get_where($this->c_table, $whereArr)->result_array();

		// reset menu sort order
		$i = 0;
		foreach ($records as $val)
		{
			$val['sort'] = $i;
			$i++;

			// === Update in DB === //
			$this->Update($val);
		}
	}
	
	/**
	 * Generate value for sort column.
	 * 
	 * @param array $whereArr
	 * @return integer
	 */
	protected function last_sort_val(array $whereArr=array())
	{	
		$this->db->order_by('sort','desc');
		$lastRow = $this->db->get_where($this->c_table, $whereArr, 1)->row_array();
		
		if(!empty($lastRow)) 
		{
			return ($lastRow['sort']+1);
		}
		
		return 0;
	}
    // === Sortables: End === //
    
    /**
     * Change database name. (ie used for export forms)
     *
     * @param string $dbname
     */
    protected function changeDbName($dbname)
    {
    	$params = $this->getDbConfig();

		$params['database'] = $dbname;
		$params['pconnect'] = FALSE;
		$params['autoinit'] = FALSE;
    	
    	$this->db = $this->load->database( $params , TRUE );
    }

    /**
     * Change DB driver (ie used mysql drive for backup db)
     * @param string $driver
     */
    protected function changeDbDriver($driver)
    {
        $params = $this->getDbConfig();

        $params['dbdriver'] = $driver;
        $params['pconnect'] = FALSE;
        $params['autoinit'] = FALSE;

        $CI =& get_instance();

        $CI->db = $this->load->database( $params , TRUE );
    }

    /**
     * Return database config as array.
     * @return array
     */
    private function getDbConfig()
    {
        $params['hostname'] = $this->db->hostname;
        $params['username'] = $this->db->username;
        $params['password'] = $this->db->password;
        $params['database'] = $this->db->database;
        $params['dbdriver'] = $this->db->dbdriver;
        $params['dbprefix'] = $this->db->dbprefix;
        $params['pconnect'] = $this->db->pconnect;
        $params['db_debug'] = $this->db->db_debug;
        $params['cache_on'] = $this->db->cache_on;
        $params['cachedir'] = $this->db->cachedir;
        $params['char_set'] = $this->db->char_set;
        $params['dbcollat'] = $this->db->dbcollat;
        $params['swap_pre'] = $this->db->swap_pre;
        $params['autoinit'] = $this->db->autoinit;
        $params['stricton'] = $this->db->stricton;

        return $params;
    }
    
}