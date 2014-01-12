<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Generate archives list.
 *
 * @param string $blog_model
 * @param array $args
 * @return string
 */
function get_archives($blog_model,array $args=array())
{
	if(!$blog_model) 
	{
		//log();
		return FALSE;
	}
	
	$defaults = array(
		'type' => 'monthly', 
		'limit' => 10,
		'format' => 'html', 
		'before' => '<li>',
		'after' => '</li>', 
		'show_amount' => false,
	);
	
	$args = array_merge($defaults,$args);
	
	$CI =& get_instance();
	$CI->lang->load('calendar');
	$archives = $CI->{$blog_model.'_model'}->getArchivesList($args);
	
	$str = "";
	
	if('html'==$args['format'])
	{
		foreach ($archives as $archive)
		{
			$month = ($archive['month']<10)?'0'.$archive['month']:$archive['month'];
			$year = $archive['year'];
			$posts_count = ($args['show_amount'])? " ({$archive['amount']})":"";
			$m = $year.'-'.$month;
			$month_name = date('F',strtotime($m.'-01'));
			$month_name = lang('cal_'.strtolower($month_name));
			
			$str .= $args['before'];
			$str .= "<a href='".site_url($CI->_getInterfaceLang().'/'.$blog_model."/index/date/{$m}")."'>{$month_name} {$year}{$posts_count}</a>";
			$str .= $args['after'];
		}
	}
	
	return $str;
}

/**
 * Show categories tree list.
 *
 * @param string $blog_model
 * @param integer $parent_id
 * @param integer $active_category_id
 * @param array $args
 * @return string
 */
function get_categories_tree($blog_model,$parent_id=0,$active_category_id=0,array $args=array())
{
	if(!$blog_model) return FALSE;

	$CI =& get_instance();
	$CI->load->model($blog_model.'_categories_model');

	//get children categories array
    if( isset($args['cache_time']) && !empty($args['cache_time']) ) //if cache enabled
    {
        if( !($categories = $CI->cache->get($blog_model.'_children_categories_of_'.$parent_id)) ) //check if isset categories in cache
        {
            $categories = $CI->{$blog_model.'_categories_model'}->getTree($parent_id);

            $CI->cache->save($blog_model.'_children_categories_of_'.$parent_id, $categories, $args['cache_time']);//save categories to cache
        }
    }
	else //if cache disabled
    {
        $categories = $CI->{$blog_model.'_categories_model'}->getTree($parent_id);
    }
	
	//deep menu level
	$args['start_level'] = (@$args['start_level']) ? $args['start_level'] : 1;
	$args['level'] = $level = (@$args['level']) ? $args['level'] : $args['start_level'];
	//set CSS class 
	$css_class = " class='level{$level}'";
	
	//set CSS id for menu
	if(!$parent_id && isset($args['root_id'])) $css_id = " id='{$args['root_id']}'";
	else $css_id = "";
	
	//inc level deep
	$args['level']++;
	
	$str = "<ul{$css_id}{$css_class}>";

	foreach ($categories as $categoryItem)
	{
		$category_id = $categoryItem['id'];
		$category = $categoryItem['category'];
		
		if( $active_category_id == $category_id ) $active = " class='active'";	
		else $active = "";
		
		$link_title_prefix = ( empty($categoryItem['children']) ) ? @$args['link_title_prefix_without_children'] : @$args['link_title_prefix_with_children'];
		
		//$link = "<a {$active} href='".site_url($CI->_getInterfaceLang().'/'.$blog_model."/index/category/{$category_id}")."'>{$category}</a>";
		$link = anchor_base("{$blog_model}/index/category/{$category_id}",$link_title_prefix.$category,$active);
		
		if( empty($categoryItem['children']) )
		{
			$str .= "
			<li{$css_class}>
				".$link."
			</li>
			";
		}
		else 
		{
			$str .= "
			<li{$css_class}>
				".$link."
			";
			//recursion
			$str .= get_categories_tree($blog_model,$category_id,$active_category_id,$args);
			$str .= "
			</li>
			";
		}
	}
	
	$str .= "</ul>";
	
	return $str;
}

/**
 * Generate tags cloud.
 *
 * @param string $table
 * @param integer $count_tags
 * @param integer $min_font_size
 * @param integer $max_font_size
 * @return string
 */
function tags_cloud( $table='', $count_tags = 15,$min_font_size = 10,$max_font_size = 18)
{
    $CI =& get_instance();
    if(!$table) $table = $CI->_getCurrentTable();
    
    $tags_model = load_model('tags_model');
    return $tags_model->generateTagCloud($table,$count_tags,$min_font_size,$max_font_size);
}

/**
 * Generate posts calendar.
 *
 * @param string $blog_model
 * @return string
 */
function posts_calendar($blog_model)
{
    $CI =& get_instance();
    return $CI->{$blog_model.'_model'}->buildCalendarBox();
}

/**
 * Return random testimonial
 *
 * @return array
 */
function random_testimonial()
{
    $testimonials_model = load_model('testimonials_model');
    return $testimonials_model->getRandom();
}

/**
 * Return random videos
 *
 * @param $limit
 * @return array
 */
function random_videos($limit)
{
    $videos_model = load_model('videos_model');
    return $videos_model->getRandom($limit);
}

/**
 * Return category ID for details URL. 
 *
 * @param bool $add_slash 
 * @return string
 */
function url_category_addition($add_slash=TRUE)
{
    $CI =& get_instance();
    $slash = ($add_slash) ? '/' : '';
    return ( $CI->uri->segment($CI->_getSegmentsOffset()+3)=='category' ) ? $slash.$CI->uri->segment($CI->_getSegmentsOffset()+4) : '';
}

/**
 * Return url to article details.
 *
 * @param mixed $record
 * @return string
 */
function post_url($record)
{
    $CI =& get_instance();
    
    if(is_array($record)) return site_url($CI->_getBaseURI().'/name/'.$record['slug']);
    else return site_url($CI->_getBaseURI().'/name/'.$record->slug);
}