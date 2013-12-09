<div class="main-block">
    <div class="top-corners"><div><div>&nbsp;</div></div></div>

    <div class="corner">
        <div class="full-width">
            <div class="page-title">
                <h1><?=$BC->_getPageTitle()?></h1>
            </div>

            <form id="unsubscribe_form" action="#" method="post">
            	<div id="subscribe_results"></div>
            	<div><input type="text" name="email" value="<?=language('email')?>" id="subscribe_email" /></div> 
            	<div><button class="button" id="unsubscribe"><span><span><?=language('unsubscribe')?></span></span></button></div>
            </form>
            
        </div>
    </div>

    <div class="bot-corners"><div><div>&nbsp;</div></div></div>
</div>

<?=include_js($BC->_getFolder('js').'custom/subscribe/unsubscribe.js"')?>