<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for photos.
 *
 * @package photos
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 *
 * @property string upload_path
 * @property string small_dir
 * @property string big_dir
 * @property int small_width
 * @property int small_height
 * @property int big_width
 * @property int big_height
 * @property bool small_crop
 * @property bool big_crop
 */
class Photos_model extends Base_model
{
	//name of table
	protected $c_table = "photos";
	//name of tags table
	protected $tags_table = "tags";
	//prefix for settings
	protected $settings_prefix = 'photos_';
	
	//configuration of upload
	private $upload_config = array(
        'upload_path' => './images/data/',
        'allowed_types' => 'jpg|png',
        'encrypt_name' => TRUE,
        'max_size' => 2048,
    );
    
    //images settings
	private $photo_data = array(
	   'small_width' => 174,
	   'small_height' => 174,
	   'big_width' => 800,
	   'big_height' => 800,
	   'big_dir' => 'b/',
	   'small_dir' => 's/',
	   'small_crop' => TRUE,
	   'big_crop' => FALSE
	);

    public $upload_data = array();

	/**
	 * Init settings: read form table.
	 *
	 */
	public function __construct()
    {
        parent::__construct();
        
        $settings = $this->CI->settings_model;
        
        //change photo data (get params from settings)
        foreach ($this->photo_data as $param=>$value)
        {
            if(isset($settings[$this->settings_prefix.$param])) $this->photo_data[$param] = $settings[$this->settings_prefix.$param];
        }
        
        $this->upload_config['max_size'] = ( (@$this->CI->settings_model['upload_max_filesize']) ? $this->CI->settings_model['upload_max_filesize'] : 2048 );
    }
	
    /**
     * Get item from $this->upload_config or $this->photo_data if property not exists.
     *
     * @param string $property
     * @return mixed
     */
	public function __get($property)
    {
        if(isset($this->upload_config[$property])) return $this->upload_config[$property];
        if(isset($this->photo_data[$property])) return $this->photo_data[$property];
        
        return parent::__get($property);
    }
    
    /**
     * Returns upload configuration array.
     *
     * @return array
     */
    public function getUploadConfig()
    {
        return $this->upload_config;
    }

    /**
     * Returns item from $this->photo_data or full array;
     *
     * @param bool|string $item
     * @return mixed
     */
	public function getPhotoData($item=false)
	{
	    if(!$item) return $this->photo_data;
	    else return $this->photo_data[$item];
	}
	
	/**
	 * Add category and tags for each photo in list.
	 *
	 * @param array $list by reference
	 * @return void
	 */
	/*public function prepareListForOutput(&$list)
	{
	    $categories_model = load_model('photos_categories_model');
	    $tags_model = load_model('tags_model');
	    
	    foreach ($list as &$item)
	    {
	        $item->category = $categories_model->getTitle($item->category_id);
	        $item->tags_str = $tags_model->getPostTagsStr('photos',$item->id);
	    }
	}*/
	
	/**
	 * Resize/crop photo and indert photos data in table.
	 * Overrides parent method.
	 *
	 * @param array $upload_data
	 * @return integer
	 */
	public function Insert($upload_data)
	{
	    $this->processImage($upload_data);
	    
	    $post['file_name'] = $upload_data['file_name'];
	    $post['orig_name'] = $upload_data['orig_name'];
		$post['date'] = date('Y-m-d H:i:s');
	    
		return parent::Insert($post);
	}
	
	/**
	 * Update photo's category.
	 * Overrides parent method.
	 *
	 * @param array $post
	 * @return integer
	 */
	public function Update($post)
	{
	    if(!empty($post['category']))
	    {
    	    foreach ($post['category'] as $category_id)
    	    {
    	        $post['category_id'] = $category_id;
    	    }
    	    unset($post['category']);
	    }
	    
	    return parent::Update($post);
	}
	
	/**
	 * Resize/crop photo.
	 *
	 * @param array $upload_data
	 * @return bool
	 */
    public function processImage($upload_data)
    {
		$orig_image = $upload_data['full_path'];
		$big_image = $upload_data['file_path'].$this->big_dir.$this->c_table.'/'.$upload_data['file_name'];
		$small_image = $upload_data['file_path'].$this->small_dir.$this->c_table.'/'.$upload_data['file_name'];

		// === Resize Images === //

		//  === LOAD IMAGE_LIB CLASS === //
		$this->CI->load->library('image_lib');
		
		//  === LOAD IMAGES CLASS === //
		$this->CI->load->library('resizer');

		$config['path'] = $orig_image;
		$this->resizer->initialize($config);

		// Big Image
		$config = array();
		$config['width'] = $this->big_width;
		$config['height'] = $this->big_height;
		$config['new_image'] = $big_image;

		if($this->big_crop)
		{
    		$config['mode'] = "+";
    		$config['style'] = 'optimal';
    
    		$this->resizer->ResizeAndCrop($config);
		}
		else 
		{
		    $config['mode'] = "-";
		    
		    $this->resizer->resize($config);
		}

		// Small Image 
		$config = array();
		$config['width'] = $this->small_width;
		$config['height'] = $this->small_height;
		$config['new_image'] = $small_image;
		
		if($this->small_crop)
		{
    		$config['mode'] = "+";
    		$config['style'] = 'optimal';
    
    		$this->resizer->ResizeAndCrop($config);
		}
		else 
		{
		    $config['mode'] = "-";
		    
		    $this->resizer->resize($config);
		}

		// === Delete Original Image === //
		@unlink($orig_image);
		
		return TRUE;
    }
    
