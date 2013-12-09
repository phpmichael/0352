<div class="red"><?=validation_errors()?></div>

<form action="" method="post">

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("name")?>: <span class="red">*</span></td>
	<td><?=form_input("name",set_value('name',@$name),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("content")?>: <span class="red">*</span></td>
	<td><?=form_textarea("content",set_value('content',@$content),"id='content' class='richtext'");?></td>
</tr>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>

<?$this->load->view('inc/js-tinymce')?>