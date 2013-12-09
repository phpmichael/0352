<?if($BC->_getController()!='customers' || $BC->_getMethod()!='index'):?>
<div id="page">
    <h2 class="title"><span><span><?=language('my_account')?></span></span></h2>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <ul style="margin-top:-20px;">
					<li><?=anchor_base('customers/editinfo', language('edit_my_info'))?></li>
					<li><?=anchor_base('orders/history', language('my_orders_history'))?></li>
					<li><?=anchor_base('wishlist', language('my_wishlist'))?></li>
					<li><?=anchor_base('customers/signout', language('logout'))?></li>
				</ul>
            </div>
        </div>
    </div>
</div>
<?endif?>