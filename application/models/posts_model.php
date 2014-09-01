<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is base (abstract) model for posters, jobs, companies models.
 * 
 * @package messageboard  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
abstract class Posts_model extends Base_model
{
	//name of table
    protected $c_table;
    //name of post type
	protected $c_type;
	//name of categories table
	protected $categories_list_table = 'categories_list';
	//name of table where stored categories for each post
	protected $posts_categories_table = 'posts_categories';
	
	protected $customers_table = "customers";
	
	protected $with_customer_info = FALSE;
	
	//dir for upload images
	protected $upload_path = './images/data/';
	//dir for big images
	protected $big_dir = "b/";
	//dir for medium images
	protected $medium_dir = FALSE;
	//dir for small (thumbnails) images
	protected $small_dir = "s/";
	//images sizes
	protected $big_width = 500;
	protected $big_height = 500;
	protected $medium_width = FALSE;
	protected $medium_height = FALSE;
	protected $small_width = 100;
	protected $small_height = 75;
	//pagination
	protected $per_page = 10;

    protected $tags_table = 'tags';
	
	/**
	 * Init settings: read form table.
	 *
	 */
	public function __construct()
    {
        parent::__construct();
        
        $settings = $this->CI->settings_model;
        
        foreach ($settings->toArray() as $param=>$value)
        {
            if( preg_match("/^{$this->c_table}_(\w+)/",$param,$match) && isset($this->$match[1]) ) 
            {
                $this->$match[1] = $settings[$param];
            }
        }
    }
    
    /**
	 * Insert or update data. Depends if ID field presents in array.
	 * Overrides parent method.
	 * 
	 * @param array $post
	 * @param array|bool $categories
	 * @return integer
	 */
    public function insertOrUpdate($post,$categories=FALSE)
    {
    	//UPDATE
		if( @$post[$this->id_column] )
		{
			return $this->Update($post,$categories);
		}
		//ADD
		else 
		{
			return $this->Insert($post,$categories);
		}
    }
    
    /**
	 * Request from pagination.
	 * 
	 * @param array $filter_data
	 * @return array
	 */
    protected function paginationFilter($filter_data)
    {
    	if( !$this->input->post() ) 
    	{
			$query_arr = $this->CI->uri->uri_to_assoc($this->CI->_getSegmentsOffset()+3);
			
			//If first search
			if(empty($query_arr)) $query_arr['empty_filter'] = TRUE;
			else 
			{
				foreach ($query_arr as &$val)
				{
					$val = urldecode($val);
					$val = strtr($val,array("&#40;"=>"(","&#41;"=>")"));//&#40; equal "(", &#41; equal ")"
					if(preg_match("/^Array\((.*)\)$/U",$val)) //if is Array
					{
						$val = preg_replace("/^Array\((.*)\)$/U","\\1",$val);
						$val = explode(",",$val);
					}
				}
			}
			
			$filter_data = array_merge($filter_data, $query_arr);
		}
		
		return $filter_data;
    }
    
    /**
	 * Make array of search/sort criterias.
	 * 
	 * @return array
	 */
    public function getFilterData()
    {
		$filter_data = $this->CI->input->post(NULL,TRUE);
		
    	if( isset($filter_data['keywords']) ) $filter_data['keywords'] = urlencode($filter_data['keywords']);
		
		//set default values for filters - requires for pagination
		if( !@$filter_data['sort_by'] ) $filter_data['sort_by'] = 'pub_date';
		if( !@$filter_data['sort_order'] ) $filter_data['sort_order'] = 'desc';
			
		//Request from Pagination
		$filter_data = $this->paginationFilter($filter_data);
		
		return $filter_data;
    }
    
