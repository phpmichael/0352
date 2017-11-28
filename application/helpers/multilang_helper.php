<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Returns text by code (for active language).
* 
* @param string $code
* @return string
*/
function language($code)
{
	$CI =& get_instance();
	return $CI->lang_model->getByCode($code);
}

/**
* Returns text by lang ID (for active language).
* 
* @param integer $lang_id
* @return string
*/
function multilang($lang_id)
{
	$CI =& get_instance();
	return $CI->lang_gen_model->getLangText($lang_id);
}

/**
 * Return codes of languages.
 *
 * @return array
 */
function get_multilang_codes()
{
    $CI =& get_instance();
    return $CI->lang_gen_model->getLangCodes();
}

/**
 * Return array lang_code=>language.
 *
 * @param bool $translate
 * @return integer
 */
function get_languages_list($translate=FALSE)
{
    $CI =& get_instance();
    
    $langArr = $CI->lang_model->getLangArr();
    
    if($translate)
    {
        foreach ($langArr as &$language)
        {
            $language = language($language);
        }
    }
    
    return $langArr;
}

/**
 * Return char for list based on current language
 * @param int $i
 * @return string
 */
function lang_chr($i)
{
    $CI =& get_instance();

    $lang = $CI->lang_model->getCurrentLangCode();

    if($lang == 'UA') return mb_substr('АБВГДЕЄЖЗ', $i, 1);
    return chr(65+$i);
}