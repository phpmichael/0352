<div class="red"><?=validation_errors()?></div>

<?=form_open()?>

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("title")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_input("title[{$lang_code}]",set_value("title[{$lang_code}]",@$title[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<tr>
	<td><?=$BC->_getFieldTitle("active")?>:</td>
	<td><?=form_dropdown("active",array(0=>language('no'),1=>language('yes')),set_value('active',@$active));?></td>
</tr>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>

<?load_theme_view('inc/js-multilang-help-tools')?>