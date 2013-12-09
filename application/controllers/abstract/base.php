<?php

/** 
 * This is basic controller for most controllers.
 * 
 * @package base  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
abstract class Base extends CI_Controller 
{
	protected $panel;//admin or front
    
    //start url section from 0 in front controllers and from 1 in admin controllers
	protected $segmentsOffset = 0;
	//current controller
	protected $controller;
	//current method
	protected $method;
	
	//current page title
	private $page_title;
	
	//current table
	protected $c_table;
	//folder is empty or admin
	protected $folder = '';
	//folder where themes located
	protected $themes_folder = "themes/";
	//current theme
	protected $theme;
	//layout
    protected $layout = 'main';
	//default pagination settings
	protected $per_page = 20;
	//interface lang
	protected $interface_lang;
	
	//folders with javascript, css, images etc
	private $folders = array(
		'css' => 'css/',
		'js' => 'js/',
		'images' => 'images/'
	);
	
	//titles for controller's pages
	protected $page_titles = array();
	
	//field titles for forms used in controller
	protected $fields_titles = array(
		'id' => 'ID',
	);
	
	protected $css_files = array();
	protected $js_files = array();
	
	//get text just for current language
	protected $justCurrentLang = FALSE;

	/**
	 * Init router, set current controller and method, load CI in view.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		//set language based on URL
		$this->setLanguage();
		
		$router =& load_class('Router');
		$this->controller = $router->fetch_class();
		$this->method = $router->fetch_method();
		
		//default page title
		$this->_setDefaultPageTitle();

		// Load Controller Object to View (for PHP5)
		$data['BC'] =& $this;
		
		// === Include Template === //
		$data['tpl_page'] = $this->controller.'/'.$this->method;

		// === LOAD VARS TO ALL VIEWERS === //
		$this->load->vars($data);
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// === Custom validation : Start === //
	/**
	 * Check if doesn't exist value $field_value for field $field_name. 
	 * In example checks if email doesn't exist in table.
	 * 
	 * @param mixed $field_value
	 * @param string $field_name
	 * @return bool
	 */
	public function _unique_field($field_value,$field_name)
	{
		if(!$field_value) return TRUE;//if no value means that is not required
		return !($this->db->get_where($this->c_table, array($field_name => $field_value))->row_array());
	}
	
	/**
	 * Check if doesn't exist value $field_value for field $field_name, but used if you edit existed record. 
	 * In example checks if email doesn't exist in table when you try to change email.
	 * 
	 * @param mixed $field_value
	 * @param array $param
	 * @return bool
	 */
	public function _unique_field_for_edit($field_value,$param)
	{
		if(!$field_value) return TRUE;//if no value means that is not required
		
		list($field_name,$current_id) = explode(',',$param);
		
		$id_column = ($this->db->field_exists('data_key',$this->c_table))?'data_key':'id';
		
		return !($this->db->get_where($this->c_table, array($field_name => $field_value,$id_column.' != '=>$current_id))->row_array());
	}
	
	/**
	 * Check if youtube URL is valid.
	 *
	 * @param string $field_value
	 * @return bool
	 */
	public function _valid_youtube_url($field_value)
	{
		return (bool)preg_match("#(^$|^https?:\/\/(?:[a-zA_Z]{2,3}.)?(?:youtube\.com\/watch\?)((?:[\w\d\-\_\=]+&amp;(?:amp;)?)*v(?:&lt;[A-Z]+&gt;)?=([0-9a-zA-Z\-\_]+)))#i",$field_value);
	}
	
	/**
	 * Check if exists value $field_value for field $field_name. 
	 * In example checks if email already exists in table.
	 * 
	 * @param mixed $field_value
	 * @param string $field_name
	 * @return bool
	 */
	public function _value_exists($field_value,$field_name)
	{
		return !($this->_unique_field($field_value,$field_name));
	}
	
	/**
	 * Check if user selected category from dropdown. 
	 * Used for photos, posts etc.
	 * 
	 * @param integer $category
	 * @return bool
	 */
	public function _isset_category($category)
	{
		if($category==-1) return FALSE;
		else return TRUE;
	}
	
	/**
	 * Validate captcha. 
	 * 
	 * @param string $captcha
	 * @return bool
	 */
	public function _valid_captcha($captcha)
	{
		return $this->captcha_model->check($captcha);
	}
	// === Custom validation : End === //
	
	/**
	 * Set language.
	 *
	 * @return void
	 */
	private function setLanguage()
	{
	    $CI =& get_instance();
        
        $this->interface_lang = $CI->uri->segment(1);
        
        switch ($this->interface_lang)
        {
            case "en":
            case "ua":
            case "ru":
            case "nl":
            case "pl":
                $CI->config->set_item('language',$this->lang_model->getLanguageByLangCode(strtoupper($this->interface_lang)));
                $this->segmentsOffset++;
                $folder_segment = $this->uri->slash_segment(2);
            break;
            
            default:
                $CI->config->set_item('language',$this->lang_model->getDefaultLanguage());
                $folder_segment = $this->uri->slash_segment(1);
                $this->interface_lang = '';
        }
        
        //check if admin or front controller
		if( ($this->_getFolder() != '') && ($folder_segment == $this->_getFolder()) ) $this->segmentsOffset++;
	}
	
	/**
	 * Returns field's title by field's name. 
	 * 
	 * @uses self::$fields_titles
	 * @param string $field_name
	 * @return string
	 */
	public function _getFieldTitle($field_name)
	{
		return (isset($this->fields_titles[$field_name]))? $this->fields_titles[$field_name] : '';
	}
	
	/**
	 * Returns fields' titles by fields' names. 
	 * 
	 * @uses self::$fields_titles
	 * @param array $field_names
	 * @return array
	 */
	public function _buildTableFieldsArray(array $fields_names)
	{
		$fields_array = array();
		
		foreach ($fields_names as $field_name)
		{
			if( isset($this->fields_titles[$field_name]) ) $fields_array[$field_name] = $this->fields_titles[$field_name];
		}
		
		return $fields_array;
	}

	/**
	 * Returns path to theme (full or relative). 
	 * 
	 * @param bool $fullPath
	 * @return string
	 */
	public function _getTheme($fullPath=FALSE)
	{
		return (($fullPath)?base_url():'').$this->themes_folder.$this->folder.$this->theme.'/';
	}
	
	/**
	 * Set theme.
	 *
	 * @param string $theme
	 */
	public function _setTheme($theme=FALSE)
	{
		$this->theme = ($theme)?$theme:$this->settings_model[$this->panel.'_theme'];
		
		//if mobile version
		if( preg_match("/^m\./",$this->input->server('HTTP_HOST')) ) $this->theme .= ".mobile";
	}
	
	/**
	 * Returns folder from $this->folders array or $this->folder if $name not posted. 
	 * 
	 * @uses self::$folders
	 * @param string $name
	 * @return string
	 */
	public function _getFolder($name=false)
	{
		if($name) return $this->folders[$name];
		else return $this->folder;
	}
	
	/**
	 * Return panel.
	 *
	 * @return string
	 */
	public function _getPanel()
	{
	    return $this->panel;
	}
	
	/**
	 * Return interface language.
	 *
	 * @param bool $getDefault
	 * @return string
	 */
	public function _getInterfaceLang($getDefault=FALSE)
	{
		$lang = $this->interface_lang;
		if(!$lang && $getDefault)
		{
		    return strtolower($this->lang_model->getDefaultLangCode());
		}
		return $lang;
	}
	
	/**
	 * Returns base URL. 
	 * 
	 * @return string
	 */
	public function _getBaseURL()
	{
		return (($this->interface_lang)?$this->interface_lang.'/':'').$this->_getFolder();
	}
	
	/**
	 * Returns base URI. 
	 * 
	 * @return string
	 */
	public function _getBaseURI()
	{
		return $this->_getBaseURL().$this->controller;
	}
	
	/**
	 * Returns title from $this->page_titles array or $this->page_title if $key not posted. 
	 * 
	 * @uses self::$page_titles
	 * @param string $key
	 * @return string
	 */
	public function _getPageTitle($key=false)
	{
		if($key) 
		{
			return ( isset($this->page_titles[$key] ) ? $this->page_titles[$key] : '' );
		}
		else 
		{
			return $this->page_title;
		}
	}
	
	/**
	 * Set page's title. 
	 * 
	 * @param string
	 * @return void
	 */
	protected function _setPageTitle($title)
	{
		$this->page_title = $title;
	}
	
	/**
	 * Append string to page title.
	 *
	 * @param string $title
	 */
	protected function _appendToPageTitle($title)
	{
		if($title) $this->page_title .= ' :: '.$title;
	}
	
	/**
	 * Set default page title. 
	 * 
	 * @uses self::$page_titles
	 * @return void
	 */
	protected function _setDefaultPageTitle()
	{
		$this->page_title = ( isset($this->page_titles[$this->method]) )? $this->page_titles[$this->method] :'';
	}
	
	/**
	 * Returns segment offset (0 or 1). 
	 * 
	 * @return integer
	 */
	public function _getSegmentsOffset()
	{
		return $this->segmentsOffset;
	}
	
	/**
	 * Returns current method. 
	 * 
	 * @return string
	 */
	public function _getMethod()
	{
		return $this->method;
	}
	
	/**
	 * Returns current controller. 
	 * 
	 * @return string
	 */
	public function _getController()
	{
		return $this->controller;
	}
	
	/**
	 * Returns current table's name. 
	 * 
	 * @return string
	 */
	public function _getCurrentTable()
	{
		return $this->c_table;
	}
	
	public function _isJustCurrentLang()
	{
	    return $this->justCurrentLang;
	}
	
	/**
	 * Returns css files array. 
	 * 
	 * @uses self::$css_files
	 * @return array
	 */
	public function _getCSSFiles()
	{
	    return $this->css_files;
	}
	
	/**
	 * Returns javascript files array. 
	 * 
	 * @uses self::$js_files
	 * @return array
	 */
	public function _getJSFiles()
	{
	    return $this->js_files;
	}
	
	/**
	 * Return list of all available controllers.
	 *
	 * @return array
	 */
	/*protected function getAvailableControllers()
	{
		return explode(',',$this->settings_model['available_controllers']);
	}*/
	
	/**
	 * Check if controller is available.
	 *
	 * @param string $controller
	 * @return bool
	 */
	/*public function isAvailabeControler($controller)
	{
		return in_array($controller,$this->getAvailableControllers());
	}*/
	
	/**
	 * Append CSS and JS files for comments and ratings.
	 *
	 * @return void
	 */
	protected function includeCommentsAndRatingsFiles()
	{
	    // === CSS Styles === //
		$this->css_files = array(
		      $this->_getTheme().'css/comments.css',
		      $this->_getTheme().'css/ratings.css',
		);
		
		// === JS Styles === //
		$this->js_files = array(
		      $this->_getFolder('js')."custom/comments/process.js",
		      $this->_getFolder('js')."custom/ratings/process.js",
		);
	}
	
	
	/**
	 * Return current layout.
	 *
	 * @return string
	 */
	protected function _getLayout()
	{
	    return $this->layout;
	}
	
	/**
	 * Preparate data before output view.
	 * 
	 * @param array $data
	 * @return void
	 */
	protected function _OnOutput( array $data = array() )
	{
		// === VIEW === //
		load_theme_view($this->_getLayout(),$data);
	}
	
	/**
	 * Parse sortable data.
	 *
	 * @return array
	 */
	protected function parseSortables()
	{
	    if( $_POST['sortables'] ) parse_str($_POST['sortables'],$sortables);
		else die('Error: No sortables.');

		return $sortables['sortables'];
	}
	
	/**
	 * Send headers to protect from cache in IE.
	 *
	 */
	protected function notCacheHeaders()
	{
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	}
	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //
}