<?php
require_once(APPPATH.'controllers/abstract/api.php');

class Customers extends API
{
    protected $model_name = "customers_model";
    protected $c_table = "customers";

    /**
     * Return items list
     */
    protected function getItems()
    {
        /*for($i=1;$i<=100;$i++){
            $data['posts_list'][] = array( 'name' => 'Name '.$i, 'surname' => 'Surname '.$i );
        }
        $data['posts_list'] = array_reverse($data['posts_list']);*/
        $data['posts_list'] = $this->model->getAll(array('id', 'email', 'name', 'surname', 'phone', 'phone2', 'website', 'city', 'address', 'zip_code'));
        $data['total_rows'] = $this->model->countAll();

        $this->response($data, 200);
    }
}