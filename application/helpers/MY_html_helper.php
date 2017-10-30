<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Image with static URL
 *
 * Generates an <img /> element
 *
 * @access	public
 * @param	mixed
 * @return	string
 */
if ( ! function_exists('img'))
{
    function img($src = '', $index_page = FALSE)
    {
        if ( ! is_array($src) )
        {
            $src = array('src' => $src);
        }

        // If there is no alt attribute defined, set it to an empty string
        if ( ! isset($src['alt']))
        {
            $src['alt'] = '';
        }

        if ( (isset($src['width']) && $src['width']=='?') || (isset($src['height']) && $src['height']=='?') )
        {
            $source = isset($src['src']) ? $src['src'] : $src['data-src'];
            $info = getImageInfo($source);
            if ( $src['width']=='?' ) $src['width'] = $info['width'];
            if ( $src['height']=='?' ) $src['height'] = $info['height'];
        }

        $img = '<img';

        foreach ($src as $k=>$v)
        {

            if (in_array($k, array('src','data-src')) AND strpos($v, '://') === FALSE)
            {
                $CI =& get_instance();

                if ($index_page === TRUE)
                {
                    $img .= ' '.$k.'="'.$CI->config->site_url($v).'"';
                }
                else
                {
                    $img .= ' '.$k.'="'.$CI->config->slash_item('static_url').$v.'"';
                }
            }
            else
            {
                $img .= " $k=\"$v\"";
            }
        }

        $img .= '/>';

        return $img;
    }
}

/**
 * Return image info: width, height, type
 * @param string $path
 * @return array
 */
function getImageInfo($path)
{
    $info = array();
    if ( function_exists('getimagesize') )
    {
        if (FALSE !== ($D = @getimagesize($path)))
        {
            $types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');

            $info['width']		= $D['0'];
            $info['height']		= $D['1'];
            $info['type']		= ( ! isset($types[$D['2']])) ? 'unknown' : $types[$D['2']];
            $info['size_str']	= $D['3'];  // string containing height and width
        }
    }
    return $info;
}