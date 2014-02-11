$j(document).ready(function()
{
	//remove item from cart
    $j(document.body).on('click', "#cart-form .delete-item, #dialog-cart-form .delete-item", function()
    {
        var form_obj = $j(this).parents('form');
        var qty_input_name = $j(this).attr('rel');
        //set quantity "0"
        $j("input[name='"+qty_input_name+"']",form_obj).val(0);
        //update cart
        $j(form_obj).submit()
    });
});