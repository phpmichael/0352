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
    	
    	//Client ID of the application.
	    $clientID       = "mCMS";
	    //Client Secret key of the application.
	    $clientSecret = "tZLrGoiJ9ND86HKTL3Epwrt/KEvrpu1L+IjC0AKMajg=";
	    //OAuth Url.
	    $authUrl      = "https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/";
	    //Application Scope Url
	    $scopeUrl     = "http://api.microsofttranslator.com";
	    //Application grant type
	    $grantType    = "client_credentials";
	    
	    
	
	    //Create the AccessTokenAuthentication object.
	    $authObj      = new AzureAccessTokenAuthentication();
	    //Get the Access token.
	    $accessToken  = $authObj->getTokens($grantType, $scopeUrl, $clientID, $clientSecret, $authUrl);
	    //Create the authorization Header string.
	    $authHeader = "Authorization: Bearer ". $accessToken;
	    
	    //Create the Translator Object.
	    $translatorObj = new AzureHTTPTranslator();
	    
	    $url = "http://api.microsofttranslator.com/V2/Ajax.svc/Translate?from={$from_lang}&to={$to_lang}&text={$text}&contentType=".urlencode("text/html");
	    
	    //Call the curlRequest.
	    $strResponse = $translatorObj->curlRequest($url, $authHeader);
		
		//=== prepare translated === //
		//get content between "..." (at first could be some wierd non-ascii chars)
		preg_match('/^[^"]*"(.*)"$/',$strResponse,$match);
		$trans = (isset($match[1]))? $match[1] : 'Translation Error.';
		//remove \u000a
		$trans = str_replace("\u000a","",$trans);
		//strip \ before closing tag
		$trans = stripslashes($trans);
		
		return $trans;
    }
}


class AzureAccessTokenAuthentication {
    /*
     * Get the access token.
     *
     * @param string $grantType    Grant type.
     * @param string $scopeUrl     Application Scope URL.
     * @param string $clientID     Application client ID.
     * @param string $clientSecret Application client ID.
     * @param string $authUrl      Oauth Url.
     *
     * @return string.
     */
    function getTokens($grantType, $scopeUrl, $clientID, $clientSecret, $authUrl){
        try {
            //Initialize the Curl Session.
            $ch = curl_init();
            //Create the request Array.
            $paramArr = array (
                 'grant_type'    => $grantType,
                 'scope'         => $scopeUrl,
                 'client_id'     => $clientID,
                 'client_secret' => $clientSecret
            );
            //Create an Http Query.//
            $paramArr = http_build_query($paramArr);
            //Set the Curl URL.
            curl_setopt($ch, CURLOPT_URL, $authUrl);
            //Set HTTP POST Request.
            curl_setopt($ch, CURLOPT_POST, TRUE);
            //Set data to POST in HTTP "POST" Operation.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $paramArr);
            //CURLOPT_RETURNTRANSFER- TRUE to return the transfer as a string of the return value of curl_exec().
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
            //CURLOPT_SSL_VERIFYPEER- Set FALSE to stop cURL from verifying the peer's certificate.
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //Execute the  cURL session.
            $strResponse = curl_exec($ch);
            //Get the Error Code returned by Curl.
            $curlErrno = curl_errno($ch);
            if($curlErrno){
                $curlError = curl_error($ch);
                throw new Exception($curlError);
            }
            //Close the Curl Session.
            curl_close($ch);
            //Decode the returned JSON string.
            $objResponse = json_decode($strResponse);
            if (isset($objResponse->error) && $objResponse->error){
                throw new Exception($objResponse->error_description);
            }
            return $objResponse->access_token;
        } catch (Exception $e) {
            echo "Exception-".$e->getMessage();
        }
    }
}

/*
 * Processing the translator request.
 */
Class AzureHTTPTranslator {
    /*
     * Create and execute the HTTP CURL request.
     *
     * @param string $url        HTTP Url.
     * @param string $authHeader Authorization Header string.
     * @param string $postData   Data to post.
     *
     * @return string.
     *
     */
    function curlRequest($url, $authHeader, $postData=''){
        //Initialize the Curl Session.
        $ch = curl_init();
        //Set the Curl url.
        curl_setopt ($ch, CURLOPT_URL, $url);
        //Set the HTTP HEADER Fields.
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array($authHeader,"Content-Type: text/xml"));
        //CURLOPT_RETURNTRANSFER- TRUE to return the transfer as a string of the return value of curl_exec().
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //CURLOPT_SSL_VERIFYPEER- Set FALSE to stop cURL from verifying the peer's certificate.
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        if($postData) {
            //Set HTTP POST Request.
            curl_setopt($ch, CURLOPT_POST, TRUE);
            //Set data to POST in HTTP "POST" Operation.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        //Execute the  cURL session.
        $curlResponse = curl_exec($ch);
        //Get the Error Code returned by Curl.
        $curlErrno = curl_errno($ch);
        if ($curlErrno) {
            $curlError = curl_error($ch);
            throw new Exception($curlError);
        }
        //Close a cURL session.
        curl_close($ch);
        return $curlResponse;
    }

    /*
     * Create Request XML Format.
     *
     * @param string $languageCode  Language code
     *
     * @return string.
     */
    function createReqXML($languageCode) {
        //Create the Request XML.
        $requestXml = '<ArrayOfstring xmlns="http://schemas.microsoft.com/2003/10/Serialization/Arrays" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">';
        if($languageCode) {
            $requestXml .= "<string>$languageCode</string>";
        } else {
            throw new Exception('Language Code is empty.');
        }
        $requestXml .= '</ArrayOfstring>';
        return $requestXml;
    }
}

/* End of file Api_translate_bing.php */
/* Location: ./application/libraries/Api_translate/drivers/Api_translate_bing.php */