    /**
	 * Returns posts by filters and pagination links.
	 * 
	 * @param string $action
	 * @param array $filter_data
	 * @return array
	 */
    public function get($action="index", $filter_data = array())
    {
    	$filter_ex = $this->explodeFilter($filter_data);
    	
    	//protect from mysql injection
    	$offset = (isset($filter_data['offset'])) ? intval($filter_data['offset']):  intval($filter_ex['offset']);
    	$per_page = (intval(@$filter_data['per_page'])) ? intval($filter_data['per_page']) : $this->per_page;
    	
    	$this->skip_multilang_fields = array('meta_keywords','meta_description');
    	$multilang_join = $this->_buildMultilangJoin();
    	$multilang_select = $this->_buildMultilangSelect();
    	$this->skip_multilang_fields = array();

    	$customer_select = $this->_buildCustomerSelect($filter_data);
    	$where = $this->_buildWhere($filter_data);
    	$join = $this->_buildJoin($filter_data).' '.$multilang_join;
    	$order_by = $this->_buildOrderBy($filter_data);
    	
    	$select = "DISTINCT {$this->c_table}.{$this->id_column} {$multilang_select} {$customer_select}";
    	$sql = "SELECT {$select} FROM `{$this->c_table}` {$join} WHERE {$where}";
    	
		// Count rows
		$data['total_rows'] = $total_rows = $this->db->query($sql)->num_rows(); 
		
		$select = "DISTINCT {$this->c_table}.* {$multilang_select} {$customer_select}";
    	$sql = "SELECT {$select} FROM `{$this->c_table}` {$join} WHERE {$where} {$order_by} LIMIT {$offset},{$per_page}";
		
		//get data
		$query = $this->db->query($sql);
		
		if( $query->num_rows()>0 ) $data['posts_list'] = $query->result();
		else $data['posts_list'] = false;
		
		if($action)
        {
            $data['paginate'] = $this->createPaginationLinks($action, $filter_ex, $total_rows, $per_page);
        }

		return $data;
	}
    
	/**
	 * Returns one record by ID.
	 * Overrides parent method.
	 * 
	 * @param integer $post_id
	 * @return array
	 */
    public function getOneById($post_id)
    {
    	$post = parent::getOneById($post_id);
    	if(!$post) return false;
    	
    	$post['post_categories'] = $this->_getPostCategories($post_id);
    	$post['post_category'] = $this->_getPostCategory($post['post_categories']);
    	
    	//additional images
    	$post['additional_images'] = $this->getAdditionalImages($post_id);
    	
    	//add ratings
    	$ratings_model = load_model('ratings_model');
    	$post['rating'] = $ratings_model->getRating($this->c_table,$post[$this->id_column]);
    	$post['already_rated'] = $ratings_model->alreadyRated($this->c_table,$post[$this->id_column]);
    	
    	return $post;
    }
    
    /**
	 * Returns post's categories.
	 * 
	 * @param integer $post_id
	 * @return array
	 */
    protected function _getPostCategories($post_id)
    {
    	if(!$this->db->table_exists($this->categories_list_table))
        {
            return array();
        }

        $post_id = $this->db->escape($post_id);
    	$post_categories = array();
    	
    	if($post_id)
    	{
	    	//multilang stuff
	    	$c_table = $this->c_table;
	    	$this->c_table = $this->categories_list_table;
	    	$multilang_join = $this->_buildMultilangJoin();
	    	$multilang_select = $this->_buildMultilangSelect();
	    	$this->c_table = $c_table; 
	    	
	    	$sql = "
	    	SELECT {$this->posts_categories_table}.* , {$this->categories_list_table}.parent_id
	    	{$multilang_select} 
	    	FROM {$this->posts_categories_table} 
	    	JOIN {$this->categories_list_table} ON {$this->categories_list_table}.id={$this->posts_categories_table}.category_id 
	    	{$multilang_join} 
	    	WHERE {$this->posts_categories_table}.post_id={$post_id} AND {$this->posts_categories_table}.type='{$this->c_type}'
	    	ORDER BY {$this->posts_categories_table}.id";
	    	//dump($sql);exit;
	    	$result = $this->db->query($sql)->result_array();
	    	//dump($result);exit;
	    	if(!empty($result))
	    	{
		    	foreach ($result as $val)
		    	{
		    		if(isset($val['category'])) $post_categories[$val['category_id']] = $val['category'];
		    	}
	    	}
    	}
    	
    	return $post_categories;
    }
    
    /**
	 * Returns last (main) post category.
	 * 
	 * @param array $post_categories
	 * @return string
	 */
    protected function _getPostCategory($post_categories)
    {
    	return reset( array_reverse( array_keys($post_categories) ) );
    }
    
    /**
     * Build where string like AND (table.field like '%string1%' OR table.field like '%string2%' OR ...).
     *
     * @param string $field
     * @param array $values_array
     * @return string
     */
    protected function _buildOrWhereForArray($field,$values_array)
    {
		$where = " AND (";
		foreach ($values_array as $key=>$val)
		{
			$where .= (($key>0)?" OR":"") . " {$this->c_table}.{$field} LIKE '%".$this->db->escape_str($val)."%'";
		}
		$where .= " )";
		
		return $where;
    }
    
