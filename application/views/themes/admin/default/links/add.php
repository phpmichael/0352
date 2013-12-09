<div class="red"><?=validation_errors()?></div>

<?=form_open()?>

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("name")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_input("name[{$lang_code}]",set_value("name[{$lang_code}]",@$name[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<tr>
	<td><?=$BC->_getFieldTitle("link")?>: <span class="red">*</span></td>
	<td><?=form_input("link",set_value('link',@$link),"class='largeinput'");?></td>
</tr>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td><?=$BC->_getFieldTitle("description")?> (<?=$lang_code?>):</td>
	<td><?=form_textarea("description[{$lang_code}]",set_value("description[{$lang_code}]",@$description[$lang_code]),"class='textarea'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>


<?load_theme_view('inc/js-multilang-help-tools')?>