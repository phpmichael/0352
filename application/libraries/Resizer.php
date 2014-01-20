<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/** 
 * This class for resizing images.
 * 
 * @package images  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Resizer
{
	private $path;
	private $width;
	private $height;
	private $type;
	private $size_str;
	private $quality = 85;

    /**
     * Initialize preferences if they set.
     *
     * @param  array $props
     * @return \Resizer
     */
	public function __construct($props = array())
	{
		if (count($props) > 0)
		{
			$this->initialize($props);
		}

		log_message('debug', "Resizer Class Initialized");
	}

	/**
	 * Initialize preferences.
	 *
	 * @param	array $config
	 * @return	void
	 */
	public function initialize($config = array())
	{
		$defaults = array(
							'path'			=> '',
						);


		foreach ($defaults as $key => $val)
		{
			if (isset($config[$key]))
			{
				$method = 'set_'.$key;
				if (method_exists($this, $method))
				{
					$this->$method($config[$key]);
				}
				else
				{
					$this->$key = $config[$key];
				}
			}
			else
			{
				$this->$key = $val;
			}
		}

		// Get Image Data
		$this->getData();
	}

	/**
	 * Get image information.
	 * Uses GD to determine the width/height/type of image.
	 *
	 * @return	void
	 */
	public function getData()
	{
        $info = getImageInfo($this->path);

        $this->width	= $info['width'];
        $this->height	= $info['height'];
        $this->type		= $info['type'];
        $this->size_str	= $info['size_str'];
	}

    /**
     * Resize image.
     *
     * @param    array $config
     * @return    void
     */
	public function Resize($config)
	{
		$CI =& get_instance();

		if(!isset($config['image_library'])) $config['image_library'] = 'GD2';
		if(!isset($config['new_image'])) $config['new_image'] = $this->path;
		if(!isset($config['source_image'])) $config['source_image'] = $this->path;
		if(!isset($config['quality'])) $config['quality'] = $this->quality;
		if(!isset($config['mode'])) $config['mode'] = "0";
		if(!isset($config['maintain_ratio'])) $config['maintain_ratio'] = true;

		if($config['mode'] == '+')
		{
			if( ($this->width / $this->height) > ($config['width']/$config['height']) )
			{
				$config['master_dim'] = "height";
			}
			else 
			{
				$config['master_dim'] = "width";
			}
		}
		elseif($config['mode'] == '-'){

			if($this->width > $this->height)
			{
				$config['master_dim'] = "width";
			}
			else 
			{
				$config['master_dim'] = "height";
			}
		}
		else 
		{
			if( ( ($this->width > $this->height) && ($config['width'] < $config['height']) ) || ( ($this->width < $this->height) && ($config['width'] > $config['height']) ) )
			{
				$w = $config['width'];
				$config['width'] = $config['height'];
				$config['height'] = $w;
			}
		}

		$CI->image_lib->initialize($config);

		$CI->image_lib->resize();

		/*dump($CI->image_lib->display_errors());*/
	}

    /**
     * Crop image.
     *
     * @param array $config
     * @return    void
     */
	public function Crop($config)
	{
		$CI =& get_instance();

		if(!isset($config['image_library'])) $config['image_library'] = 'GD2';
		if(!isset($config['source_image'])) $config['source_image'] = $this->path;
		if(!isset($config['style'])) $config['style'] = "optimal";
		$config['maintain_ratio'] = FALSE;

		if($config['style']=='top')
		{
			$config['x_axis'] = 0;
			$config['y_axis'] = 0;
		}
		elseif($config['style']=='center')
		{
			if($this->width > $config['width'])	$config['x_axis'] = (int)($this->width - $config['width'])/2;
			else $config['x_axis'] = 0;

			if($this->height > $config['height']) $config['y_axis'] = (int)($this->height - $config['height'])/2;
			else $config['y_axis'] = 0;
		}
		elseif($config['style']=='optimal')
		{
			if($this->width > $config['width'])	$config['x_axis'] = (int)($this->width - $config['width'])/4;
			else $config['x_axis'] = 0;

			if($this->height > $config['height']) $config['y_axis'] = (int)($this->height - $config['height'])/4;
			else $config['y_axis'] = 0;
		}

		$CI->image_lib->initialize($config);

		$CI->image_lib->crop();
	}

    /**
	 * Resize or Crop image.
     *
	 * @param	array $config
	 * @return	void
	 */
	public function ResizeAndCrop($config)
	{
		$this->Resize($config);

		$config['path'] = $config['new_image'];

		$this->initialize($config);

		$this->Crop($config);
	}

}