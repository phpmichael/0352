<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Load template from theme folder if it exists, if no - than load regular template.
 *
 * @param string $tpl
 * @param array $data
 * @param bool $return
 * @return void|string
 */
function load_theme_view($tpl,$data = array(), $return = FALSE)
{
    $CI =& get_instance();
    
    if( $exists = file_exists(APPPATH.'views/'.$CI->_getTheme().$tpl.'.php')  )
    {
        return $CI->load->view($CI->_getTheme().$tpl,$data,$return);
    }
    else 
    {
        return $CI->load->view('themes/'.$CI->_getFolder().'default/'.$tpl,$data,$return);
    }
}

/**
 * Return weibsite menu.
 *
 * @param string $menu (left|bottom)
 * @param string $format (list|separator)
 * @return string
 */
function get_menu($menu,$format='list')
{
    $CI =& get_instance();
    
    return $CI->menu_model->build($menu,$format);
}

/**
 * Include javscript file in HTML code.
 *
 * @param string $file
 * @return string
 */
function include_js($file)
{
    return '<script type="text/javascript" src="'.base_url().$file.'"></script>';
}

/**
 * Include CSS file in HTML code.
 *
 * @param string $file
 * @param string $media
 * @return string
 */
function include_css($file,$media='all')
{
    return '<link rel="stylesheet" type="text/css" href="'.base_url().$file.'" media="'.$media.'" />';
}

/**
 * Minify javascript or CSS file and include it in HTML code.
 *
 * @param string $file
 * @param string $type
 * @param string $media
 * @return string
 */
function include_minified($file,$type,$media='all')
{
	if( in_array($type,array('css','js','inline_css','inline_js')) ) //just for CSS and JavaScript files
	{
		if(file_exists($file)) //check if file exists
		{
			if(is_writable(dirname($file))) //check if folder is writable
			{
    			$real_type = str_replace('inline_','',$type);
			    
			    $minified_file = str_replace('.'.$real_type,'.minify.'.$real_type,$file);
			    
			    if( !file_exists($minified_file) || filemtime($file)>filemtime($minified_file) )
    			{
    				$CI =& get_instance();
    				
    				$CI->load->driver('minify');
    				
    				$contents = $CI->minify->$real_type->min($file);
    				
    				$CI->minify->save_file($contents, $minified_file);
    			}
			}
			else $minified_file = $file;
			
			if($type=='css')
			{
				return include_css($minified_file,$media);
			}
			elseif($type=='js') 
			{
				return include_js($minified_file);
			}
			elseif($type=='inline_css') 
			{
			    return inline_css($minified_file,$media);
			}
			elseif($type=='inline_js') 
			{
				return inline_js($minified_file);
			}
		}
	}
	
	return '';
}

/**
 * Minify javascript or CSS files, combine them in one file and include it in HTML code.
 *
 * @param array $combine_files
 * @param string $combined_file
 * @param string $type
 * @param string $media
 * @return string
 */
function include_combined(array $combine_files,$combined_file,$type,$media='all')
{
    if( in_array($type,array('css','js')) ) //just for CSS and JavaScript files
	{
		if(!empty($combine_files)) //array with combine files not empty
		{
    	    $combined_file = str_replace('.'.$type,'.minify.'.$type,$combined_file);
    		
    		$lastmodify = array();
    	    
    		if(is_writable(dirname($combined_file))) //check if folder is writable
    		{
        	    foreach ($combine_files as $key=>$file)
        		{
            	    if(file_exists($file)) //check if file exists
            		{
        			    $lastmodify[] = filemtime($file);
            		}
            		else unset($combine_files[$key]);
        		}
        		
        		if( !file_exists($combined_file) || max($lastmodify)>filemtime($combined_file) )
    			{
    				$CI =& get_instance();
    				
    				$CI->load->driver('minify');
    				
    				$contents = $CI->minify->combine_files($combine_files);
    				
    				$CI->minify->save_file($contents, $combined_file);
    			}
        		
        		if($type=='css')
        		{
        			return include_css($combined_file,$media);
        		}
        		else 
        		{
        			return include_js($combined_file);
        		}
    		}
		}
	}
	
	return '';
}

/**
 * Include code of small CSS file in HTML.
 *
 * @param string $file
 * @param string $media
 * @return string
 */
function inline_css($file,$media='all')
{
    return '<style type="text/css" media="'.$media.'">'.file_get_contents($file).'</style>';
}

/**
 * Include code of small JavaScript file in HTML.
 *
 * @param string $file
 * @return string
 */
function inline_js($file)
{
return '
<script type="text/javascript">
//<![CDATA[
'.file_get_contents($file).'
//]]>
</script>
';
}