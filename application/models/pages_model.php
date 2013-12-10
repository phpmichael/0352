<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for pages.
 * 
 * @package pages  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Pages_model extends Base_model 
{
	//name of table
	protected $c_table = "pages";
	//prefix for links
	private $content_prefix = "page/";
	
	/**
	 * Returns page (record) by link. 
	 * 
	 * @param string $link
	 * @return array
	 */
	public function getByLink($link)
	{
	    if(!$link)
		{
			$page = $this->getOneById(1);
		}
		elseif( stristr($link,$this->content_prefix) ) //page/:slug
		{
			$slug = strtr( $link , array($this->content_prefix=>'','.html'=>'') );
			$page = $this->getBySlug($slug);
		}
		else 
		{
			$page = parent::getOneByUnique('link',$link);
		}
		
		return $page;
	}
	
	/**
	 * Return list of content pages' titles.
	 *
	 * @param bool $none
	 * @return array
	 */
	public function getContentPagesTitles($none=TRUE)
	{
		$records = $this->getContentPages();
		$list = array();
		if($none) $list[0] = language('none');
		foreach ($records as $record)
		{
			$list[$record['id']] = $record['page_title'];
		}
		return $list;
	}
	
    /**
     * Return list of content pages.
     *
     * @return array
     */
	private function getContentPages()
	{
		return $this->get("is_content='yes'");
	}
	
	/**
	 * Return page body by link.
	 *
	 * @param string $link
	 * @return string
	 */
	public function getBody($link)
	{
	    $page = $this->getByLink($link);
	    if($page) return $page['body'];
	    else return '';
	}
    
}