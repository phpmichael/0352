<?php
require_once(APPPATH.'models/base_model.php');


/** 
 * This is model for multilanguage functionality.
 * 
 * @package multilanguage  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Lang_model extends Base_model
{
	//name of table
	protected $c_table = 'lang';
	
	private $text = array();
	
	private $langArr = array(
	   'EN'=>'english',
	   'UA'=>'ukrainian',
	   'RU'=>'russian',
	   'NL'=>'dutch',
	   'PL'=>'polish'
	);

    
    public function __construct()
    {
        parent::__construct();
        
        $this->disableNotActiveLangs();
    }
    
    /**
     * Disable languages that not used.
     * 
     * @return void
     */
    private function disableNotActiveLangs()
    {
        $enabled_langs = explode(',',$this->CI->settings_model['enabled_langs']);
        
        /*foreach ($this->langArr as $lang=>$language)
        {
            if(!in_array($lang,$enabled_langs)) unset($this->langArr[$lang]);
        }*/
        
        $langArr = array();
        foreach ($enabled_langs as $lang)
        {
            if(isset($this->langArr[$lang])) $langArr[$lang] = $this->langArr[$lang];
        }
        
        $this->langArr = $langArr;
    }
    
    /**
	 * Return array of language short codes.
	 *
	 * @return array
	 */
	public function getLangCodes()
	{
	    return array_keys($this->langArr);
	}
	
	public function getLangArr()
	{
	    return $this->langArr;
	}
	
	/**
	 * Return short language code by language name.
	 *
	 * @param string $language
	 * @return string
	 */
	public function getLangCodeByLanguage($language)
	{
	    $languages = array_flip($this->langArr);
	    return ( isset($languages[$language])? $languages[$language] : $this->getDefaultLangCode() );
	}
	
	/**
	 * Return language name by 2 chars code.
	 *
	 * @param string $lang_code
	 * @return string
	 */
	public function getLanguageByLangCode($lang_code)
	{
	    return ( isset($this->langArr[$lang_code]) ? $this->langArr[$lang_code] : $this->getDefaultLanguage() );
	}
	
	/**
	 * Return code of deafult language.
	 *
	 * @return string
	 */
	public function getDefaultLangCode()
	{
	    return $this->CI->settings_model['default_lang'];
	}
	
	/**
	 * Return default language.
	 *
	 * @return string
	 */
	public function getDefaultLanguage()
	{
	    return $this->getLanguageByLangCode($this->getDefaultLangCode());
	}
	
    
    /**
	 * Load text for some sections. Should be before use "lang()" function.
	 * 
	 * @param string|array $sections
	 * @return void
	 */
	public function init($sections)
	{    
	    //$this->benchmark->mark('code_start');
	    
	    $CI =& get_instance();
		$language = $CI->config->item('language');
		
		$lang = $this->getLangCodeByLanguage($language);
		
		if($sections!='all')
		{
            if(!is_array($sections)) $sections = array($sections);
            
            $is_first_section = true;
            
            foreach ($sections as $section)
            {
                if($is_first_section) 
                {
                    $this->db->like(array('sections' => "|".$section."|"));
                    $is_first_section = false;
                }
                else 
                {
                     $this->db->or_like(array('sections' => "|".$section."|"));
                }
            }
		}
		
		$records = $this->db->select('sections, code, '.$lang)->get_where($this->c_table)->result_array();
		//dump($records);exit;
		
		//$this->benchmark->mark('code_start');
		foreach ($records as $record)
		{
			//$this->text[$section][$record['code']] = $record[$lang];
			$this->text[$record['code']] = $record[$lang];
		}
		
		//$this->benchmark->mark('code_end');
        //die( $this->benchmark->elapsed_time('code_start', 'code_end') );
	}
	
	/**
	 * Returns text by code.
	 * 
	 * @param string $code
	 * @return string
	 */
	public function get($code)
	{
	    //if( isset($this->text[$section][$code]) )
		if( isset($this->text[$code]) )
		{
			//return $this->text[$section][$code];
			return $this->text[$code];
		}
		else 
		{
			$controller = $this->CI->_getController();
	        $method = $this->CI->_getMethod();
		    
		    $text = "[lang_code:{$code}]";
			log_message('error','Language code does not exists : '.$text .". {$controller}->{$method}.");
			return $text;
		}
	}
	
	/**
	 * Translate text. Divide on parts before translate.
	 *
	 * @param string $text
	 * @param string $lp
	 * @param string $format
	 * @return string
	 */
	public function translate($text,$lp="auto|en",$format='text')
	{
	    $translate = '';
	    
	    $this->CI->load->helper('text');
	    $this->CI->load->driver('api_translate');
	    $driver = ( (isset($this->settings_model['translate_driver'])) ? $this->settings_model['translate_driver'] : 'bing' );
	    
	    //divide content on parts less then [amount] chars
		$partsArr = divide_on_parts($text,$this->CI->api_translate->$driver->max_chars_amount,$format);
		
		//translate every part
		foreach ($partsArr as $part)
		{
			$translate .= $this->CI->api_translate->$driver->translate($part,$lp,$format);
		}
		return $translate;
	}
	
	/* Admin */
	
	/**
	 * Insert or update data. Depends if ID field presents in array.
	 * Overloads parent method.
	 * 
	 * @param array $textcodeArr
	 * @return array
	 */
	public function insertOrUpdate($textcodeArr)
    {
    	$code = key($textcodeArr);
		
		$post = $textcodeArr[$code];
		
		foreach (get_multilang_codes() as $lang_code)
		{
		    $post[$lang_code] = stripslashes($post[$lang_code]);
		}
		
		//google translate
		foreach (get_multilang_codes() as $lang_code)
		{
		    if( $lang_code!='EN' && !$post[$lang_code] ) $post[$lang_code] = $this->translate($post['EN'],'en|'.$lang_code);    
		}
		
		if($code=='NEW')
		{
			$post = $this->Insert($post);
		}
		else 
		{
			$post = $this->Update($post,$code);
		}
		
		return $post;
    }
	
    /**
	 * Insert data. Returns code.
	 * Overloads parent method.
	 * 
	 * @param array $post
	 * @return array
	 */
	public function Insert($post)
	{
	    $post['code'] = ($post['code']) ? $this->generateCode($post['code'],0) : $this->generateCode($post['EN'],0) ;
	    
	    $post['id'] = parent::Insert($post);
	    
	    return $post;
	}
	
	/**
	 * Update data. Based on code. Returns code.
	 * Overloads parent method.
	 * 
	 * @param array $post
	 * @return array
	 */
	public function Update($post,$code)
    {
		$post = parent::prepareTablePost($post);
		//dump($post);exit;
		$post['code'] = ($post['code']) ? $this->generateCode($post['code'],$post[$this->id_column]) : $this->generateCode($post['EN'],$post[$this->id_column]) ;
    	//dump($post);exit;
    	$this->db->update($this->c_table, $post, array('code' => $code) );
		
    	return $post;
    }
	
    /**
	 * Generate code from english text.
	 * 
	 * @param string $value
	 * @param integer $lang_id
	 * @return string
	 */
	private function generateCode($value,$lang_id)
	{		
		$trans = array(
						"\s+"								=> '_',
						"[^a-z0-9_]"				        => '',
						"_+"						        => '_',
						"_$"						        => ''
					   );

		//lowercase links
		$code = strip_tags(strtolower($value));
	
		//just [a-z0-9-]
		foreach ($trans as $key => $val)
		{
			$code = preg_replace("#".$key."#", $val, $code);
		}
		
		//limit to 250 chars
		$code = substr($code,0,250);
		
		//if there already exists code
		$code = $this->makeCodeIfCodeExists($code,$lang_id);
	
		return $code;
	}
	
	/**
	 * Add underline and number to code if code already exists.
	 * 
	 * @param string $code
	 * @param integer $lang_id
	 * @return string
	 */
	private function makeCodeIfCodeExists($code,$lang_id)
    {
    	if( ($record = parent::getOneByUnique('code',$code)) && $record[$this->id_column] != $lang_id )
    	{
    		$code .= $this->generateCodeNumber($code,1);
    	}
    	
    	return $code;
    }
    
    /**
	 * Returns next number for code.
	 * 
	 * @param string $code
	 * @return integer
	 */
    private function generateCodeNumber($code,$i=1)
    {
    	$record = parent::getOneByUnique('code',$code.$i);
    	
    	if($record) return $this->generateCodeNumber($code,$i+1);
    	else return $i;
    }
	
    /**
     * Quick translation system codes.
     * @param $lang_code
     * @return void
     */
    public function translateAll($lang_code)
    {
        //$this->db->limit(10);
        $records = $this->db->get_where($this->c_table,array($lang_code=>''))->result_array();
        
        foreach ($records as $record)
        {
            $textcodeArr = array();
            $textcodeArr[$record['code']] = $record;
            $this->insertOrUpdate($textcodeArr);
            sleep(1);
        }
    }
}