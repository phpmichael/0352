<table>
<tr>
	<td width="230"><?=$BC->_getFieldTitle("email")?>: <span class="red">*</span> <br/><small>(<?=language('used_to_enter_the_account')?>)</small></td>
	<td>
	<?if(@$id):?>
		<?=$email?>
	<?else:?>
		<?=form_input("email",set_value('email',@$email),"class='required email'");?>
	<?endif?>
	</td>
</tr>
<tr>
	<td colspan="2" id="check_email"></td>
</tr>
<?if(@$id):?>
<tr>
    <td><a href="javascript:void(0)" onclick="$j('.hide-change-password').show()"><?=language('change_password')?></a></td>
</tr>
<?endif?>
<tr <?if(@$id):?>class="hide-change-password" style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("password")?>: <span class="red">*</span></td>
	<td><?=form_password("password","");?></td>
</tr>
<tr <?if(@$id):?>class="hide-change-password" style="display:none;"<?endif?>>
	<td><?=$BC->_getFieldTitle("repassword")?>: <span class="red">*</span></td>
	<td><?=form_password("repassword","");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("name")?>: <span class="red">*</span></td>
	<td><?=form_input("name",set_value('name',@$name),"class='required'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("surname")?>: <span class="red">*</span></td>
	<td><?=form_input("surname",set_value('surname',@$surname),"class='required'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("phone")?>: <span class="red">*</span></td>
	<td><?=form_input("phone",set_value('phone',@$phone),"class='required'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("phone2")?>:</td>
	<td><?=form_input("phone2",set_value('phone2',@$phone2));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("city")?>: <span class="red">*</span></td>
	<td><?=form_input("city",set_value('city',@$city),"class='required'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("address")?>: <span class="red">*</span></td>
	<td><?=form_input("address",set_value('address',@$address),"class='required'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("zip_code")?>: <span class="red">*</span></td>
	<td><?=form_input("zip_code",set_value('zip_code',@$zip_code),"class='required'");?></td>
</tr>
</table>

<?$this->load->view('inc/js-validate')?>

<script>
    $j("#registration_form").validate();
</script>