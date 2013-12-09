<div class="red"><?=validation_errors()?></div>

<?=form_open()?>

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("products_count")?>: <span class="red">*</span></td>
	<td><?=form_input("products_count",set_value('products_count',@$products_count));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("order_amount")?>: <span class="red">*</span></td>
	<td><?=form_input("order_amount",set_value('order_amount',@$order_amount));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("discount_percent")?>: <span class="red">*</span></td>
	<td><?=form_input("discount_percent",set_value('discount_percent',@$discount_percent));?> %</td>
</tr>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>