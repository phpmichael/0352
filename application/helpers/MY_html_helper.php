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

        $img = '<img';

        foreach ($src as $k=>$v)
        {

            if ($k == 'src' AND strpos($v, '://') === FALSE)
            {
                $CI =& get_instance();

                if ($index_page === TRUE)
                {
                    $img .= ' src="'.$CI->config->site_url($v).'"';
                }
                else
                {
                    $img .= ' src="'.$CI->config->slash_item('static_url').$v.'"';
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