    /**
	 * Returns customer's posts.
	 * 
	 * @return array
	 */
    public function getMy()
    {
    	$this->db->order_by("id", "desc");
		
    	return $this->db->get_where($this->c_table,array('customer_id' => $this->CI->session->userdata('customer_id')))->result();
    }
    
    /**
     * Return ID of customer's post (customer should have just one post).
     *
     * @return mixed
     */
    public function getMyPostId()
    {
    	$row = $this->db->get_where($this->c_table,array('customer_id' => $this->CI->session->userdata('customer_id')))->row_array();
    	if(!$row) return FALSE;
    	return $row[$this->id_column];
    }
    
    /**
	 * Insert data, upload image, add post's categories. Returns ID field.
	 * Overrides param method.
	 * 
	 * @param array $post
	 * @param array|bool $categories
	 * @return integer
	 */
    public function Insert($post,$categories=FALSE)
    {
    	$post['pub_date'] = date('Y-m-d H:i:s');
		if($this->c_type!='company') //not need for customers
			$post['customer_id'] = $this->CI->session->userdata('customer_id'); 
		
		$post_id = parent::Insert($post);
		
		//add categories
		if(is_array($categories)) $this->_AddPostCategories($post_id,$categories);
		
		//add image
		$this->uploadImages($post_id);
    	
		return $post_id;
    }
    
    /**
	 * Check if logged user is post owner before update or delete.
	 * 
	 * @param integer $post_id
	 * @return bool
	 */
    public function IsLoggedUserPostOwner($post_id)
    {
    	$customer_id = $this->CI->session->userdata('customer_id');
    	$post = $this->getOneById($post_id);
    	
    	if($customer_id == $post['customer_id']) return TRUE;
    	else return FALSE;
    }
    
    /**
	 * Redirect user if he isn't owner of post.
	 * 
	 * @param integer $post_id
	 * @return void
	 */
    public function RedirectWrongUser($post_id)
    {
    	if(!$this->IsLoggedUserPostOwner($post_id)) redirect($this->c_table."/my");
    }
    
    /**
	 * Update data, upload image, add post's categories. Based on ID field. Returns ID field.
	 * Overrides parent method.
	 * 
	 * @param array $post
	 * @param array|bool $categories
	 * @return integer
	 */
    public function Update($post,$categories=FALSE)
    {
		parent::Update($post);
		
		$post_id = $post[$this->id_column];
		
		if(is_array($categories))
		{
			//remove old categories
			$this->_RemovePostCategories($post_id);
			
			//add new categories
			$this->_AddPostCategories($post_id,$categories);
		}
		
		//add image
		$this->uploadImages($post_id);
		
		return $post_id;
    }
    
    /**
	 * Increment count views of post.
	 * 
	 * @param integer $post_id
	 * @param integer $current_views
	 * @return void
	 */
    public function IncViews($post_id,$current_views)
    {
    	$cookie_name = 'viewed_'.$this->c_type.'_'.$post_id;
    	
    	if( !isset($_COOKIE[$cookie_name]) )
    	{
    		$this->db->update($this->c_table, array('views'=>++$current_views), array($this->id_column=>$post_id));
    		setcookie($cookie_name,1,time()+3600*24*365,'/');
    	}
    }
    
    /**
	 * Add post's categories.
	 * 
	 * @param integer $post_id
	 * @param array $categories
	 * @return void
	 */
    protected function _AddPostCategories($post_id,$categories)
    {
    	$categories = array_unique($categories);
        
        foreach ($categories as $category)
    	{
			if($category != -1)
			{
				$cat_post['type'] = $this->c_type;
				$cat_post['category_id'] = $category;
				$cat_post['post_id'] = $post_id;
				
				$this->db->insert($this->posts_categories_table, $cat_post);
			}
		}
    }
    
    /**
	 * Add Post's images.
	 * 
	 * @param integer $post_id
	 * @return bool
	 */
    private function uploadImages($post_id)
    {
        if( !@empty($_FILES['image']['name']) ) 
        {
            $this->uploadImage($post_id,'image',TRUE);
        }
        
        for ($i=1;$i<=10;$i++)
        {
            if( !@empty($_FILES['image_'.$i]['name']) ) 
            {
                $this->uploadImage($post_id,'image_'.$i);
            }
        }
    }

