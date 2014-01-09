<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('base_url'))
{
    /**
     * Create url for static files: js, css, images etc.
     * @return mixed
     */
    function static_url()
    {
        $CI =& get_instance();
        return $CI->config->slash_item('static_url');
    }
}