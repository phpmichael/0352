<?php
require_once(APPPATH.'controllers/abstract/admin.php');

Class Customers extends Admin
{

  public function __construct()
  {
      parent::__construct();

      if( !userAccess('tools','view') ) die('No access');
      
      $this->load->library('unit_test');  
  }
  
  public function index()
  {
      $this->unit->run(strlen($this->customers_model->generatePassword(1)), 10, 'generate password 10 chars length');
      $this->unit->run($this->customers_model->checkLogin('php.michael@gmail.com','wrongpassword'), FALSE, 'check invalid login data');

      echo $this->unit->report();
  }
  
}