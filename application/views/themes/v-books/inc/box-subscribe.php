<h3><?=language('newsletters')?></h3>

<div class="well">
    <form method="post" id="subscribe_form" action="#">
        <h5><?=language('sign_up_for_our_newsletter')?>:</h5>
        
        <div id="subscribe_results"></div>
    	<div><input type="text" name="email" value="" id="subscribe_email" /></div> 

        <button type="submit" class="btn" id="subscribe"><?=language('subscribe')?></button>
    </form>
    <div><?=anchor_base('subscribe/unsubscribe',language('unsubscribe'))?></div>
</div>

<?=include_js($BC->_getFolder('js').'custom/subscribe/subscribe.js')?>