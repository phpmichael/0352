<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * API Translate
 *
 * @package api_translate
 * @author Michael Kovalskiy
 */

// ------------------------------------------------------------------------

/**
 * API Translate Bing Driver
 *
 * @subpackage	Drivers
 */
class Api_translate_bing extends CI_Driver {
    
    public $max_chars_amount = 3000;
    
    private $key = '1ACD3BE725247C9B7BDB84863FD2B6393295320C';
    //https://ssl.bing.com/webmaster/Developers/AppIds/

	/**
	 * Constructor
	 *
	 * @return Api_translate_bing
	 */
	public function __construct()
	{
		log_message('debug', 'Api_translate_bing Initialized');
	}

	// ------------------------------------------------------------------------

	/**
	 * Translate text with with Bing API.
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
    	
    	$url = "http://api.microsofttranslator.com/V2/Ajax.svc/Translate?appId=".$this->key."&from={$from_lang}&to={$to_lang}&text={$text}&contentType=".urlencode("text/html");
    	
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$result = curl_exec($ch);
		
		//=== prepare translated === //
		//get content between "..." (at first could be some wierd non-ascii chars)
		preg_match('/^[^"]*"(.*)"$/',$result,$match);
		$trans = (isset($match[1]))? $match[1] : 'Translation Error.';
		//remove \u000a
		$trans = str_replace("\u000a","",$trans);
		//strip \ before closing tag
		$trans = stripslashes($trans);
		
		curl_close($ch);
		
		return $trans;
    }
}

/* End of file Api_translate_bing.php */
/* Location: ./application/libraries/Api_translate/drivers/Api_translate_bing.php */