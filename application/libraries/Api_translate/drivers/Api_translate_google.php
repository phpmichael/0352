<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * API Translate
 *
 * @package api_translate
 * @author Michael Kovalskiy
 */

// ------------------------------------------------------------------------

/**
 * API Translate Google Driver
 *
 * @subpackage	Drivers
 */
class Api_translate_google extends CI_Driver {

	public $max_chars_amount = 5000;
    
    /**
	 * Constructor
	 *
	 * @return Api_translate_google
	 */
	public function __construct()
	{
		log_message('debug', 'Api_translate_google Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Translate text with with Google Service.
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
    	
    	$tmp = explode('|',$lp);
    	$from_lang = $tmp[0];
    	$to_lang = $tmp[1];
    	
    	$text = urlencode($text);
    	
    	$url = "http://translate.google.com/translate_a/t?client=x&sl={$from_lang}&tl={$to_lang}&ie=UTF-8&oe=UTF-8";
    	
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "text=".$text);
		
		$json = curl_exec($ch);
		
		curl_close($ch);
		
		$data = json_decode($json);
		
		$trans = "";
		
		foreach ($data->sentences as $record)
		{
			if($trans) $trans .= "\r\n";
			$trans .= $record->trans;
		}
		
		return $trans;
    }
}

/* End of file Api_translate_google.php */
/* Location: ./application/libraries/Api_translate/drivers/Api_translate_google.php */