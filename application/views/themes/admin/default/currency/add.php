<div class="red"><?=validation_errors()?></div>

<?=form_open()?>

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>

<tr>
	<td><?=$BC->_getFieldTitle("code")?>: <span class="red">*</span></td>
	<td><?=form_input("code",set_value('code',@$code));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("title")?>: <span class="red">*</span></td>
	<td><?=form_input("title",set_value('title',@$title));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("exchange_rate")?>: <span class="red">*</span></td>
	<td><?=form_input("exchange_rate",set_value('exchange_rate',@$exchange_rate));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("symbol")?>: <span class="red">*</span></td>
	<td><?=form_input("symbol",set_value('symbol',@$symbol));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("symbol_location")?>:</td>
	<td><?=form_dropdown("symbol_location",array('before'=>language('before'),'after'=>language('after')),set_value('symbol_location',@$symbol_location));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("default")?>:</td>
	<td><?=form_dropdown("default",array(0=>language('no'),1=>language('yes')),set_value('default',@$default));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("enabled")?>:</td>
	<td><?=form_dropdown("enabled",array(0=>language('no'),1=>language('yes')),set_value('enabled',@$enabled));?></td>
</tr>

</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>