<div class="red"><?=validation_errors()?></div>

<?=form_open()?>

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>

<?load_theme_view('inc/tpl-categories-view-and-select',array('categories_model'=>'articles_categories'))?>

<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("head")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_input("head[{$lang_code}]",set_value("head[{$lang_code}]",@$head[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
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
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td><?=$BC->_getFieldTitle("body")?> (<?=$lang_code?>):</td>
	<td><?=form_textarea("body[{$lang_code}]",set_value("body[{$lang_code}]",@$body[$lang_code]),"class='richtext'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("author")?> (<?=$lang_code?>):</td>
	<td><?=form_input("author[{$lang_code}]",set_value("author[{$lang_code}]",@$author[$lang_code]),"class='largeinput'");?></td>
</tr>
<?endforeach?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("source")?>: </td>
	<td><?=form_input("source",set_value('source',@$source),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("comments_opened")?>:</td>
	<td><?=form_dropdown("comments_opened",array('default'=>language('default'),'no'=>language('no'),'yes'=>language('yes')),set_value('comments_opened', @$comments_opened ));?></td>
</tr>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>

<?=load_inline_js('inc/js-tinymce')?>

<?=load_inline_js('inc/js-selectboxes')?>
<?=load_inline_js('inc/js-load-category',array('parent_category'=>0))?>

<script>
var multi_categories = true;
var multi_categories_level = <?=intval(@$BC->settings_model['articles_categories_multi_level'])?>;

$j(document).ready(function(){
	<?if(!isset($post_categories)):?>
	load_category(0,false,"articles_categories");
	<?endif?>
});
</script>

<?load_theme_view('inc/js-multilang-help-tools')?>

<?load_theme_view('inc/js-showhide-metadata')?>

<?=load_inline_js('inc/js-facebox'); ?>