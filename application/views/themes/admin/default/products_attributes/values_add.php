<? 
$attr_id = $this->uri->segment($BC->_getSegmentsOffset()+3);
?>

<p>
	<?=anchor($BC->_getBaseURI(),language('attributes_list'))?> 
	<?if(userAccess($BC->_getController(),'edit')):?>
		| <?=anchor($BC->_getBaseURI().'/edit/id/asc/0/'.$attr_id,language('edit_attribute'))?>
	<?endif?>
</p>

<p><?=anchor($BC->_getBaseURI().'/values_list/'.$attr_id,language('values_list'))?></p>

<div class="red"><?=validation_errors()?></div>

<?=form_open()?>

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?>.</td>
</tr>
<?foreach (get_multilang_codes() as $lang_code):?>
<tr>
	<td width="150"><?=$BC->_getFieldTitle("value")?> (<?=$lang_code?>): <span class="red">*</span></td>
	<td><?=form_input("value[{$lang_code}]",set_value("value[{$lang_code}]",@$value[$lang_code]),"class='largeinput'");?> <?load_theme_view('inc/tpl-multilang-help-tools',array('lang_code'=>$lang_code))?></td>
</tr>
<?endforeach?>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>

<?=load_inline_js('inc/js-multilang-help-tools')?>