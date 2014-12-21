$j(document).ready(function()
{
    //process "add to cart" click
    $j('.add-product').submit(function()
	{
	    var button = $j(this).find('button[type=submit], input[type=submit]').get(0);
	    
	    $j.post($j(this).attr('action'),$j(this).serialize(),function(response)//add item to cart by ajax request
        {
            show_short_cart();
            
            //show tooltip
            $j(button).tipTip({content:response.message,delay:200});
            $j(button).trigger('mouseover');
            
            //dialog cart
            if(parseInt(window.appPackages.shop.show_dialog_cart)) $j.facebox({ ajax: window.appPackages.shop.dialog_cart_url });
            
        },'json');
        return false;
    });

    //trigger "submit" of "add to cart" by button click
    $j('.add-product-submit').click(function(){
        $j(this).parents('.add-product').submit();
    });
    
    //process "add to wishlist" click
    $j('.add-to-wishlist').click(function()
    {
        var product_id = $j(this).attr('id');
        product_id = product_id.replace('add-to-wishlist-','');
        
        var button = this;
    	
    	$j.post(window.appPackages.wishlist.form_action,{product_id:product_id},function(response)//add item to user's wishlist by ajax request
        {
            //show tooltip
            $j(button).tipTip({content:response.message,delay:200});
            $j(button).trigger('mouseover');  
        },'json');
        return false;
    });
    
    //redirect to cart on click
    $j(document.body).on('click', ".go-to-cart", function()
    {
    	location.href = window.appPackages.shop.cart_url;
    });
    
});

