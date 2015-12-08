<?php
require_once(APPPATH.'controllers/abstract/api.php');


/**
 * API Customers controller
 */
class Customers extends API
{
    protected $model_name = "customers_model";
    protected $c_table = "customers";
    protected $list_fields = array('id', 'email', 'name', 'surname', 'phone', 'phone2', 'website', 'city', 'address', 'zip_code');

    /*protected function getItems()
    {
        for($i=1;$i<=100;$i++){
            $data['posts_list'][] = array( 'name' => 'Name '.$i, 'surname' => 'Surname '.$i );
        }
        $data['posts_list'] = array_reverse($data['posts_list']);

        $this->response($data, 200);
    }*/
}