<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * API Translate
 *
 * @package api_translate
 * @author Michael Kovalskiy
 */

// ------------------------------------------------------------------------

/**
 * API Translate Yandex Driver
 *
 * @subpackage	Drivers
 */
class Api_translate_yandex extends CI_Driver {

	public $max_chars_amount = 4000;
    
    /**
	 * Constructor
	 *
	 * @return Api_translate_yandex
	 */
	public function __construct()
	{
		log_message('debug', 'Api_translate_yandex Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Translate text with with Yandex API.
	 * 
	 * @param string $text
	 * @param string $lp
	 * @param string $format
	 * @return string
	 */
	public function translate($text,$lp="auto|en",$format='text')
    {
    	if( !trim($text) ) return '';
    	
    	$lp = strtr(strtolower($lp),array('ua'=>'uk'));
    	$lp = str_replace('|','-',$lp);
    	
    	$allowedTranslate = array(
    	   'en-ru',
    	   'ru-en',
    	   'ru-uk',
    	   'uk-ru',
    	   'pl-ru',
    	   'ru-pl',
    	   'tr-ru',
    	   'ru-tr',
    	   'de-ru',
    	   'ru-de'
    	);
    	
    	if( !in_array($lp,$allowedTranslate) ) return '';
    	
    	$text = urlencode($text);
    	
    	$url = "http://translate.yandex.net/api/v1/tr.json/translate?lang={$lp}&text={$text}&format={$format}";
    	
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$json = curl_exec($ch);
		
		$data = json_decode($json);
		
		$trans = "";
		
		foreach ($data->text as $line)
		{
			if($trans) $trans .= "\r\n";
			$trans .= $line;
		}
		
		curl_close($ch);
		
		return $trans;
    }
}

/* End of file Api_translate_yandex.php */
/* Location: ./application/libraries/Api_translate/drivers/Api_translate_yandex.php */