    /**
     * Add Post's image.
     *
     * @param integer $post_id
     * @param $image_field
     * @param bool $main_image
     * @return bool
     */
    private function uploadImage($post_id,$image_field,$main_image=FALSE)
    {
        //dump($_FILES);exit;
        if(@empty($_FILES[$image_field]['name'])) return FALSE;
    	
    	$config = array();
		$config['upload_path'] = $this->upload_path;
		$config['allowed_types'] = 'jpg|png';
		$config['encrypt_name'] = TRUE;
		$config['max_size'] = ( (@$this->CI->settings_model['upload_max_filesize']) ? $this->CI->settings_model['upload_max_filesize'] : 2048 );
		
		//  === LOAD UPLOAD CLASS === //
		$this->CI->load->library('upload', $config);
		
		if( !$this->CI->upload->do_upload($image_field) )
		{
			die($this->CI->upload->display_errors());
		}
		
		// === Remove old image === //
		if($main_image) $this->RemovePostImage($post_id);
		
		// === DATA === //
		$data['upload_data'] = $this->CI->upload->data();
		//dump($data);exit;

		//$image_extension = strtolower($data['upload_data']['file_ext']);
		//$image_name = microtime().$image_extension;
		$image_name = $data['upload_data']['file_name'];
		

		$orig_image = $data['upload_data']['full_path'];
		if($this->big_dir) $big_image = $data['upload_data']['file_path'].$this->big_dir.$this->c_table.'/'.$image_name;
		if($this->medium_dir) $medium_image = $data['upload_data']['file_path'].$this->medium_dir.$this->c_table.'/'.$image_name;
		if($this->small_dir) $small_image = $data['upload_data']['file_path'].$this->small_dir.$this->c_table.'/'.$image_name;

		// === Resize Images === //

		//  === LOAD IMAGE_LIB CLASS === //
		$this->CI->load->library('image_lib');
		
		//  === LOAD IMAGES CLASS === //
		$this->CI->load->library('resizer');

		$config['path'] = $orig_image;
		$this->resizer->initialize($config);

		// Big Image
		if(isset($big_image))
		{
    		$config = array();
    		$config['mode'] = "-";
    		$config['width'] = $this->big_width;
    		$config['height'] = $this->big_height;
    		$config['new_image'] = $big_image;
    
    		$this->resizer->resize($config);
		}
		
		// Medium Image (FIXED: Resize+Crop)
		if(isset($medium_image))
		{
		    $config = array();
    		//$config['mode'] = "+";
    		$config['width'] = $this->medium_width;
    		$config['height'] = $this->medium_height;
    		$config['new_image'] = $medium_image;
    		//$config['style']='optimal';
    
    		//$this->resizer->ResizeAndCrop($config);
    		$this->resizer->resize($config);
		}

		// Small Image (FIXED: Resize+Crop)
		if(isset($small_image))
		{
    		$config = array();
    		//$config['mode'] = "+";
    		$config['width'] = $this->small_width;
    		$config['height'] = $this->small_height;
    		$config['new_image'] = $small_image;
    		//$config['style']='optimal';
    
    		//$this->resizer->ResizeAndCrop($config);
    		$this->resizer->resize($config);
		}

		// === Delete Original Image === //
		@unlink($orig_image);
		
		// === Add to DB === //
		//set main image 
		if($main_image) $this->_SetPostHasImage($post_id,$image_name); 
		//additional image
		else $this->db->insert('posts_images', array('post_id'=>$post_id,'image'=>$image_name,'table'=>$this->c_table));
		
		return TRUE;
    }
    
    /**
     * Return additional images list.
     *
     * @param integer $post_id
     * @return array
     */
    private function getAdditionalImages($post_id)
    {
        if($this->db->table_exists('posts_images'))
        	return $this->db->get_where('posts_images',array('post_id'=>$post_id,'table'=>$this->c_table))->result_array();
        else 
        	return array();
    }
    
    
    /**
	 * Mark in table that posts has image.
	 * 
	 * @param integer $post_id
	 * @param string $image_name
	 * @return void
	 */
    private function _SetPostHasImage($post_id,$image_name)
    {
    	$this->db->update($this->c_table, array('image'=>$image_name), array($this->id_column=>$post_id));
    }

