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
}