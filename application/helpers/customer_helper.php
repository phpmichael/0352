<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Return logged customer's data.
* 
* @return array
*/
function get_customer()
{
	$CI =& get_instance();
	return $CI->customers_model->getLogged();
}

/**
 * Return logged customer's name.
 *
 * @return string|bool
 */
function get_customer_name()
{
    $customer = get_customer();
    if(!$customer) return FALSE;
    return $customer['name'];
}

/**
 * Return logged customer's email.
 *
 * @return string|bool
 */
function get_customer_email()
{
    $customer = get_customer();
    if(!$customer) return FALSE;
    return $customer['email'];
}

/**
 * Return logged customer's website.
 *
 * @return string|bool
 */
function get_customer_website()
{
    $customer = get_customer();
    if(!$customer) return FALSE;
    return $customer['website'];
}

/**
 * Check if product in wishlist.
 *
 * @param integer $product_id
 * @return bool
 */
function is_product_in_wishlist($product_id)
{
    $wishlist_model = load_model('wishlist_model');
    return $wishlist_model->isProductInWishlist($product_id);
}