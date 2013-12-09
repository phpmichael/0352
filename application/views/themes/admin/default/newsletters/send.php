<!--Load JS-->

<!--Load JS-->

<?
$send_to['me'] = language('me');
$send_to['customers'] = language('customers');
if(userAccess('subscribers','send')) $send_to['subscribers'] = language('subscribers');
?>

<div class="red"><?=validation_errors()?></div>

<form action="" method="post">

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?></td>
</tr>
<tr>
	<td><?=language('email_template')?>: </td>
	<td><?=form_dropdown("tpl", $tplArr ,set_value('tpl',@$tpl),"id='tpl'");?> <input type="button" value="<?=language('load')?> <?=language('template')?>" class="submit" onclick="location.href='<?=str_replace($BC->config->item('url_suffix'),"",site_url($BC->_getBaseURI()."/send"))?>'+'/'+$j('#tpl').val()+'<?=$BC->config->item('url_suffix')?>'"> <a href="<?=site_url($BC->_getBaseURL()."email_tpl_vars")?>"><?=language('vars_for_templates')?></a> </td>
</tr>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("send_to")?>: <span class="red">*</span></td>
	<td><?=form_dropdown("send_to", $send_to);?> <?if(userAccess('subscribers','view')):?><a href="<?=site_url($BC->_getBaseURL()."subscribers")?>"><?=language('subscribers')?></a><?endif?> <?=anchor($BC->_getBaseURI().'/index',language('queue'))?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("send_from")?>: <span class="red">*</span></td>
	<td><?=form_input("send_from",set_value('send_from',@$send_from),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("subject")?>: <span class="red">*</span></td>
	<td><?=form_input("subject",set_value('subject',@$subject),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("message")?>: <span class="red">*</span></td>
	<td><?=form_textarea("message",set_value('message',@$message),"id='message' class='richtext'");?></td>
</tr>
</table>

<p><?=form_submit("submit",language('submit'));?></p>

</form>

<?$this->load->view('inc/js-tinymce')?>