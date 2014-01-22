<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title><?=language('history')?> :: <?=$recipient['name']?></title>
	<!-- CSS Styles -->
	<?=include_css('css/zero.css')?>
	<?=include_css($BC->_getTheme().'css/im.css')?>
	<!-- JS Scripts -->
	<?$this->load->view('inc/js-jquery')?>
	<?=include_js($BC->_getFolder('js').'custom/im/functions.js')?>
	<script>
		//set global vars
		var my_nick = "<?=$sender['name']?>";
		var nick = "<?=$recipient['name']?>";
		var history_messages = $j.parseJSON('<?=$history_messages?>');
		var recipient_id = "<?=$recipient['id']?>";
		$j(document).ready(function()
		{
			//prefill last history messages
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