<table class="list">
<tr>
	<th colspan="2"><b><?=language('user')?></b></th>
</tr>

<?foreach ($EMAIL_TPL_CUSTOMER as $key=>$val):?>
<tr>
	<td><?=$key?></td>
	<td><?=$val?></td>
</tr>
<?endforeach;?>

<?if(!empty($EMAIL_TPL_ORDERS)):?>
<tr>
	<th colspan="2"><b><?=language('orders')?></b></th>
</tr>

<?foreach ($EMAIL_TPL_ORDERS as $key=>$val):?>
<tr>
	<td><?=$key?></td>
	<td><?=$val?></td>
</tr>
<?endforeach;?>
<?endif?>

<?if(!empty($EMAIL_TPL_SUBSCRIBERS)):?>
<tr>
	<th colspan="2"><b><?=language('mass_mail')?></b></th>
</tr>

<?foreach ($EMAIL_TPL_SUBSCRIBERS as $key=>$val):?>
<tr>
	<td><?=$key?></td>
	<td><?=$val?></td>
</tr>
<?endforeach;?>
<?endif?>

<tr>
	<th colspan="2"><b><?=language('other')?></b></th>
</tr>

<?foreach ($EMAIL_TPL_SETTINGS as $key=>$val):?>
<tr>
	<td><?=$key?></td>
	<td><?=$val?></td>
</tr>
<?endforeach;?>

<?foreach ($EMAIL_TPL_OTHER as $key=>$val):?>
<tr>
	<td><?=$key?></td>
	<td><?=$val?></td>
</tr>
<?endforeach;?>

</table>