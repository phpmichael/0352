<div class="red"><?=validation_errors()?></div>

<form action="" method="post">

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?></td>
</tr>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("email")?>: <span class="red">*</span></td>
	<td><?=form_input("email",set_value('email',@$email),"class='largeinput'");?></td>
</tr>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>