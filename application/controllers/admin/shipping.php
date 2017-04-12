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
    public function printUrkPost($customer_id)
    {
        $blankPath = './store/blank/UkrPost.jpg';
        $fontPath = './fonts/arial.ttf';

        if( !file_exists($blankPath) ) echo 'Blank not exists: '.$blankPath;
        elseif( !file_exists($fontPath) ) echo 'Font not exists: '.$fontPath;
        elseif( !($customer = $this->customers_model->getOneById($customer_id)) ) echo 'Customer not exists: '.$customer_id;
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

            $text['x'] = 55;
            $text['y'] = 1188;
            $text['str'] = $customer['address'];
            imagettftext($image, $font['size'], 0, $text['x'], $text['y'], $font['color'], $font['path'], $text['str']);

            $text['x'] = 55;
            $text['y'] = 1232;
            $text['str'] = $customer['city'].', '.$customer['zip_code'];
            imagettftext($image, $font['size'], 0, $text['x'], $text['y'], $font['color'], $font['path'], $text['str']);


            header('Content-type: image/jpeg');
            imagejpeg($image);
            imagedestroy($image);
        }
    }
}