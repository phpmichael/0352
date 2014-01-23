<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />

	<title><?=language('history')?> :: <?=$recipient['name']?></title>
	<!-- CSS Styles -->
	<?=include_css('css/zero.css')?>
	<?=include_css($BC->_getTheme().'css/im.css')?>
	<!-- JS Scripts -->
	<?=load_inline_js('inc/js-jquery')?>
	<?=include_js($BC->_getFolder('js').'custom/im/functions.js')?>
	<script>
		/*set global vars*/
		var my_nick = "<?=$sender['name']?>";
		var nick = "<?=$recipient['name']?>";
		var history_messages = $j.parseJSON('<?=$history_messages?>');
		var recipient_id = "<?=$recipient['id']?>";
		$j(document).ready(function()
		{
			/*prefill last history messages*/
			showHistory(window.history_messages)
		});
	</script>
</head>

<body>

<div id="im-history">

	<div id='messages-box'>
		
	</div>
	
</div>

</body>
</html>