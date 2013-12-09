<div id="ajax_response"></div>

<?=form_open()?>

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("label")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_input("label[{$lang_code}]",set_value("label[{$lang_code}]",@$label[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<tr>
	<td><?=$BC->_getFieldTitle("special_value")?>:</td>
	<td><?=form_input("value",set_value('value',@$value),"class='largeinput'");?></td>
</tr>
</table>

<p><?=form_button("button",language('save'),"class='submit'");?></p>

</form>


<?load_theme_view('inc/js-multilang-help-tools')?>