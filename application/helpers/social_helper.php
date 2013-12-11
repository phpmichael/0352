<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Show button for add to social networks.
 *
 * @param string $button_name (vkontakte,facebook,twitter etc)
 * @param array $social_params
 * @return bool|void
 */
function social_button($button_name,array $social_params=array())
{
	if(!$button_name) return FALSE;
	
	$CI =& get_instance();
	
	//if(!isset($social_params['button_title'])) $social_params['button_title'] = language('share_with_friends');
	if(!isset($social_params['page_url'])) $social_params['page_url'] = current_url();
	if(!isset($social_params['button_size'])) $social_params['button_size'] = (isset($CI->settings_model['social_buttons_default_size']))?$CI->settings_model['social_buttons_default_size']:'24x24';
	
	load_theme_view('inc/social_buttons/'.$button_name,array('social_params'=>$social_params));
}

/**
 * Show list of social buttons.
 *
 * @param array $names
 */
function social_buttons(array $names=array())
{
	if(empty($names))
	{
		$CI =& get_instance();
		
		$names = explode(',',@$CI->settings_model['default_social_buttons']);
	}
	
	foreach ($names as $name)
	{
		echo ' ';
		social_button($name);
	}
}