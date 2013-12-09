<?if($BC->_getController()!='customers' || $BC->_getMethod()!='index'):?>
    <h2><?=language('my_account')?></h2>

    <div class="boxIndent list">
        <ul>
			<li><?=anchor_base('customers/editinfo', language('edit_my_info'))?></li>
			<li><?=anchor_base('orders/history', language('my_orders_history'))?></li>
			<li><?=anchor_base('wishlist', language('my_wishlist'))?></li>
			<li><?=anchor_base('customers/signout', language('logout'))?></li>
		</ul>
    </div>
<?endif?>