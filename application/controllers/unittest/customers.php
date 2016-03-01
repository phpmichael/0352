<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/**
 * UnitTest Customers
 */
Class Customers extends Admin
{
    protected $c_table = 'customers';

    /**
     * Init unit test
     */
    public function __construct()
    {
        parent::__construct();

        if( !userAccess('tools','view') ) die('No access');

        $this->load->library('unit_test');

        // === Init Language Section === //
        $this->lang_model->init('all');
    }

    /**
     * Test: generate password, check login
     */
    public function index()
    {
        $customer = array(
            'email' => 'unittest@test.com',
            'password' => md5('testpass'),
            'name' => 'Unit',
            'surname' => 'Test',
            'phone' =>' 555-555-555',
            'phone2' => '666-666-666',
            'website' => 'http://unittest.com',
            'address' => 'Unit Street',
            'city' => 'Unit City',
            'zip_code' => 'ZIP007',
        );

        $this->unit->run(
            strlen($this->customers_model->generatePassword(1)),
            10,
            'generate (and update for customerId=1) password 10 chars length'
        );

        $this->unit->run(
            $this->customers_model->checkLogin($customer['email'],$customer['password']),
            FALSE,
            'invalid login due to customer not exists'
        );

        $customerId = $this->customers_model->insertOrUpdate($customer);
        $this->unit->run(
            $customerId,
            'is_int',
            'insert new customer'
        );

        $this->unit->run(
            $this->customers_model->checkLogin($customer['email'],$customer['password']),
            TRUE,
            'valid login due to customer added'
        );

        $customer['id'] = $customerId;
        $customer['name'] = 'New';
        $this->unit->run(
            $this->customers_model->insertOrUpdate($customer),
            'is_int',
            'update customer name'
        );

        $this->unit->run(
            $this->customers_model->getNameById($customerId)=='New',
            TRUE,
            'check if customer name changed'
        );

        $customer['surname'] = 'New';
        $customer['repassword'] = $customer['password'] = 'testpass';//md5 in validation rules
        $this->customers_model->storeForm($customer,false,$customerId);
        $this->unit->run(
            $this->customers_model->getFullNameById($customerId)=='New New',
            TRUE,
            'check if customer surname changed (with validation)'
        );

        $this->customers_model->deleteId($customerId);
        $customer = $this->customers_model->getOneById($customerId);
        $this->unit->run(
            empty($customer),
            TRUE,
            'delete created customer'
        );

        $this->unit->run(
            $this->customers_model->getOneById($customerId),
            FALSE,
            'customer not exists after delete'
        );

        echo $this->unit->report();
    }
  
}