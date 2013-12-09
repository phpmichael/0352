<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * API Translate
 *
 * @package api_translate
 * @author Michael Kovalskiy
 */

// ------------------------------------------------------------------------

/**
 * API Translate MyMemory Driver
 *
 * @subpackage	Drivers
 */
class Api_translate_mymemory extends CI_Driver {
    
	public $max_chars_amount = 1000;
    
    /**
	 * Constructor
	 *
	 * @return Api_translate_mymemory
	 */
	public function __construct()
	{
		log_message('debug', 'Api_translate_mymemory Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Translate text with with MyMemory API.
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
    	
    	$text = urlencode($text);
    	
    	$url = "http://mymemory.translated.net/api/get?q={$text}&langpair={$lp}";
    	
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$json = curl_exec($ch);
		//dump($json);//exit;
		curl_close($ch);
		
		$data = json_decode($json);
		
		if($data->responseStatus=='200') return $data->responseData->translatedText;
		else log_message("error","Translation Error. Status: ".$data->responseStatus.". Details: ".$data->responseDetails);
    }
}

/* End of file Api_translate_mymemory.php */
/* Location: ./application/libraries/Api_translate/drivers/Api_translate_mymemory.php */