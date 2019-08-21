<?php

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

        if(!(float)$result->GetCreditBalanceResult){
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
        return $result->SendSMSResult->ResultArray[1];//message ID
    }
}