//Load short details of cart
function show_short_cart()
{
    $j('#cart').load(window.appPackages.shop.short_cart_url);
}

$j(document).ready(function(){
    show_short_cart();
});