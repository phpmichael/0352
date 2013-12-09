<div class="red"><?=validation_errors()?></div>

<?=form_open()?>

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?></td>
</tr>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("page_title")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_input("page_title[{$lang_code}]",set_value("page_title[{$lang_code}]",@$page_title[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>

<tr>
	<td colspan="2"><a href="javascript:void(0);" class="showhide_metadata"><?=language('showhide_metadata')?></a></td>
</tr>

<?foreach (get_multilang_codes() as $lang_code):?>
<tr class="hide">
	<td width="150"><?=$BC->_getFieldTitle("meta_keywords")?> (<?=$lang_code?>):</td>
	<td><?=form_input("meta_keywords[{$lang_code}]",set_value("meta_keywords[{$lang_code}]",@$meta_keywords[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr class="hide">
	<td width="150"><?=$BC->_getFieldTitle("meta_description")?> (<?=$lang_code?>):</td>
	<td><?=form_input("meta_description[{$lang_code}]",set_value("meta_description[{$lang_code}]",@$meta_description[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<!--
<tr>
	<td width="150">Is Content: </td>
	<td width="600"><?=$is_content?></td>
</tr>
-->
<?if($is_content=='yes'):?>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td><?=$BC->_getFieldTitle("body")?> (<?=$lang_code?>):</td>
	<td><?=form_textarea("body[{$lang_code}]",set_value("body[{$lang_code}]",@$body[$lang_code]),"class='richtext'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<?endif?>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>

<?$this->load->view('inc/js-tinymce')?>

<?load_theme_view('inc/js-showhide-metadata')?>

<?load_theme_view('inc/js-multilang-help-tools')?>