<? 
$poll_id = $this->uri->segment($BC->_getSegmentsOffset()+3);
?>

<p>
	<?=anchor($BC->_getBaseURI(),language('poll_list'))?> 
	<?if(userAccess($BC->_getController(),'edit')):?>
		| <?=anchor($BC->_getBaseURI().'/edit/id/asc/0/'.$poll_id,language('edit_poll_info'))?>
	<?endif?>
</p>

<p><?=anchor($BC->_getBaseURI().'/answers_list/'.$poll_id,language('answers_list'))?></p>

<div class="red"><?=validation_errors()?></div>

<?=form_open()?>

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("answer")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_input("answer[{$lang_code}]",set_value("answer[{$lang_code}]",@$answer[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>

<?load_theme_view('inc/js-multilang-help-tools')?>