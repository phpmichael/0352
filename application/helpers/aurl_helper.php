<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Generate admin link with sort and pagination segments.
 *
 * @param bool|string $uri
 * @param bool|string $action
 * @param bool|string $orderby
 * @param bool|string $orderseq
 * @param bool|int $offset
 * @return string
 */
function alink($uri = FALSE, $action = FALSE, $orderby = FALSE, $orderseq = FALSE, $offset = FALSE)
{
    $CI =& get_instance();
    
    if($uri===FALSE) $uri = $CI->_getBaseURI();
    if($action===FALSE) $action = $CI->_getMethod();
    if($orderby===FALSE) $orderby = $CI->_getSegmentOrderby();
	if($orderseq===FALSE) $orderseq = $CI->_getSegmentOrderseq();
	if($offset===FALSE) $offset = $CI->_getSegmentOffset();
    
    return "{$uri}/{$action}/{$orderby}/{$orderseq}/{$offset}";
}

/**
 * Generate admin url with sort and pagination segments.
 *
 * @param string $action
 * @return string
 */
function aurl($action='index')
{
    return site_url(alink(FALSE, $action));
}

/**
 * Generate link for delete all selected records in table.
 * 
 * @return string
 */
function anchor__Delete_Selected()
{
	$CI =& get_instance();
	
	$str = language('actions').": ";
	
    if(!userAccess($CI->_getController(),'delete')) return $str;
	return $str."<a href=\"javascript:if( confirm('".language('are_you_sure')."') ) document.form.submit();\">".language('delete_selected')."</a>";
}

/**
 * Generate link for sort data in table.
 * 
 * @param string $orderby
 * @param string $title
 * @return string
 */
function anchor_title($orderby,$title)
{
	$CI =& get_instance();
	
	if( ($CI->_getSegmentOrderby()==$orderby) && ($CI->_getSegmentOrderseq()=='asc') )
	{
		$orderseq = "desc";
		$arrow = " <img src='".$CI->_getTheme(true)."images/arrow_down.gif' alt='asc' />";
	}
	elseif( ($CI->_getSegmentOrderby()==$orderby) ) 
	{
		$orderseq = "asc";
		$arrow = " <img src='".$CI->_getTheme(true)."images/arrow_up.gif' alt='desc' />";
	}
	else 
	{
		$orderseq = "asc";
		$arrow = "";
	}
	
	return anchor(alink(FALSE,'index',$orderby,$orderseq,FALSE),$title.$arrow);
}

/**
 * Generate link for sort data in table.
 * 
 * @param string $orderby
 * @return string
 */
function anchor_field_title($orderby)
{
	$CI =& get_instance();
	
	return ($field_title = $CI->_getFieldTitle($orderby)) ? anchor_title($orderby,$field_title) : '';
}

/**
 * Generate link for process (edit/delete) record in table.
 * 
 * @param string $action
 * @param integer $item
 * @param string $params_string
 * @return string
 */
function anchor_admin($action,$item,$params_string='')
{
	$CI =& get_instance();
    
    //what right need to check
    if(in_array($action,array('edit','questions_edit','answers_edit','filters_edit','edit_tags','edit_rights','change_category','values_edit','containers_edit','inputs_edit')))
	{
		$right = 'edit';
	}
	elseif(in_array($action,array('deleteimage','delete_additional_image','delete')))
	{
		$right = 'delete';
	}
	elseif(in_array($action,array('view','chart','table')))//"chart" and "table" for reports
	{
		$right = 'view';
	}
	
	//check right
	if(!userAccess($CI->_getController(),$right)) return '';
	
	//what class set for link
	if($action=='edit_tags')
	{
	    $css_class = "edit-tags";
	}
	elseif($action=='edit_rights')
	{
	    $css_class = "edit-rights";
	}
	else 
	{
	    $css_class = $right."-record";
	}
	
	$title = strtr($action,
				array(
					'questions_edit' => language('edit'),
					'answers_edit' => language('edit'),
					'filters_edit' => language('edit'),
					'values_edit' => language('edit'),
					'containers_edit' => language('edit'),
					'inputs_edit' => language('edit'),
					'edit_tags' => language('edit_tags'),
					'edit_rights' => language('edit_rights'),
					'change_category' => language('change_category'),
					'deleteimage' => language('delete_image'),
					'delete_additional_image' => language('delete_image'),
					'edit' => language('edit'),
					'delete' => language('delete'),
					'view' => language('view'),
					'chart' => language('chart'),
					'table' => language('table'),
				)
			);
			
    $action = str_replace(" ","_",$action);
		
    if($right=='delete') return "<a href='javascript: if(confirm(\"".language('are_you_sure')."\")) location.href=\"".site_url(alink(FALSE,$action)."/".$item.$params_string)."\"' class='{$css_class}' title='{$title}'>{$title}</a>";
    else return anchor(alink(FALSE,$action)."/".$item.$params_string, $title, " class='{$css_class}' title='{$title}' ");
}

/**
 * Generate link for delete record in table.
 * 
 * @param integer $item
 * @return string
 */
function anchor_delete($item)
{
	return anchor_admin('delete',$item);
}

/**
 * Generate link for edit record in table.
 * 
 * @param integer $item
 * @return string
 */
function anchor_edit($item)
{
	return anchor_admin('edit',$item);
}

// === Make View Link === //
/**
 * Generate link for view record in table.
 * 
 * @param integer $item
 * @return string
 */
function anchor_view($item)
{
	return anchor_admin('view',$item);
}