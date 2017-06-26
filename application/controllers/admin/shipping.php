<?php
require_once(APPPATH.'controllers/abstract/admin_fb.php');

/** 
 * This is admin controller for Shipping.
 * 
 * @package shop  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Shipping extends Admin_fb 
{
    protected $process_form_html_id = "shipping"; 
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //

    /**
     * Generate "UkrPost" postal order from blank
     * @param int $customer_id
     */
    public function printUrkPost($orders_customer_info_id)
    {
        $blankPath = './store/blank/UkrPost.jpg';
        $fontPath = './fonts/arial.ttf';
        $this->load->model('orders_model');

        if( !file_exists($blankPath) ) echo 'Blank not exists: '.$blankPath;
        elseif( !file_exists($fontPath) ) echo 'Font not exists: '.$fontPath;
        elseif( !($customer = $this->orders_model->getOrderCustomerInfo($orders_customer_info_id) ) ) echo 'Customer not exists: '.$orders_customer_info_id;
        else
        {
            $image = imagecreatefromjpeg($blankPath);

            $font['color'] = imagecolorallocate($image, 0, 0, 0);
            $font['path'] = $fontPath;
            $font['size'] = 31;

            $text['x'] = 300;
            $text['y'] = 988;
            $text['str'] = $customer['surname'].' '.$customer['name'];
            imagettftext($image, $font['size'], 0, $text['x'], $text['y'], $font['color'], $font['path'], $text['str']);

            $text['x'] = 300;
            $text['y'] = 1090;
            $text['str'] = $customer['phone'];
            imagettftext($image, $font['size'], 0, $text['x'], $text['y'], $font['color'], $font['path'], $text['str']);

            $font['size'] = 27;
            $text['x'] = 255;
            $text['y'] = 1138;
            $text['str'] = "вул. {$customer['street']} {$customer['house_number']}";
            if($customer['apartment_number']) $text['str'] .= " кв. {$customer['apartment_number']}";
            imagettftext($image, $font['size'], 0, $text['x'], $text['y'], $font['color'], $font['path'], $text['str']);

            $text['x'] = 55;
            $text['y'] = 1188;
            $text['str'] = "Населений пункт: {$customer['place']}";
            imagettftext($image, $font['size'], 0, $text['x'], $text['y'], $font['color'], $font['path'], $text['str']);

            $text['x'] = 55;
            $text['y'] = 1232;
            $text['str'] = ($customer['rayon']) ? "{$customer['rayon']} район, " : "";
            $text['str'] .= "{$customer['region']} обл., {$customer['zip_code']}";
            imagettftext($image, $font['size'], 0, $text['x'], $text['y'], $font['color'], $font['path'], $text['str']);


            header('Content-type: image/jpeg');
            imagejpeg($image);
            imagedestroy($image);
        }
    }

    /**
     * Send shipping in for to NovaPoshta
     * @param bool $orderId
     */
    public function novaposhtaSend($orderId=false)
    {
        if(!$orderId) die('orderId is required');

        $this->load->model('orders_model');
        $order = $this->orders_model->getOneById($orderId);
        if(!$order) die('Order not found');

        if($this->input->post())
        {
            $post = $this->input->post();

            //simple validate
            if(!$post['PayerType'] || !$post['CargoType'] || !$post['Weight'] || !$post['BackwardDeliveryExists'])
            {
                die('Invalid params');
            }

            $settings = $this->settings_model;

            require_once(APPPATH.'libraries/NovaPoshta/NovaPoshtaApi2.php');
            $np = new LisDev\Delivery\NovaPoshtaApi2($settings['novaposhta_apiKey'],'ua',TRUE,'curl');

            $sender = array();
            $sender['Sender'] = $settings['novaposhta_Sender'];//Sender Ref
            $sender['CitySender'] = $settings['novaposhta_CitySender'];//City Ref
            $sender['SenderAddress'] = $settings['novaposhta_SenderAddress'];//Department Ref !!!

            $contactSender = $np->getCounterpartyContactPersons($sender['Sender']);
            $sender['ContactSender'] = $contactSender['data'][0]['Ref'];
            $sender['SendersPhone'] = $contactSender['data'][0]['Phones'];


            $customer = $this->orders_model->getOrderCustomerInfo($order['orders_customer_info_id']);
            if(!$customer) die('Customer info not found');

            $phone = preg_replace('/[^0-9]/','',$customer['phone']);
            if(!preg_match('/^380/',$phone)) $phone = '380'.$phone;

            $recipient = array(
                'FirstName' => $customer['name'],
                'LastName' => $customer['surname'],
                'Phone' => $phone,//TODO: validate phone on enter in form
                'CityRecipient' => $customer['city_ref'],
                'RecipientAddress' => $customer['department_ref'],
            );

            $params = array(
                'DateTime' => str_replace('/','.',$post['DateTime']),
                'ServiceType' => 'WarehouseWarehouse',
                'PaymentMethod' => 'Cash',
                'PayerType' => $post['PayerType'],
                'Cost' => $order['total'],
                'SeatsAmount' => '1',
                'Description' => $post['Description'],
                'CargoType' => $post['CargoType'],
                'Weight' => $post['Weight'],
            );

            if($post['BackwardDeliveryExists'] == 'yes')
            {
                $params['BackwardDeliveryData'][0] = array(
                    'PayerType' => $post['BackwardDeliveryPayerType'],
                    'CargoType' => 'Money',
                    'RedeliveryString' => $post['RedeliveryString']
                );
            }

            try {
                $result = $np->newInternetDocument($sender, $recipient, $params);
            }
            catch(Exception $exception){
                die('Exception: '.$exception->getMessage());
            }

            if($result['success'])
            {
                $docNumber = $result['data'][0]['IntDocNumber'];
                $this->orders_model->updateOrderCustomerInfo($order['orders_customer_info_id'], array('doc_number'=>$docNumber));

                redirect($this->_getBaseURL()."orders/edit/id/desc/0/".$orderId);
            }
            else dump($result);
        }
        else
        {
            $this->formbuilder_model->setFormMode('edit');
            $this->formbuilder_model->setFormData(array(
                'orderId' => $orderId,
                'DateTime' => date('d.m.Y'),
                'RedeliveryString' => $order['total']
            ));

            $data['tpl_page'] = 'shipping/novaposhta-send';
            $data['order_id'] = $orderId;

            parent::_OnOutput($data);
        }
    }

    /**
     * Send E-Invoice Number (novaposhta, ukrposhta)
     * @param int $orderId
     */
    public function sendEN($orderId)
    {
        if(!$orderId) die('orderId is required');

        $this->load->model('orders_model');
        $order = $this->orders_model->getOneById($orderId);
        if(!$order) die('Order not found');

        $customer = $this->orders_model->getOrderCustomerInfo($order['orders_customer_info_id']);
        $this->orders_model->updateOrderCustomerInfo($order['orders_customer_info_id'], array('doc_number_sent'=>1));

        if($customer['shipping_type']=='ukrposhta') $shipping_company = 'Укрпоштою';
        elseif($customer['shipping_type']=='novaposhta') $shipping_company = 'Новою поштою';
        else $shipping_company = '';

        // === Mail Customer === //
        $this->load->model('auto_responders_model');
        $this->auto_responders_model->send(6,$customer['email'],array('doc_number'=>$customer['doc_number'],'shipping_company'=>$shipping_company));

        redirect($this->_getBaseURL().'orders/edit/id/desc/0/'.$order['id']);
    }
}