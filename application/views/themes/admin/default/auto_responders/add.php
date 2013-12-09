
<div class="red"><?=validation_errors()?></div>

<?=form_open()?>

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>. <a href="<?=site_url($BC->_getBaseURL()."email_tpl_vars")?>"><?=language('vars_for_templates')?></a></td>
</tr>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("subject")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_input("subject[{$lang_code}]",set_value("subject[{$lang_code}]",@$subject[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td><?=$BC->_getFieldTitle("message")?> (<?=$lang_code?>):</td>
	<td><?=form_textarea("message[{$lang_code}]",set_value("message[{$lang_code}]",@$message[$lang_code]),"class='richtext'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<tr>
	<td><?=$BC->_getFieldTitle("enabled")?>:</td>
	<td><?=form_dropdown("enabled",array(0=>language('no'),1=>language('yes')),set_value('enabled',@$enabled));?></td>
</tr>
</table>

<p><input type="Submit" value="<?=language('save')?>" class="submit" ></p>

</form>

<?$this->load->view('inc/js-tinymce')?>

<?load_theme_view('inc/js-multilang-help-tools')?>