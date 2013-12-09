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
	<td><?=$BC->_getFieldTitle("description")?>: <span class="red">*</span></td>
	<td><?=form_textarea("description",set_value('description',@$description),"class='richtext'");?></td>
</tr>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>

<?$this->load->view('inc/js-tinymce')?>