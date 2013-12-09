<div class="main-block">
    <div class="top-corners"><div><div>&nbsp;</div></div></div>

    <div class="corner">
        <div class="full-width">
            <div class="page-title">
                <h1><?=$BC->_getPageTitle()?></h1>
            </div>

            <ul>
				<li><?=anchor_base('customers/editinfo', language('edit_my_info'))?></li>
				<li><?=anchor_base('orders/history', language('my_orders_history'))?></li>
				<li><?=anchor_base('wishlist', language('my_wishlist'))?></li>
				<li><?=anchor_base('customers/signout', language('logout'))?></li>
			</ul>
        </div>
    </div>

    <div class="bot-corners"><div><div>&nbsp;</div></div></div>
</div>