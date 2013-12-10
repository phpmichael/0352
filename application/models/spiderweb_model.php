<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for spiderweb table.
 * 
 * @package spiderweb  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Spiderweb_model extends Base_model
{
	//name of table
	protected $c_table = 'spiderweb';
	//name of primary field
	protected $id_column = 'data_key';
	
	
	//limit for select content records
    //private $limit = 10000;
    //regular expression for parse links
    private $link_regexp = "/<a\s[^>]*href=([\"\']??)([^\" >]*?)\\1[^>]*>(.*)<\/a>/siU";
    
    private $domains_need_body = array('imdb.com');
    

    /**
     * Delete record by primary key.
     *
     * @param string(16) $data_key
     */
    public function DeleteId($data_key)
    {
        $record = $this->getOneById($data_key);
        
        //check if there still is the same link+title combination (duplication)
        if( !$this->db->get_where($this->c_table,array('link'=>$record['link'],'title'=>$record['title'],$this->id_column=>'!='.$data_key))->row_array() )
        {
           $this->removeLinkFromAllContent($record['table'],$record['link'],$record['title']); 
        }
        
        parent::DeleteId($data_key);
    }
    
    /**
     * Remove link from all content records.
     *
     * @param string $table
     * @param string $link
     * @param string $title
     */
    private function removeLinkFromAllContent($table,$link,$title)
    {
    	$this->linkReplace($table,$link,$title,'\\4');
    }
    
    /**
     * Make replacement link in content.
     *
     * @param string $table
     * @param string $link
     * @param string $title
     * @param string $replacement
     */
    private function linkReplace($table,$link,$title,$replacement)
    {
    	$q_link = preg_quote($link);
    	$q_title = preg_quote($title);
    	
    	//$qm_title = preg_replace("/\s+/","[[:space:]]+",trim($q_title));//MySQL spacer character
    	
    	
    	$this->c_table = $table;
    	load_model($this->c_table.'_model');
    	$lang = strtoupper($this->CI->_getInterfaceLang(TRUE));
    	
    	//multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect());
		$this->_buildMultilangJoin(FALSE);
		
		$this->db->like("`lang_gen_body`.`$lang`",$link,'both');
		$this->db->like("`lang_gen_body`.`$lang`",$title,'both');
        
        $records = $this->db->get($this->c_table)->result_array();
    	//dump($this->db->last_query());exit;
    	//dump($records);exit;
    	foreach ($records as $record)
    	{
    		$body = preg_replace("[<a(\s[^>]*)href=([\"\']??){$q_link}\\2([^>]*)>(\s*{$q_title}\s*)<\/a>]siU",$replacement,$record['body']);
    		
    		if( $record['body'] != $body ) 
    		{
    		    $data['body'][$lang] = $body;
    		    $data['body_lang_id'] = $record['body_lang_id'];
    		    $data['id'] = $record['id'];
    		    //dump($data['id']);exit;
    		    $this->CI->{$this->c_table.'_model'}->Update($data,FALSE);
    		}
    	}
    	
    	$this->c_table = 'spiderweb';
    }
    
    /**
     * Update record.
     *
     * @param array $post
     * @return void
     */
    public function update($post)
	{
	    $record = $this->getOneById($post[$this->id_column]);
	    
        $this->updateLinkInAllContent($record['table'],$record['link'],$record['title'],$post['link'],$post['title']);
        
        $post['httpstatus'] = $this->getLinkStatus($post['link']);
	    
	    parent::update($post);
	}

    /**
     * Update link in all content records.
     *
     * @param string $table
     * @param string $link
     * @param string $title
     * @param string $new_link
     * @param string $new_title
     * @return bool
     */
    private function updateLinkInAllContent($table,$link,$title,$new_link,$new_title)
    {
    	//if link and title not changed
    	if( $link==$new_link && $title==$new_title ) return FALSE;
    	
    	//if title not changed
    	if( $title==$new_title ) $new_title = '\\4';
    	
    	$replacement = '<a\\1href="'.$new_link.'"\\3>'.$new_title.'</a>';
    	
    	$this->linkReplace($table,$link,$title,$replacement);

        return TRUE;
    }
    
    
    /**
     * Check if combination of link+title already exists in table.
     *
     * @param string $table
     * @param string $link
     * @param string $title
     * @return array
     */
	private function exists($table, $link, $title)
	{
        return $this->db->get_where($this->c_table,array('table'=>$table,'link'=>$link,'title'=>$title))->row_array();
	}
	
	/**
	 * Add new link with title.
	 *
	 * @param array $data
	 * @return bool|integer
	 */
	private function add(array $data)
	{
		//if empty table or link or title
		if(empty($data['table']) || empty($data['link']) || empty($data['title'])) return false;
		
		//check if record already exists
		if( $this->exists($data['table'], $data['link'], $data['title']) ) return false;
		
		return parent::Insert($data);
	}
	
	/**
	 * Find all links in content and save in table.
	 *
	 */
	public function parse($table, $remove_links=FALSE)
	{	
		$model = $table.'_model';
		
		$records = $this->$model->getAll();
		
		foreach ($records as $record)
    	{
    		//parse links
    		preg_match_all($this->link_regexp,$record['body'],$matches,PREG_SET_ORDER);
    		
    		//save links in table
    		if(!empty($matches))
    		{
	    		foreach ($matches as $match)
	    		{
	    			$data['table'] = $table;
	    			$data['link'] = $this->fixLink($match[2]);
		    		$data['title'] = $this->fixTitle($match[3]);
		    		$data['httpstatus'] = $this->getLinkStatus($data['link'],true);

		    		$this->add($data);
	    		}
    		}
    		
    		//remove links from content
    		if($remove_links) $this->removeLinks($record);
    	}
	}
	
	/**
	 * Make corrections in link.
	 *
	 * @param string $link
	 * @return string
	 */
	private function fixLink($link)
	{
		$link = trim($link);
		//$link = preg_replace("[^mailto:+]i","mailto:",$link);//fix mailto::
		//$link = preg_replace("[^http://%20]i","http://",$link);//fix http://\%20
		//$link = preg_replace("[(\.\./)+]","",$link);//remove "../" recursion from the begin of link
		
		return $link;
	}
	
	/**
	 * Make corrections in links.
	 *
	 */
	public function fixAllLinks()
	{
		$records = $this->getAll();
		
		foreach ($records as $record)
    	{
    		$record['link'] = $this->fixLink($record['link']);
    		
    		parent::Update($record);
    	}
	}
	
	/**
	 * Make corrections in title.
	 *
	 * @param string $title
	 * @return string
	 */
	private function fixTitle($title)
	{
		$title = trim($title);
		
		
		return $title;
	}
	
	/**
	 * Make corrections in titles.
	 *
	 */
	public function fixAllTitles()
	{
		$records = $this->getAll();
		
		foreach ($records as $record)
    	{
    		$record['title'] = $this->fixTitle($record['title']);
  
    	}
	}
	
	/**
	 * Remove all links from some content.
	 *
	 * @param object $content
	 */
	/*public function removeLinks($content)
	{
		$data['content'] = preg_replace($this->link_regexp,"\\3",$content->content);
		
		Zend_Registry::get('content_table')->update($data,"`content_id`={$content->content_id}");
		
		return $data['content'];
	}*/
	
	/**
	 * Remove all links from all content.
	 *
	 */
	/*public function removeAllLinks()
	{
		$contents = Zend_Registry::get('content_table')->getAll();
		//$contents = Zend_Registry::get('content_table')->get("content_id=238",'content_id','asc',9999,0);
		
		foreach ($contents->getCurrentItems() as $content)
    	{
    		$this->removeLinks($content);
    	}
	}*/
	
	/**
	 * Set links HTTP status.
	 *
	 */
	/*public function setAllLinksStatus()
	{
		$records = $this->getAll();
		//$records = $this->get("httpstatus=0");
		
		foreach ($records->getCurrentItems() as $record)
    	{
    		$data['httpstatus'] = $this->getLinkStatus($record->link);
    		
    		//save HTTP status in table
    		$this->update($data,"`id`={$record->id}");
    	}
	}*/
	
	/**
	 * Check link HTTP status.
	 *
	 * @param string $link
	 * @param bool $use_status_from_db take HTTP status from db if the same link already exists
	 * @return integer
	 */
	private function getLinkStatus($link,$use_status_from_db=false)
	{
	    if( $use_status_from_db )
	    {
	        $linkExists = $this->db->get_where($this->c_table,array('link'=>$link))->row_array();
	        if($linkExists) return $linkExists['httpstatus'];
	    }
	    
		//$domain = substr($this->CI->config->item('base_url'),0,-1);
		$domain = $this->CI->config->item('base_url');
		
		//remove domain name from link
		$link = str_replace($domain,'',$link);
		//&amp; => &
		$link = str_replace("&amp;","&",$link);
		//remove hash string all after "#"
		if(strpos($link,"#")) $link = substr($link,0,strpos($link,"#"));
		
		if(preg_match("/^(mailto|javascript|ftp[s]?):/i",$link))//if link has mailto:
		{
			return 1;//could not check
		}
		
		if(preg_match("/^#/",$link))//if it is anchor like #some_anchor
		{
			return 1;//no need to check
		}
		
		if(preg_match("/^\?/",$link))//if it starts from "?"
		{
			return 1;//no need to check
		}
		
		if($link == '/' || $link == '')
		{
			return 200;//no need to check
		}
		
		if( !preg_match("[^http[s]?://]i",$link) )//if it is relative link
		{
			$link = $domain.$link;
		}
		//dump($link);flush();ob_flush();
		
		$ch = curl_init($link);
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
	    curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.52 Safari/536.5");
	    curl_setopt($ch,CURLOPT_NOBODY, 1);
	    curl_exec($ch);

		/*dump($result);
		dump(curl_getinfo($ch, CURLINFO_HTTP_CODE));
		exit;*/
		
		return curl_getinfo($ch, CURLINFO_HTTP_CODE);
	}
	
	/**
	 * Add suggested links for some content item.
	 *
	 * @param object $content
	 * @return string
	 */
	/*public function suggestLinksForContentItem($content)
	{
		//case 1 - slow
		//$records = $this->get(" (SELECT content FROM content WHERE content_id='{$content->content_id}') LIKE CONCAT('%',title,'%') ",'length(title)','desc, title asc',$this->limit,0);
		//$linksArr = $records->getCurrentItems();
		
		//get page info
		$page = Zend_Registry::get('pages_table')->getPageInfo($content->page_id);
		
		//case 2 - fast
		$content_data = mysql_escape_string(preg_replace("/\r?\n/","",$content->content));//escape content
		//search spiderweb.title in content (like filter more exact), and not select link to current page
		$SQL = "
		SELECT title, link FROM spiderweb 
		WHERE MATCH (title) AGAINST ( '{$content_data}' ) 
		AND '{$content_data}' LIKE CONCAT('%',title,'%') 
		AND link != '".mysql_escape_string($page->slug).".html' 
		ORDER BY length(title) DESC, title ASC
		";
		$linksArr = $this->getAdapter()->query($SQL)->fetchAll();
		
		return $this->suggestLinks($content->content,$linksArr);
	}*/
	
	/**
	 * Get suggested links from spiderweb table for content.
	 *
	 * @param string $text
	 * @param array $linksArr
	 * @return string
	 */
	/*private function suggestLinks($text,$linksArr)
	{
		
		foreach ($linksArr as $key=>$l)
		{
			preg_match_all( "[</a>(.*)<a ]siU", "</a>".$text."<a ", $matches );
			
			if( !empty($matches[1]) )
			{
				$parts = array_unique($matches[1]);
				
				foreach ($parts as $part)
				{
					$link = str_replace('"','',$l->link);
					$title = $l->title;
					$regexp = "[(?<![\w\.\/\[\$<\@\#\%\&\+\=\{])(".preg_quote($title).")\b(?!([^<]*>))]i";
					
					if( !preg_match($regexp,$part) ) continue;
					
					$replacement = "<span class='suggested-block'>";
					
					$i = 1;
					$nl = @$linksArr[$key+$i];
					while ($l->title == @$nl->title)
					{
						$replacement .= "<a href='javascript:;' class='suggested-variant suggested-variant-{$i}'>{$nl->link}</a>";
						
						$i++;
						$nl = @$linksArr[$key+$i];
					}
					
					if($i>1) $replacement .= "<a href='javascript:;' class='suggested-variant suggested-variant-{$i} suggested-variant-current'>{$l->link}</a>";
					
					$replacement .= "
						<a href=\"{$link}\" class='suggested-link'>\\1</a>
						<a href='javascript:;' class='remove-suggested-link'>{$i}X</a>
					</span>";
					
					$part_with_link = preg_replace(
						$regexp,
						$replacement,
						$part
					);
					
					$text = str_replace($part,$part_with_link,$text);
				}
			}
		}
		
		return $text;
	}*/
	
	/**
	 * Add suggested links in content.
	 *
	 * @param integer $content_id
	 * @param string $content
	 */
	/*public function confirmSuggestedLinks($content_id,$content)
	{
		$content = preg_replace("[<span class=[\"\']suggested-block[\"\']>.*<a href=[\"\']([^\"]*)[\"\'] class=[\"\']suggested-link[\"\']>(.+)</a>.*</span>]isU","<a href=\"\\1\">\\2</a>",$content);
		
		Zend_Registry::get('content_table')->update(array('content'=>$content),"`content_id`='$content_id'");
		
		return $content;
	}*/
	
}