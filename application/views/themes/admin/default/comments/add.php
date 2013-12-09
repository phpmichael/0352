<div class="red"><?=validation_errors()?></div>

<form action="" method="post">

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("comment_author")?>: <span class="red">*</span> </td>
	<td><?=form_input("comment_author",set_value('comment_author',@$comment_author),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("comment_author_email")?>: <span class="red">*</span> </td>
	<td><?=form_input("comment_author_email",set_value('comment_author_email',@$comment_author_email),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("comment_author_url")?>: </td>
	<td><?=form_input("comment_author_url",set_value('comment_author_url',@$comment_author_url),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("comment_content")?>: <span class="red">*</span> </td>
	<td><?=form_textarea("comment_content",set_value('comment_content',@$comment_content),"class='textarea'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("comment_approved")?>:</td>
	<td><?=form_dropdown("comment_approved",array(0=>'No',1=>'Yes'),set_value('comment_approved',@$comment_approved));?></td>
</tr>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>