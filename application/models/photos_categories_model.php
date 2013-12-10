<?php
require_once(APPPATH.'models/categories_model.php');

/** 
 * This is model for photos_categories table.
 * 
 * @package photos  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Photos_categories_model extends Categories_model
{
	//name of table
    protected $c_table = 'photos_categories_list';
    
    //configuration of upload
	protected $upload_config = array(
        'upload_path' => './images/data/',
        'allowed_types' => 'jpg|png',
        'encrypt_name' => TRUE,
        'max_size' => 2048,
    );
    
    //images settings
	protected $photo_data = array(
	   'small_width' => 174,
	   'small_height' => 174,
	   'big_width' => 800,
	   'big_height' => 800,
	   'big_dir' => 'b/',
	   'small_dir' => 's/',
	   'small_crop' => TRUE
	);
	
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
            if( preg_match("/^{$this->c_table}_(\w+)/",$param,$match) && isset($this->photo_data[$match[1]]) ) 
            {
                $this->photo_data[$match[1]] = $settings[$param];
            }
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
	 * Insert or update data. Depends if ID field presents in array.
	 * Overloads parent method.
	 * 
	 * @param array $post
	 * @param array $upload_data
	 * @return void
	 */
	public function insertOrUpdate($post,$upload_data)
    {
    	//UPDATE
		if( @$post[$this->id_column] )
		{
			$this->Update($post,$upload_data);
		}
		//ADD
		else 
		{
			$this->Insert($post,$upload_data);
		}
    }
	
    /**
	 * Insert data. Add photo. Returns ID field.
	 * Overloads parent method.
	 * 
	 * @param array $post
	 * @param array $upload_data
	 * @return integer
	 */
	public function Insert($post,$upload_data)
	{
	    if(!empty($upload_data))
	    {
			$this->processImage($upload_data);
		    
		    $post['file_name'] = $upload_data['file_name'];
		    $post['orig_name'] = $upload_data['orig_name'];
	    }
	    
		return parent::Insert($post);
	}
	
	/**
	 * Update data. Remove old photo and add new.
	 * Overloads parent method.
	 * 
	 * @param array $post
	 * @param array $upload_data
	 * @return integer
	 */
	public function Update($post,$upload_data=array())
	{
	    if( !empty($upload_data['file_name']) )
        {
            //remove old photo
            $this->DeletePhoto($post['file_name']);
            
            //upload new photo
    	    $this->processImage($upload_data);
    	    
    	    $post['file_name'] = $upload_data['file_name'];
    	    $post['orig_name'] = $upload_data['orig_name'];
        }
	    
		return parent::Update($post);
	}
	
	/**
	 * Delete category and its photo by ID.
	 * Overloads parent method.
	 * 
	 * @param integer $id
	 * @return void
	 */
	public function DeleteId($id)
    {
        // === GET RECORD === //
		$record = parent::getOneById($id);

		// === DELETE IMAGES === //
		$this->DeletePhoto($record['file_name']);
        
        parent::DeleteId($id);
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
		if($this->big_dir) $big_image = $upload_data['file_path'].$this->big_dir.$this->c_table.'/'.$upload_data['file_name'];
		if($this->small_dir) $small_image = $upload_data['file_path'].$this->small_dir.$this->c_table.'/'.$upload_data['file_name'];

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

		// Small Image (FIXED: Resize+Crop)
		if(isset($small_image))
		{
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
		}

		// === Delete Original Image === //
		@unlink($orig_image);
		
		return TRUE;
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
	
}