<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for multilanguage functionality.
 * 
 * @package multilanguage  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Lang extends Admin 
{
	//name of table
    protected $c_table = "lang";

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Lang
     */
	public function __construct()
	{
		parent::__construct();	
		
		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Labels === //
		$this->fields_titles['sections'] = 'Sections';
		$this->fields_titles['code'] = 'Code';
		$this->fields_titles['EN'] = language('english');
		$this->fields_titles['UA'] = language('ukrainian');
		$this->fields_titles['RU'] = language('russian');
		$this->fields_titles['NL'] = language('dutch');
		$this->fields_titles['PL'] = language('polish');
		
		// === Page Titles === //
		$this->page_titles['index'] = language('list');
		$this->page_titles['add'] = language('add');
		$this->page_titles['edit'] = language('edit');
		//default page title
		$this->_setDefaultPageTitle();
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	/**
	 * Build right top admin menu.
	 * Overrides parent method.
	 * 
	 * @return string
	 */
	public function _built_right_menu()
	{
		return '';
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Add/Edit lang codes.
	 * 
	 * @return void
	 */
	public function Update() 
    {	
    	parse_str($_POST['tdata'],$tdata);

        $textcodes = array();
        
        foreach ($tdata['tdata'] as $key => $val)
        {
        	$tmp = explode("__",$key);
        	$textcodes[$tmp[0]][$tmp[1]] = $val;
        }
        
		$result = $this->lang_model->insertOrUpdate($textcodes);
		
		echo json_encode($result);
		exit;
    }
    
    /**
     * Output translated text for all used languages in JSON format.
     * 
     * @return void
     */
    public function gtranslate()
    {
    	$text = $_POST['text'];
    	$from_lang = $_POST['from_lang'];
    	
    	$result = array();
    	
    	foreach (get_multilang_codes() as $lang_code)
    	{
    		if($lang_code == $from_lang) continue;
    		
    		$lp = "{$from_lang}|{$lang_code}";
    		$result[$lang_code] = $this->lang_model->translate($text,$lp,'html');
    	}
    	
    	echo json_encode($result);
    }
    
    /**
     * Quick translation system codes.
     *
     * @param $lang_code
     * @return void
     */
    public function translateAll($lang_code)
    {
        $this->lang_model->translateAll($lang_code);
    }
	
}