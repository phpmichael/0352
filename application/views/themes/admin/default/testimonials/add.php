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
	<td><?=$BC->_getFieldTitle("link")?>:</td>
	<td><?=form_input("link",set_value('link',@$link),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("content")?>:</td>
	<td><?=form_textarea("content",set_value('content',@$content),"class='textarea'");?></td>
</tr>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>