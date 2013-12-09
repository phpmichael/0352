<? $quiz_id = $this->uri->segment($BC->_getSegmentsOffset()+3);?>

<p><?=anchor($BC->_getBaseURI().'/questions_list/'.$quiz_id,language('questions_list'))?></p>

<div class="red"><?=validation_errors()?></div>

<form action="" method="post">

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("time")?>: <span class="red">*</span></td>
	<td><?=form_dropdown("time",array(30=>0.5,60=>1,120=>2,180=>3,240=>4,300=>5),set_value('time',@$time));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("question")?>: <span class="red">*</span></td>
	<td><?=form_textarea("question",set_value('question',@$question),"class='textarea'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("code")?>: </td>
	<td><?=form_textarea("code",set_value('code',@$code),"class='textarea'");?></td>
</tr>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>