<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


class Uploader_lib
{
	private $CI;
	
	//dir for upload images
	private $upload_path = './images/data/';
	
	private $short_path = '';
	//dir for big images
	private $big_dir = "b/";
	//dir for medium images
	private $medium_dir = FALSE;
	//dir for small (thumbnails) images
	private $small_dir = "s/";
	//images sizes
	private $big_width = 500;
	private $big_height = 500;
	private $big_crop = FALSE;
	private $medium_width = FALSE;
	private $medium_height = FALSE;
	private $medium_crop = TRUE;
	private $small_width = 100;
	private $small_height = 75;
	private $small_crop = TRUE;

	/**
	 * Inittialize preferences if they set.
	 *
	 * @param  array $props
	 * @return 	void
	 */
	public function __construct($props = array())
	{
		$this->CI =& get_instance();
	    
	    if (count($props) > 0)
		{
			$this->initialize($props);
		}

		log_message('debug', "Uploader_lib Class Initialized");
		
		$this->CI->load->library('tools_lib');
	}

	/**
	 * Initialize preferences.
	 *
	 * @param	array $config
	 * @return	void
	 */
	public function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			if(isset($this->$key)) $this->$key = $val;
		}
	}

	public function uploadFile($file_field)
    {
        if( @empty($_FILES[$file_field]['name']) ) return FALSE;
    	
    	$config = array();
		$config['upload_path'] = $this->upload_path;
		$config['allowed_types'] = 'jpeg|jpg|png|gif|doc|docx|ppt|pptx|xls|xlsx|pub|zip|rar|rtf|pdf|psd|mp3|mp4|wav|wma|avi|flv|mov|mpeg|mpg|txt';
		$config['encrypt_name'] = TRUE;
		$config['max_size'] = ( (@$this->CI->settings_model['upload_max_filesize']) ? $this->CI->settings_model['upload_max_filesize'] : 2048 );
		
		//  === LOAD UPLOAD CLASS === //
		$this->CI->load->library('upload', $config);
		
		if( !$this->CI->upload->do_upload($file_field) )
		{
			die($this->CI->upload->display_errors());
			//return FALSE;
		}
		
		$data['upload_data'] = $this->CI->upload->data();
		
		$file_name = $data['upload_data']['file_name'];
		
		$orig_file = $data['upload_data']['full_path'];
		
		//if not image - return it's name
		if( !$data['upload_data']['is_image'] ) 
		{
			$files_folder = $data['upload_data']['file_path'].'files/'.$this->short_path.'/';
			
			$this->CI->tools_lib->mkdir($files_folder,0777);
			
			copy($orig_file,$files_folder.$file_name);
			@unlink($orig_file);
			
			return $file_name;
		}

		// --- resize image and copy to b/, m/, s/ folder.
		if($this->big_dir) 
		{
		    $big_folder = $data['upload_data']['file_path'].$this->big_dir.$this->short_path.'/';
		    $this->CI->tools_lib->mkdir($big_folder,0777);
		    $big_image = $big_folder.$file_name;
		}
		if($this->medium_dir) 
		{
		    $medium_folder = $data['upload_data']['file_path'].$this->medium_dir.$this->short_path.'/';
		    $this->CI->tools_lib->mkdir($medium_folder,0777);
		    $medium_image = $medium_folder.$file_name;
		}
		if($this->small_dir) 
		{
		    $small_folder = $data['upload_data']['file_path'].$this->small_dir.$this->short_path.'/';
		    $this->CI->tools_lib->mkdir($small_folder,0777);
		    $small_image = $small_folder.$file_name;
		}

		// === Resize Images === //

		//  === LOAD IMAGE_LIB CLASS === //
		$this->CI->load->library('image_lib');
		
		//  === LOAD IMAGES CLASS === //
		$this->CI->load->library('resizer');

		$config['path'] = $orig_file;
		$this->CI->resizer->initialize($config);

		// Big Image
		if(isset($big_image))
		{
    		$config = array();
    		
    		$config['width'] = $this->big_width;
    		$config['height'] = $this->big_height;
    		$config['new_image'] = $big_image;
    
    		if($this->big_crop)
    		{
    			$config['mode'] = "+";
    			$config['style']='optimal';
    			$this->CI->resizer->ResizeAndCrop($config);
    		}
    		else 
    		{
    			$config['mode'] = "-";
    			$this->CI->resizer->resize($config);
    		}
		}
		
		// Medium Image 
		if(isset($medium_image))
		{
		    $config = array();
    		
    		$config['width'] = $this->medium_width;
    		$config['height'] = $this->medium_height;
    		$config['new_image'] = $medium_image;
    		
    		if($this->medium_crop)
    		{
    			$config['mode'] = "+";
    			$config['style']='optimal';
    			$this->CI->resizer->ResizeAndCrop($config);
    		}
    		else 
    		{
    			$config['mode'] = "-";
    			$this->CI->resizer->resize($config);
    		}
		}

		// Small Image 
		if(isset($small_image))
		{
    		$config = array();
    		
    		$config['width'] = $this->small_width;
    		$config['height'] = $this->small_height;
    		$config['new_image'] = $small_image;
    		
    		if($this->small_crop)
    		{
    			$config['mode'] = "+";
    			$config['style']='optimal';
    			$this->CI->resizer->ResizeAndCrop($config);
    		}
    		else 
    		{
    			$config['mode'] = "-";
    			$this->CI->resizer->resize($config);
    		}
		}

		// === Delete Original Image === //
		@unlink($orig_file);
		
		return $file_name;
    }
    
    /**
     * Remove existed file.
     *
     * @param string $file_name
     */
    public function unlinkFile($file_name)
    {
        @unlink($this->upload_path."files/".$this->short_path.'/'.$file_name);
        @unlink($this->upload_path."s/".$this->short_path.'/'.$file_name);
    	@unlink($this->upload_path."m/".$this->short_path.'/'.$file_name);
    	@unlink($this->upload_path."b/".$this->short_path.'/'.$file_name);
    }

}