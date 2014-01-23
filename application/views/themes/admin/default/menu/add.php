<div class="red"><?=validation_errors()?></div>

<form action="" method="post">

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
	<td><?=$BC->_getFieldTitle("link")?>:</td>
	<td><?=form_input("link",set_value('link',@$link),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("page")?>:</td>
	<td><?=form_dropdown("page_id", $BC->pages_model->getContentPagesTitles(), set_value('page_id',@$page_id));?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("menu")?>:</td>
	<td><?=form_dropdown("menu", array('left'=>'Left','bottom'=>'Bottom'), set_value('menu',@$menu));?></td>
</tr>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>

<?=load_inline_js('inc/js-multilang-help-tools')?>