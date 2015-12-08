<?php
require_once(APPPATH.'controllers/abstract/api.php');

/**
 * API Subscribers controller
 */
class Subscribers extends API
{
    protected $model_name = "subscribers_model";
    protected $c_table = "subscribers";
}