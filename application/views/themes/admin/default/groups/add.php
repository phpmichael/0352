<div class="red"><?=validation_errors()?></div>

<?=form_open()?>

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("name")?>: <span class="red">*</span></td>
	<td><?=form_input("name",set_value('name',@$name),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("admin_access")?>:</td>
	<td><?=form_dropdown("admin_access",array(0=>language('no'),1=>language('yes')),set_value('admin_access',@$admin_access));?></td>
</tr>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>


<?=load_inline_js('inc/js-multilang-help-tools')?>