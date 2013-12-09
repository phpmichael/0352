<div class="red"><?=validation_errors()?></div>

<?=form_open()?>

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("percents")?>: <span class="red">*</span></td>
	<td><?=form_input("percents",set_value('percents',@$percents));?> %</td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("amount")?>: <span class="red">*</span></td>
	<td><?=form_input("amount",set_value('amount',@$amount));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("possible_uses")?>: <span class="red">*</span></td>
	<td><?=form_input("possible_uses",set_value('possible_uses',@$possible_uses));?></td>
</tr>
<?if(!isset($id)):?>
<tr>
	<td><?=$BC->_getFieldTitle("coupon_format")?>: <span class="red">*</span></td>
	<td><?=form_dropdown("coupon_format",array('alnum'=>'Alpha-numeric string','numeric'=>'Numeric string'),set_value('coupon_format',@$coupon_format));?></td>
</tr>
<?endif?>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>