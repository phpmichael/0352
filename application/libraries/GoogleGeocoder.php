<?php defined('BASEPATH') OR exit('No direct script access allowed');

class GoogleGeocoder
{
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->baseURL = "https://maps.google.com/maps/api/geocode/json?sensor=false&key=".$this->CI->settings_model['google_map_api_key'];
    }

    public function geocode($address)
    {
        $url = $this->baseURL . "&address=" . urlencode($address);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $contents = curl_exec($ch);
        curl_close($ch);

        if ($contents) {
            $resp = json_decode($contents);
            if($resp->status = 'OK' && !empty($resp->results)){
                return $resp->results[0]->geometry->location;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function reverseGeocode($location)
    {
        $url = $this->baseURL . "&latlng=" . $location;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $contents = curl_exec($ch);
        curl_close($ch);

        if ($contents) {
            $resp = json_decode($contents);
            if($resp->status = 'OK'){
                return $resp->results[0]->formatted_address;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
}