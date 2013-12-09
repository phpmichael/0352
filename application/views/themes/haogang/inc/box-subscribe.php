<div class="block block-subscribe">
    <div class="block-title">
        <strong><span><?=language('newsletters')?></span></strong>
    </div>

    <form method="post" id="subscribe_form" action="#">
        <div class="block-content">
            <label for="newsletter"><?=language('sign_up_for_our_newsletter')?>:</label>
            
            <div id="subscribe_results"></div>
        	<div class="input-box"><input type="text" name="email" value="" class="input-text" id="subscribe_email" /></div> 

            <button type="submit" title="Subscribe" class="button" id="subscribe"><span><span><?=language('subscribe')?></span></span></button>
            <br class="clear" />
        </div>
    </form>
    <div><?=anchor_base('subscribe/unsubscribe',language('unsubscribe'))?></div>
</div>

<?=include_js($BC->_getFolder('js').'custom/subscribe/subscribe.js')?>