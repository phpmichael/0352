<?php

/**
 * This class for extending shopping cart.
 *
 * @package shop
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class MY_Cart extends CI_Cart 
{
    // Override product name rules because there really shouldn't be any rules
    // especially when no feedback is given to the customer!!
    var $product_name_rules = '^\n';

    /**
     * Constructor for MY_Cart
     */
    public function __construct() 
    {
        parent::__construct();
    }
    
} 