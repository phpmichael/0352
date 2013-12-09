<div class="red"><?=validation_errors()?></div>

<form action="" method="post">

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("email")?>: <span class="red">*</span> <br/><small>(<?=language('used_to_enter_the_account')?>)</small></td>
	<td><?=form_input("email",set_value('email',@$email),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("password")?>: <span class="red">*</span></td>
	<td><?=form_password("password","","class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("repassword")?>: <span class="red">*</span></td>
	<td><?=form_password("repassword","","class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("name")?>: <span class="red">*</span></td>
	<td><?=form_input("name",set_value('name',@$name),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("surname")?>: <span class="red">*</span></td>
	<td><?=form_input("surname",set_value('surname',@$surname),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("phone")?>: </td>
	<td><?=form_input("phone",set_value('phone',@$phone),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("phone2")?>: </td>
	<td><?=form_input("phone2",set_value('phone2',@$phone2),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("website")?>: </td>
	<td><?=form_input("website",set_value('website',@$website),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("city")?>: </td>
	<td><?=form_input("city",set_value('city',@$city),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("address")?>: </td>
	<td><?=form_input("address",set_value('address',@$address),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("zip_code")?>: </td>
	<td><?=form_input("zip_code",set_value('zip_code',@$zip_code),"class='largeinput'");?></td>
</tr>
<?if(userAccess('groups','view')):?>
<tr>
	<td><?=$BC->_getFieldTitle("group_id")?>:</td>
	<td><?=form_dropdown("group_id",$BC->groups_model->getGroupsList(),set_value('group_id',@$group_id));?></td>
</tr>
<?endif?>

</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>