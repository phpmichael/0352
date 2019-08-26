<?php

if(!extension_loaded('soap')){
    require_once APPPATH.'third_party/nusoap.php';

    class SoapClient
    {
        private $client;

        public function __construct($endpoint)
        {
            $this->client = new nusoap_client($endpoint, true);
            $this->client->soap_defencoding = 'UTF-8';
            $this->client->decode_utf8 = FALSE;
        }

        public function __call($name, $arguments)
        {
            return $this->client->call($name, $arguments);
        }
    }
}

class Turbosms
{
    private $CI;
    private $client;

    public function __construct()
    {
        $this->CI =& get_instance();

        $auth = array(
            'login' => $this->CI->settings_model['turbosms_login'],
            'password' => $this->CI->settings_model['turbosms_password']
        );

        $this->client = new SoapClient('http://turbosms.in.ua/api/wsdl.html');

        $this->client->Auth($auth);

        $result = $this->client->GetCreditBalance();

        if(is_object($result)){
            $balance = $result->GetCreditBalanceResult;
        }else{
            $balance = $result['GetCreditBalanceResult'];
        }

        if(!(float)$balance){
            throw new Exception('Wrong auth credentials or no money on credit balance');
        }
    }

    public function send($phone, $tpl, array $tplVars = array())
    {
        if(empty($tpl)){
            throw new Exception('Empty SMS text');
        }

        if(!empty($tplVars)){
            foreach ($tplVars as $var=>$value) {
                $tpl = str_replace("{" . $var . "}", $value, $tpl);
            }
        }

        $phone = preg_replace('/[^\d]/','',$phone);
        $phone = preg_replace('/^380/','',$phone);

        if(!preg_match('/^\d{9}$/',$phone)){
            throw new Exception('Invalid phone number');
        }

        $sms = [
            'sender' => $this->CI->settings_model['turbosms_sender'],
            'destination' => '+380'.$phone,
            'text' => $tpl
        ];

        $result = $this->client->SendSMS($sms);

        if(is_object($result)){
            $messageId = $result->SendSMSResult->ResultArray[1];
        }else{
            $messageId = $result['SendSMSResult']['ResultArray'][1];
        }

        return $messageId;
    }
}