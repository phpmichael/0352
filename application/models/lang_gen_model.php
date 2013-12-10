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
class Lang_gen_model extends Base_model
{
	//name of table
	protected $c_table = 'lang_gen';
	
	//return all columns of lang_gen table or just lang codes (like EN,UA,RU etc)
	private $return_all_columns = TRUE;
	
	/**
	 * Return array of language short codes.
	 *
	 * @return array
	 */
	public function getLangCodes()
	{
	    return $this->lang_model->getLangCodes();
	}
	
	/**
	 * Return short language code by language name.
	 *
	 * @param string $language
	 * @return string
	 */
	public function getLangCodeByLanguage($language)
	{
	    return $this->lang_model->getLangCodeByLanguage($language);
	}

    /**
     * Return text by ID for currect language.
     *
     * @param integer $lang_id
     * @param bool|string $lang_code
     * @return string
     */
	public function getLangText($lang_id,$lang_code=FALSE)
	{
        $CI =& get_instance();
	    if(!$lang_code) $lang_code = $this->getLangCodeByLanguage($CI->config->item('language'));
	    $record = $this->db->get_where($this->c_table, array('id' => $lang_id))->row_array();
	    return $record[$lang_code];
	}
	
	/**
	 * Find record by language and text.
	 *
	 * @param string $lang
	 * @param string $text
	 * @return array
	 */
	/*public function getLangIdByText($lang,$text)
	{
	    $record = $this->db->get_where($this->c_table,array($lang=>$text))->row_array();
	    return $record['id'];
	}*/
	
	/**
	 * Find slug multidata.
	 *
	 * @param string $lang
	 * @param string $slug
	 * @param string $table
	 * @return array
	 */
	public function getSlugMultiData($lang,$slug,$table)
	{
	    return $this->db->get_where($this->c_table,array('is_slug'=>1,$lang=>$slug,'`table`'=>$table))->row_array();
	}
	
	/**
	 * Add data to table.
	 *
	 * @param array $data
	 * @return integer
	 */
	public function addMultilang(array $data)
	{
		//return $this->insertOrUpdate($data);
		
		if( isset($data['id']) ) unset($data['id']);
		return $this->insert($data);
	}
	
	/**
	 * Update data in table.
	 *
	 * @param array $data
	 * @param integer $lang_id
	 * @return integer
	 */
	public function updateMultilang(array $data, $lang_id)
	{
		$data['id'] = $lang_id;
	    return $this->insertOrUpdate($data);
	}
	
	/**
	 * Return text for all languages.
	 *
	 * @param integer $lang_id
	 * @return array
	 */
	public function getMultilangData($lang_id)
	{
	    $record = $this->db->get_where($this->c_table, array( $this->id_column => $lang_id ))->row_array();
	    
	    if(empty($record)) return array();
	    
	    if( !$this->return_all_columns ) unset($record['id'],$record['is_slug'],$record['table']);
	    
	    return $record;
	}
	
	/**
	 * Set if need return all colimns or no.
	 *
	 * @param bool $switch
	 */
	public function setReturnAllColumns($switch)
	{
		$this->return_all_columns = $switch;
	}

    /**
     * Check if record in lang_gen table exists.
     *
     * @param array $langArr
     * @param bool|string $table
     * @return integer|bool
     */
	public function exists(array $langArr, $table=FALSE)
	{
		foreach ($langArr as $lang=>$text)
		{
		    if(in_array($lang,get_multilang_codes())) $whereArr[$lang] = $text;
		}
	    
		if($table) $whereArr['table'] = $table;
		
		$record = $this->db->get_where($this->c_table, $whereArr )->row_array();
		
		if($record) return $record['id'];
		else return FALSE;
	}
	
}