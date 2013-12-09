<?$this->load->view('inc/js-meio-mask')?>
<?$this->load->view('inc/js-init-mask')?>

<div class="red"><?=validation_errors()?></div>

<?if(@$success_updated):?>
<div class="green"><?=language('data_updated')?>.</div>
<?endif?>

<form id="registration_form" action="" method="post">

<table>
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<tr>
	<td width="230"><?=$BC->_getFieldTitle("email")?>: <span class="red">*</span> <br/><small>(<?=language('used_to_enter_the_account')?>)</small></td>
	<td>
	<?if(@$id):?>
		<?=$email?>
	<?else:?>
		<?=form_input("email",set_value('email',@$email));?>
	<?endif?>
	</td>
</tr>
<tr>
	<td colspan="2" id="check_email"></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("password")?>: <span class="red">*</span></td>
	<td><?=form_password("password","");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("repassword")?>: <span class="red">*</span></td>
	<td><?=form_password("repassword","");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("name")?>: <span class="red">*</span></td>
	<td><?=form_input("name",set_value('name',@$name));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("surname")?>: <span class="red">*</span></td>
	<td><?=form_input("surname",set_value('surname',@$surname));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("phone")?>:</td>
	<td><?=form_input("phone",set_value('phone',@$phone));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("phone2")?>:</td>
	<td><?=form_input("phone2",set_value('phone2',@$phone2));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("website")?>:</td>
	<td><?=form_input("website",set_value('website',@$website));?>
		<br /><small><?=language('example')?> - http://yourdomain.com</small>
	</td>
</tr>
</table>