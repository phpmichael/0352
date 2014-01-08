<h1><?=$BC->_getPageTitle()?></h1>

<div class="well">
  
    <form id="unsubscribe_form" action="#" method="post">
    	<div id="subscribe_results"></div>
    	<div><input type="text" name="email" value="<?=language('email')?>" id="subscribe_email" /></div> 
    	<div><button class="btn" id="unsubscribe"><?=language('unsubscribe')?></button></div>
    </form>
</div>

<?=include_js($BC->_getFolder('js').'custom/subscribe/unsubscribe.js"')?>