    /**
     * Delete record (with images, categories, tags, comments and ratings) by ID.
     *
     * @param integer $post_id
     * @return void
     */
    public function DeleteId($post_id)
    {
        // === GET RECORD === //
		$record = parent::getOneById($post_id);

		// === DELETE IMAGES === //
		$this->DeletePhoto($record['file_name']);
		
		//delete tags
		$tags_model = load_model('tags_model');
		$tags_model->deletePostTags($this->c_table, $post_id);
    	
    	//delete post comments
    	$comments_model = load_model('comments_model');
    	$comments_model->deletePostComments($this->c_table,$post_id);
    	
    	//delete post ratings
    	$ratings_model = load_model('ratings_model');
    	$ratings_model->deletePostRatings($this->c_table,$post_id);
        
        parent::DeleteId($post_id);
    }
    
    /**
     * Delete photo file.
     *
     * @param string $file_name
     * @return void
     */
    public function DeletePhoto($file_name)
    {
        @unlink($this->upload_path.$this->big_dir.$this->c_table.'/'.$file_name);
		@unlink($this->upload_path.$this->small_dir.$this->c_table.'/'.$file_name);
    }

    /**
     * Returns photos list (paginated).
     *
     * @param integer $category_id
     * @param int|string $tag
     * @param integer $per_page
     * @return array
     */
    public function get($category_id = 0, $tag = 0, $per_page = 10)
    {
    	//offset values
    	$offset_segment = $this->CI->_getSegmentsOffset()+5;
    	$offset = $this->CI->uri->segment($offset_segment,0);
		
		//select total count of rows before
		$this->db->select("COUNT(*) AS numrows");
		
		//build where
		if($tag)
		{
		    $this->db->join( $this->tags_table , "{$this->c_table}.id = {$this->tags_table}.post_id" );
		    $this->db->where( array($this->tags_table.'.table' => $this->c_table, $this->tags_table.'.tag' => $tag) );
		}
		elseif($category_id) 
		{
			$this->db->where( array('category_id' => $category_id) );
		}
		
		$num = $this->db->get($this->c_table)->row_array();
		$total_rows = $num['numrows'];
		
		//select records
		$this->db->select("*");
		
		//build where
		if($tag)
		{
		    $this->db->join( $this->tags_table , "{$this->c_table}.id = {$this->tags_table}.post_id" );
		    $this->db->where( array($this->tags_table.'.table' => $this->c_table, $this->tags_table.'.tag' => $tag) );
		}
		elseif($category_id) 
		{
			$this->db->where( array('category_id' => $category_id) );
		}
		
		$this->db->order_by("id", "asc");
		$data['list'] = $this->db->get($this->c_table, $per_page, $offset)->result_array();
        //dump($this->db->last_query());exit;
		
        // Pagination!
		$this->load->library('pagination');
		
		$this->pagination->initialize(
			array(
					'base_url'		 => base_url().$this->CI->_getBaseURI()."/show/$category_id/$tag",
					'total_rows'	 => $total_rows,
					'per_page'		 => $per_page,
					'uri_segment'	 => $offset_segment,
					'full_tag_open'	 => '<p>',
					'full_tag_close' => '</p>',
					'first_link'     => language('pagination_first'),
					'last_link'     => language('pagination_last'),
					)
				);

		$data['paginate'] = $this->pagination->create_links();
		
		return $data;
	}    
	
	/**
	 * Bulk change category.
	 * 
	 * @param array $arr
	 * @param integer $category_id
	 * @return void
	 */
    public function bulkChangeCategory(array $arr,$category_id)
	{
		if( !empty($arr) )
		{
			foreach ($arr as $id=>$selected)
			{
				$this->db->update($this->c_table, array('category_id'=>intval($category_id)), array($this->id_column => $id) );
			}
		}
	}

    /**
     * Store form data.
     *
     * @param array $data
     * @param bool $nn not used here, just in formbuilder it is form html id
     * @param integer $id
     * @return integer|bool
     */
    public function storeForm($data, $nn, $id=0)
    {
        $this->CI->load->library('upload', $this->getUploadConfig());

        if( !isset($data['image_field']) ) $data['image_field'] = 'image';

        if( $this->upload->do_upload($data['image_field']) )
        {
            $this->upload_data = $this->upload->data();

            $configValidation = array(
                array(
                    'field'   => 'file_name',
                    'label'   => language('name'),
                    'rules'   => 'trim|required|xss_clean'
                ),
            );

            $data[$this->id_column] = $id;

            return parent::save($this->upload_data, $configValidation);
        }

        return false;
    }
}