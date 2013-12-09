<?php

class MY_Cart extends CI_Cart 
{
    // Override product name rules because there really shouldn't be any rules
    // especially when no feedback is given to the customer!!
    var $product_name_rules = '^\n';
    
    public function __construct() 
    {
        parent::__construct();
    }
    
} 