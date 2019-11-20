<div class="red"><?=validation_errors()?></div>

<form action="" method="post">

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("name")?>: <span class="red">*</span></td>
	<td><?=form_input("name",set_value('name',@$name),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("questions_count")?>: <span class="red">*</span></td>
	<td><?=form_input("questions_count",set_value('questions_count',@$questions_count));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("correct_count")?>: <span class="red">*</span></td>
	<td><?=form_input("correct_count",set_value('correct_count',@$correct_count));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("active")?>:</td>
	<td><?=form_dropdown("active",array(0=>language('no'),1=>language('yes')),set_value('active',@$active));?></td>
</tr>
<tr>
    <td><?=$BC->_getFieldTitle("use_timer")?>:</td>
    <td><?=form_dropdown("use_timer",array(0=>language('no'),1=>language('yes')),set_value('active',@$use_timer));?></td>
</tr>
<?if(@$BC->settings_model['quiz_field_type_id']):?>
<tr>
    <td><?=$BC->_getFieldTitle("type_id")?>:</td>
    <td><?=form_dropdown("type_id",array(1=>1,2=>2,3=>3),set_value('type_id',@$type_id));?></td>
</tr>
<?endif?>
<tr>
	<td><?=$BC->_getFieldTitle("description")?>: <span class="red">*</span></td>
	<td><?=form_textarea("description",set_value('description',@$description),"class='richtext'");?></td>
</tr>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>

<?=load_inline_js('inc/js-tinymce')?>