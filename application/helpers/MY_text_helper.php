<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Divide text on parts less then $chars_limit.
 *
 * @param string $text
 * @param integer $chars_limit
 * @param string $format
 * @return array
 */
function divide_on_parts($text,$chars_limit,$format='text') 
{
    if(strlen($text)<=$chars_limit) return array($text);
    
    $partsArr = array();

    while (strlen($text)>0)
    {
    	$part = substr($text,0,$chars_limit);
    	
    	$p = 0;
    	
        if($format=='html')
        {
        	$breakers = array("</p>","</div>","<hr>","<hr/>","<hr />","</ul>","</form>","</table>");
        	
        	foreach ($breakers as $break)
        	{
        		$P = strrpos($part,$break);
        		if($P>$p)
        		{
        			$p = $P+strlen($break)-1;
        		}
        	}

        }
        else 
        {
        	$breakers = array(".","!","?","\n","...",";");
        	
        	foreach ($breakers as $break)
        	{
        		$P = strrpos($part,$break);
        		if($P>$p)
        		{
        			$p = $P+strlen($break)-1;
        		}
        	}
        }
        
        if(!$p) $p = strrpos($part," ");
        if(!$p) $p = $chars_limit-1;
        
        $partsArr[] = substr($text,0,$p+1);
    	$text = substr($text,$p+1);
    } 
    
    return $partsArr;
    
}

/**
 * Find and close unclosed (x)HTML tags.
 *
 * @param string $text
 * @return string
 */
function close_tags($text) 
{
    $patt_open    = "%((?<!</)(?<=<)[\s]*[^/!>\s]+(?=>|[\s]+[^>]*[^/]>)(?!/>))%";

    $patt_close    = "%((?<=</)([^>]+)(?=>))%";

    if (preg_match_all($patt_open,$text,$matches))
    {
        $m_open = $matches[1];

        if(!empty($m_open))
        {
            preg_match_all($patt_close,$text,$matches2);

            $m_close = $matches2[1];

            if (count($m_open) > count($m_close))
            {
                $m_open = array_reverse($m_open);

                foreach ($m_close as $tag) @$c_tags[$tag]++;

                foreach ($m_open as $tag)    if (@$c_tags[$tag]--<=0) $text.='</'.$tag.'>';
            }
        }
    }

    return $text;

}

/**
 * Words Limiter for (x)HTML content.
 *
 * @param string $str
 * @param integer $limit
 * @param string $end_char
 * @return string
 */
function word_limiter_html($str, $limit, $end_char = '&#8230;') 
{  
	//remove images
	$str = preg_replace('/<img[^>]+./','', $str);  
	
	//remove <sctipt> tags with content inside!!!
	$str = preg_replace('/<script[^>]*>.*<\/script>/iUs','', $str);  

	//strip tags that not in allowed list
    $str = strip_tags($str, '<p><a><address><a><abbr><acronym><b><big><blockquote><br><caption><cite><class><code><col><del><dd><div><dl><dt><em><font><h1><h2><h3><h4><h5><h6><hr><i><img><ins><kbd><li><ol><p><pre><q><s><span><strike><strong><sub><sup><table><tbody><td><tfoot><tr><tt><ul><var>');
    
    //limit words
    $str = word_limiter($str, $limit, $end_char);

    //close not closed tags
    $str = close_tags($str);
	
    return $str;

}


/**
 * Limit (x)HTML till "<!-- more -->"
 *
 * @param string $str
 * @param integer $limit
 * @param string $end_char
 * @return string
 */
function word_limiter_more($str, $limit, $end_char = '&#8230;') 
{
    //if there is no "more break" in string than use limit by words count
    if( !($more_pos = strpos($str,'<!-- more -->')) ) return word_limiter_html($str, $limit, $end_char);
    
    //get string till "more break"
    $more_str = substr($str,0,$more_pos);
	
    //add to string "end char"
	$more_str .= $end_char;
    
    //close not closed tags
    $more_str = close_tags($more_str);
	
    return $more_str;
}