<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Dump PHP var.
* 
* @param mixed $var
* @return string
*/
function dump($var) 
{
	echo "<hr><div style='text-align:left; margin-left:90pt;'>";
	echo "<pre>";

	if (is_array($var)) 
	{
		print_r($var);
	} 
	else 
	{
		var_dump($var);
	}

	echo "</pre>";
	echo "</div><hr>";
}

/**
* Sort tags by their amount in table.
* 
* @param array $a
* @param array $b
* @return integer
*/
function SortTags($a,$b)
{
	if($a['amount']>$b['amount']) return 1;
	if($a['amount']<$b['amount']) return -1;
	return 0;
}

/**
* Lowercase string. For non-latin chars PHP function strtolower works incorrect.
* 
* @param string $str
* @param string $charset
* @return string
*/
function lowercase($str,$charset="UTF-8")
{
	//return mb_convert_case($str, MB_CASE_LOWER, $charset);//need to be installed
	return $str;
}

/**
* Load model inside model.
* 
* @param string $model_name
* @return mixed
*/
function load_model($model_name)
{
  $CI =& get_instance();
  $CI->load->model($model_name);
  return $CI->$model_name;
}

/**
 * Wordwrap text (utf-8).
 *
 * @param string $str
 * @param integer $len
 * @param string $what
 * @return string
 */
function utf8_wordwrap($str,$len,$what)
{
	$from=0;
	$total='';
	$str_length = preg_match_all('/[\x00-\x7F\xC0-\xFD]/', $str, $var_empty);
	$while_what = $str_length / $len;
	$i=0;
	while($i <= round($while_what))
	{
		$string = preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
		                       '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
		                       '$1',$str);
		$total .= $string.$what;
		$from = $from+$len;
		$i++;
	}
	return $total;
}

/**
 * Return relative url (according to config item).
 *
 * @param string $uri
 * @return string
 */
function relative_url($uri = '')
{
	$CI =& get_instance();
	
	$suffix = ($CI->config->item('url_suffix') == FALSE) ? '' : $CI->config->item('url_suffix');
	$relative_url = $CI->config->item('relative_url');
	
	if($uri == '') return $relative_url;
	else return str_replace("//","/",$relative_url.$uri.$suffix);
}

/**
 * Creates an anchor based on the local URL.
 *
 * @param	string	the URL
 * @param	string	the link title
 * @param	mixed	any attributes
 * @return	string
 */	
function anchor_base($uri, $title, $attributes='')
{
    $CI =& get_instance();
    
    return anchor($CI->_getBaseURL().$uri, $title, $attributes);
}

/**
 * Make currency exchange.
 *
 * @param float $price
 * @param bool $show_symbol
 * @param bool|string(3) $code
 * @return string
 */
function exchange($price,$show_symbol=TRUE,$code=FALSE)
{
	$currency_model = load_model('currency_model');
	return $currency_model->exchange($price,$show_symbol,$code);
}

/**
 * Check if logged user has right for section.
 *
 * @param string $section
 * @param string $right
 * @return bool
 */
function userAccess($section,$right)
{
	$groups_model = load_model('groups_model');
	return $groups_model->userAccess($section,$right);
}

/**
 * Check if logged user has right for at least one of sections.
 *
 * @param array $sections
 * @param string $right
 * @return bool
 */
function userAccessSomeOf(array $sections,$right)
{
    foreach ($sections as $section)
    {
        if(userAccess($section,$right)) return TRUE;
    }
    return FALSE;
}

/**
 * Convert multi array to simple $field=>$value array.
 *
 * @param string $field
 * @param string $value
 * @param array $array
 * @return array
 */
function multi2singleArray($field,$value,array $array)
{
	$list = array();
	
    foreach ($array as $record)
    {
        $list[$record[$field]] = $record[$value];
    }
    
    return $list;
}