<div class="red"><?=validation_errors()?></div>
<div class="red"><?=$BC->upload->display_errors()?></div>

<form action="" method="post" enctype="multipart/form-data">

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?></td>
</tr>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("category")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_input("category[{$lang_code}]",set_value("category[{$lang_code}]",@$category[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("description")?> (<?=$lang_code?>):</td>
	<td><?=form_textarea("description[{$lang_code}]",set_value("description[{$lang_code}]",@$description[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<tr>
	<td width="150"><?=language('photo')?>: <span class="red">*</span>
	   <br /><br /><a href="javascript:void(0);" onclick="$j('.alt_attr').toggle();"><?=language('add_alt_attribute_for_image')?></a>
	</td>
	<td><?=form_upload("image");?></td>
</tr>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr class="alt_attr" style="display:none;">
	<td width="150"><?=$BC->_getFieldTitle("alt")?> (<?=$lang_code?>):</td>
	<td><?=form_input("alt[{$lang_code}]",set_value("alt[{$lang_code}]",@$alt[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>

<?load_theme_view('inc/js-multilang-help-tools')?>