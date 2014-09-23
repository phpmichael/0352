<?php
require_once(APPPATH.'controllers/abstract/api.php');

class Photos extends API
{
    protected $model_name = "photos_model";
    protected $c_table = "photos";
}