    /**
     * Mark in table that posts hasn't image.
     *
     * @param integer $post_id
     * @return void
     */
    private function _SetPostHasntImage($post_id)
    {
    	$this->db->update($this->c_table, array('image'=>''), array($this->id_column=>$post_id));
    }
    
    
    /**
	 * Delete post (with images, categories, tags, comments and ratings) by ID.
	 * 
	 * @param integer $post_id
	 * @return void
	 */
    public function DeleteId($post_id)
    {
        //remove main image
    	$this->RemovePostImage($post_id);
    	
    	//remove additional images
    	$additional_images = $this->getAdditionalImages($post_id);
    	foreach ($additional_images as $additional_image)
    	{
    	    $this->RemoveAdditionalImage($additional_image['id']);
    	}
    	
    	//delete post categories
    	$this->_RemovePostCategories($post_id);
    	
    	//delete tags
		$tags_model = load_model('tags_model');
		$tags_model->deletePostTags($this->c_table, $post_id);
    	
    	//delete post comments
    	$comments_model = load_model('comments_model');
    	$comments_model->deletePostComments($this->c_table,$post_id);
    	
    	//delete post ratings
    	$ratings_model = load_model('ratings_model');
    	$ratings_model->deletePostRatings($this->c_table,$post_id);
    	
    	//delete post
    	parent::DeleteId($post_id);
    }
    
    /**
	 * Delete post's categories.
	 * 
	 * @param integer $post_id
	 * @return void
	 */
    private function _RemovePostCategories($post_id)
    {
    	if($this->db->table_exists($this->posts_categories_table))
        {
            $this->db->delete($this->posts_categories_table, array('post_id' => $post_id, 'type'=>$this->c_type));
        }
    }
    
    /**
	 * Delete post's main image.
	 * 
	 * @param integer $post_id
	 * @return bool
	 */
    public function RemovePostImage($post_id)
    {   	
    	$post = $this->getOneById($post_id);
    	
    	if(!isset($post['image'])) return FALSE;
    	
    	$this->_SetPostHasntImage($post_id);
    	
    	if($post['image'])
    	{
	    	$this->unlinkImage($post['image']);
    	}

        return TRUE;
    }
    
    /**
	 * Delete post's additional image.
	 * 
	 * @param integer $image_id
	 * @return void
	 */
    public function RemoveAdditionalImage($image_id)
    {
        if($this->db->table_exists('posts_images'))
        {
            $post = $this->db->get_where('posts_images', array('id' => $image_id), 1)->row_array();

            if($post['image'])
            {
                $this->unlinkImage($post['image']);
            }

            $this->db->delete('posts_images', array('id' => $image_id));
        }
    }
    
    /**
     * Remove small,medium and big images.
     *
     * @param string $image
     * @return void
     */
    private function unlinkImage($image)
    {
        @unlink($this->upload_path.$this->small_dir.$this->c_table.'/'.$image);
    	@unlink($this->upload_path.$this->medium_dir.$this->c_table.'/'.$image);
    	@unlink($this->upload_path.$this->big_dir.$this->c_table.'/'.$image);
    }
    
    //Check if post is valid (in date range)
    // -- posters and jobs only --- //
    /*function isLive($post_id,$days=0) 
    {
    	$post = $this->getOneById($post_id);
    	
    	$live_date = $post['pub_date']+$post['period']*24*3600;
    	
    	$now = time();
    	
    	$alert_time = $days*24*3600;

    	if( $now+$alert_time > $live_date ) return false;
    	else return true;   	
    }*/
    
    /**
	 * Delete dead posts (if ended period of live).
	 * 
	 * @return void
	 */
    public function DeleteDeadPosts()
    {
    	$dead_posts = $this->db->get_where($this->c_table,"pub_date + period * 24 * 3600 < UNIX_TIMESTAMP()")->result_array();
		
    	foreach ($dead_posts as $post)
    	{
    		$this->DeleteId($post[$this->id_column]);
    	}
    	
    	//$this->db->delete($this->c_table, "pub_date + period * 24 * 3600 < UNIX_TIMESTAMP()");
    }
    
