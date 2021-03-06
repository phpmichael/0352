<?php

/**
 * API client for Ukrposhta. Use cURL.
 * Class Ukrposhta
 */
class Ukrposhta
{
    private $api_url = 'https://www.ukrposhta.ua/ecom/0.0.1/';

    private $api_bearer_ecom;
    private $api_token;
    private $sender_uuid;//manually created customer

    private $errorMessages = array();

    /**
     * Return last error message
     * @return string
     */
    public function getLastErrorMessage()
    {
        return array_pop($this->errorMessages);
    }

    /**
     * Setup API settings
     * @param $settings
     */
    public function setup($settings)
    {
        $this->api_bearer_ecom = $settings['ukrposhta_api_bearer_ecom'];
        $this->api_token = $settings['ukrposhta_api_token'];
        $this->sender_uuid = $settings['ukrposhta_sender_uuid'];
    }

    /**
     * Add customer's address info.
     * 1st step of shipment add process
     * @param array $customer
     * @return array|bool
     */
    public function addAddress(array $customer)
    {
        //TODO: validate postcode

        $address['country'] = 'UA';
        $address['postcode'] = $customer['zip_code'];
        $address['region'] = $customer['region'];
        $address['city'] = $customer['place'];
        $address['district'] = $customer['rayon'];
        $address['street'] = $customer['street'];
        $address['houseNumber'] = $customer['house_number'];
        $address['apartmentNumber'] = $customer['apartment_number'];

        //validate fields
        foreach (array('postcode','region','city','street') as $field)
        {
            if(!trim($address[$field])) {
                $this->errorMessages[] = $errorMessage = "Field {$field} could not be empty.";
                return array('message' => $errorMessage, 'code' => 'Local error');
            }
        }

        return $this->request('addresses', $address);
    }

    /**
     * Add customer info.
     * 2nd step of shipment add process
     * @param array $customer
     * @param int $addressId
     * @return array|bool
     */
    public function addClient(array $customer, $addressId)
    {
        $client['firstName'] = $customer['name'];
        $client['lastName'] = $customer['surname'];
        $client['uniqueRegistrationNumber'] = $customer['data_key'];
        $client['addressId'] = $addressId;//result of "addAddress"
        $client['phoneNumber'] = $customer['phone'];
        $client['email'] = $customer['email'];
        $client['type'] = 'INDIVIDUAL';

        //validate fields
        foreach (array('firstName','lastName','phoneNumber','email') as $field)
        {
            if(!trim($client[$field])) {
                $this->errorMessages[] = $errorMessage = "Field {$field} could not be empty.";
                return array('message' => $errorMessage, 'code' => 'Local error');
            }
        }

        return $this->request('clients?token='.$this->api_token, $client);
    }

    /**
     * Search client by phone number
     * @param string $phone
     * @return array
     */
    public function getClientByPhone($phone)
    {
        return $this->request('clients/phone?token='.$this->api_token.'&countryISO3166=UA&phoneNumber='.$phone, array(), 'GET');
    }

    /**
     * Add shipment.
     * 3rd step of shipment add process
     * @param string $recipientId
     * @param array $params
     * @return array
     */
    public function addShipment($recipientId, array $params)
    {
        //TODO: validate params

        $shipment['type'] = 'STANDARD';
        $shipment['sender']['uuid'] = $this->sender_uuid;
        $shipment['recipient']['uuid'] = $recipientId;
        $shipment['deliveryType'] = 'W2W';
        $shipment['onFailReceiveType'] = 'RETURN_AFTER_7_DAYS';
        $shipment['paidByRecipient'] = ($params['PayerType'] == 'Recipient') ? true : false;
        $shipment['description'] = $params['description'];
        $shipment['postPay'] = $params['postPay'];

        $shipment['parcels'][0]['declaredPrice'] = $params['declaredPrice'];
        $shipment['parcels'][0]['weight'] = $params['weight'];//total weight in grams
        $shipment['parcels'][0]['length'] = $params['length'];//max of length/width/height

        return $this->request('shipments?token='.$this->api_token, $shipment);
    }

    /**
     * Return shipment by ID
     * @param string $shipmentUuid
     * @return array
     */
    public function getShipment($shipmentUuid)
    {
        return $this->request('shipments/'.$shipmentUuid.'?token='.$this->api_token, array(), 'GET');
    }

    /**
     * Return shipment by barcode
     * @param string $barcode
     * @return array
     */
    public function getShipmentByBarcode($barcode)
    {
        return $this->request('shipments/barcode/'.$barcode.'?token='.$this->api_token, array(), 'GET');
    }

    /**
     * Delete shipment by ID
     * @param string $shipmentUuid
     * @return array
     */
    public function deleteShipment($shipmentUuid)
    {
        return $this->request('shipments/'.$shipmentUuid.'?token='.$this->api_token, array(), 'DELETE');
    }

    /**
     * Add shipment group.
     * @param string $name
     * @return array
     */
    public function addShipmentGroup($name)
    {
        $group['name'] = $name;
        $group['type'] = 'STANDARD';

        return $this->request('shipment-groups?token='.$this->api_token, $group);
        //TODO: make ability add shipment to group
    }


    /**
     * Return shipment group by ID
     * @param string $shipmentGroupUuid
     * @return array
     */
    public function getShipmentGroup($shipmentGroupUuid)
    {
        return $this->request('shipment-groups/'.$shipmentGroupUuid.'?token='.$this->api_token, array(), 'GET');
    }

    /**
     * Return sticker as pdf file
     * @param string $shipmentUuid
     * @return string
     */
    public function getSticker($shipmentUuid)
    {
        return $this->request('shipments/'.$shipmentUuid.'/sticker?token='.$this->api_token.'&size=SIZE_A4', array(), 'GET', true);
    }

    /**
     * Creates cURL request to API
     * @param string $path
     * @param array $data
     * @param string $method
     * @return array|string
     */
    private function request($path, $data = array(), $method='POST', $raw=false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url.$path);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer '.$this->api_bearer_ecom,
            'Content-Type: application/json'
        ));

        if($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        elseif ($method === 'DELETE'){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        $response = curl_exec($ch);
        //dump($response);exit;
        curl_close($ch);
        if($raw) return $response;
        return json_decode($response, true);
    }
}