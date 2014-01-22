<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title><?=language('instant_messenger')?> :: <?=$recipient['name']?></title>
	<!-- CSS Styles -->
	<?=include_css('css/zero.css')?>
	<?=include_css($BC->_getTheme().'css/im.css')?>
	<!-- JS Scripts -->
	<?$this->load->view('inc/js-jquery')?>
	<?$this->load->view('inc/js-custom-functions')?>
	<?=include_js($BC->_getFolder('js').'custom/im/functions.js')?>
	<?=include_js($BC->_getFolder('js').'custom/im/process.js')?>
	<script>
		//set global vars
		var my_nick = "<?=$sender['name']?>";
		var nick = "<?=$recipient['name']?>";
		var get_new_messages_url = "<?=site_url($BC->_getBaseURL().'im/getnewmessages/'.$recipient['id'])?>";
		var history_messages = $j.parseJSON('<?=$history_messages?>');
		var recipient_id = "<?=$recipient['id']?>";
	</script>
</head>

<body>

<div id="im">

	<div id="info">
		<a href="javascript:void(0)" onclick="openImWindow('<?=site_url($BC->_getBaseURL().'im/history/'.$recipient['id'])?>','im_history_window')"><?=language('show_history')?></a>
	</div>

	<div id='messages-box'>
		
	</div>
	
	<div id='message-box'>
		<form action="<?=site_url($BC->_getBaseURL().'im/submit/'.$recipient['id'])?>" id="im_form" method="post">
			<textarea id="message" name="message"></textarea>
			<input id="send-message" type="submit" value="<?=language('submit')?>" />
		</form>
	</div>
	
</div>

</body>
</html>