    /**
	 * Make sql join criterias based on $filter_data.
	 * 
	 * @param $filter_data
	 * @return string
	 */
    protected function _buildJoin(array $filter_data=array())
    {
    	$join = "";
    	
    	if( isset($filter_data['category']) && $filter_data['category'] )
    	{
	    	$join .= " JOIN {$this->posts_categories_table} ON ( {$this->posts_categories_table}.post_id={$this->c_table}.{$this->id_column} AND {$this->posts_categories_table}.type='{$this->c_type}' )";
	    }
    	
    	//filter by tag
		if( (isset($filter_data['tag']) && ($tag = $this->CI->security->xss_clean(trim(urldecode($filter_data['tag']))))) || ( isset($filter_data['tags']) && ($tag = $this->CI->security->xss_clean(trim(urldecode($filter_data['tags'])))) ) )
		{
			$join .= " JOIN {$this->tags_table} ON {$this->c_table}.id = {$this->tags_table}.post_id";
		}
		
		//add customer info
		if($this->with_customer_info)
		{
			$join .= " JOIN {$this->customers_table} ON {$this->customers_table}.id = {$this->c_table}.customer_id";
		}
		
		return $join;
    }
    
    /**
     * Make sql for select customer (post's owner) info.
     *
     * @param array $filter_data
     * @return string
     */
    protected function _buildCustomerSelect($filter_data)
    {
    	if($this->with_customer_info) return ",{$this->customers_table}.name as customer_name, {$this->customers_table}.surname as customer_surname ";
    	return "";
    }
    
    /**
	 * Make order by based on $filter_data.
	 * 
	 * @param $filter_data
	 * @return string
	 */
    protected function _buildOrderBy(array $filter_data=array())
    {
    	if(isset($filter_data['sort_by']) && isset($filter_data['sort_order']))
        {
            $sort_by = $this->db->escape_str($filter_data['sort_by']);
            $sort_order = $this->db->escape_str($filter_data['sort_order']);

            return "ORDER BY {$sort_by} {$sort_order}";
        }

        return '';
    }
    
    /**
     * Return list of most popular posts.
     *
     * @param integer $limit
     * @return array
     */
    public function getMostPopular($limit)
    {
    	$filter_data = array('per_page'=>$limit,'sort_by'=>'views','sort_order'=>'desc','offset'=>0);
    	
    	return $this->get('index',$filter_data);
    }
    
    /**
     * Return list of most recent posts.
     *
     * @param integer $limit
     * @return array
     */
    public function getRecent($limit)
    {
    	$filter_data = array('per_page'=>$limit,'sort_by'=>'pub_date','sort_order'=>'desc','offset'=>0);
    	
    	return $this->get('index',$filter_data);
    }
    
    /**
     * Return list of random records for defined category.
     *
     * @param integer $limit
     * @param integer $category_id
     * @return array
     */
    public function getRandomOfCategory($limit,$category_id)
    {
        $filter_data = array('per_page'=>$limit,'category'=>$category_id,'sort_by'=>'RAND()','offset'=>0);
    	
    	return $this->get('index',$filter_data);
    }

    /*
     * Getter for c_type
     */
    public function getCtype()
    {
        return $this->c_type;
    }

    /**
     * Crate pagination links
     * @param string $action
     * @param array $filter_ex
     * @param integer $total_rows
     * @param integer $per_page
     * @return string
     */
    protected function createPaginationLinks($action, $filter_ex, $total_rows, $per_page)
    {
        if( !$action || empty($filter_ex) || !isset($filter_ex['filter_str']) || !isset($filter_ex['offset_uri_segment']) || !$per_page )
        {
            return '';
        }

        $this->load->library('pagination');

        $pagination_config = array(
            'base_url'		 => base_url().$this->CI->_getBaseURI()."/{$action}/".$filter_ex['filter_str']."/page/",
            'total_rows'	 => $total_rows,
            'per_page'		 => $per_page,
            'uri_segment'	 => $filter_ex['offset_uri_segment'],
            'full_tag_open'	 => '<p>',
            'full_tag_close' => '</p>',
            'first_link'     => language('pagination_first'),
            'last_link'     => language('pagination_last'),
        );

        //load specific pagination configuration
        load_theme_view('inc/pagination');//init pagination_config for CI

        if(!empty($this->CI->pagination_config)) $pagination_config = array_merge($pagination_config,$this->CI->pagination_config);

        $this->CI->pagination->initialize($pagination_config);

        return $this->CI->pagination->create_links();
    }
}