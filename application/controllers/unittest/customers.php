<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/**
 * UnitTest Customers
 */
Class Customers extends Admin
{

    /**
     * Init unit test
     */
    public function __construct()
    {
        parent::__construct();

        if( !userAccess('tools','view') ) die('No access');

        $this->load->library('unit_test');
    }

    /**
     * Test: generate password, check login
     */
    public function index()
    {
        $this->unit->run(strlen($this->customers_model->generatePassword(1)), 10, 'generate password 10 chars length');
        $this->unit->run($this->customers_model->checkLogin('php.michael@gmail.com','wrongPassword'), FALSE, 'check invalid login data');

        echo $this->unit->report();
    }
  
}