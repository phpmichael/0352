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
	<td><?=$BC->_getFieldTitle("html_id")?>: <span class="red">*</span></td>
	<td><?=form_input("html_id",set_value('html_id',@$html_id),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("store_in_table")?>:</td>
	<td><?=form_input("store_in_table",set_value('store_in_table',@$store_in_table),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("method")?>:</td>
	<td><?=form_dropdown("method",array('post'=>'post','get'=>'get'),set_value('method',@$method),"style='width:70px;'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("action")?>:</td>
	<td><?=form_input("action",set_value('action',@$action),"class='largeinput'");?></td>
</tr>
<tr>
	<td><?=$BC->_getFieldTitle("multipart")?>:</td>
	<td><?=form_dropdown("multipart",array('no'=>language('no'),'yes'=>language('yes')),set_value('multipart',@$multipart),"style='width:50px;'");?></td>
</tr>
</table>

<p><?=form_button("button",language('save'),"class='submit'");?></p>

</form>


<?=load_inline_js('inc/js-multilang-help-tools')?>