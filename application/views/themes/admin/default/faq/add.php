<div class="red"><?=validation_errors()?></div>

<?=form_open()?>

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("question")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_input("question[{$lang_code}]",set_value("question[{$lang_code}]",@$question[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("answer")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_textarea("answer[{$lang_code}]",set_value("answer[{$lang_code}]",@$answer[$lang_code]),"class='textarea'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>


<?=load_inline_js('inc/js-multilang-help-tools')?>