<?if(@$orders_customer_info_id):?>
    <?fb_form("orders_customer_info",$orders_customer_info_id,'view')?>
	<?=load_theme_view('orders/shipping/buttons')?>
<?else:?>
	<?=language('customer')?>: <?=(userAccess('customers','edit')? anchor_base("/customers/edit/id/desc/0/".$customer_id, $BC->customers_model->getFullNameById($customer_id)) : $BC->customers_model->getFullNameById($customer_id) )?>
<?endif?>

<div class="red"><?=validation_errors()?></div>

<form action="" method="post" enctype="multipart/form-data">

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("date")?>:</td>
	<td><?=substr($date,0,16)?></td>
</tr>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("order")?>:</td>
	<td><?=$BC->orders_model->show($id)?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("status")?>: <span class="red">*</span></td>
	<td><?=form_dropdown("status",$BC->orders_model->getStatuses(),$status,"class='select'")?></td>
</tr>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>