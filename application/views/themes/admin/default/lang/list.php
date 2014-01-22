<!--Load JS-->
<?php $this->load->view('inc/js-select_all'); ?>
<?=include_js($BC->_getFolder('js').'phpjs/functions/get_html_translation_table.js')?>
<?=include_js($BC->_getFolder('js').'phpjs/functions/htmlspecialchars.js')?>
<?=include_js($BC->_getFolder('js').'custom/tdata.js')?>
<!--Load JS-->

<!--Load Search Form-->
<?php 
$fields_names = array('sections','code');
foreach (get_multilang_codes() as $lang_code)
{
	$fields_names[] = $lang_code;
}
load_theme_view('inc/form-search',array('fields_names'=>$fields_names));
?>
<!--Load Search Form-->

<?=br(2)?>

<?if(userAccess($BC->_getController(),'add')):?>
<p>
	<input type="button" value="<?=language('add_language_code')?>" id="add_tdata" />
</p>
<?endif?>

<?=br(2)?>

<?if($query->num_rows()>0):?>

<p><?=anchor__Delete_Selected()?></p>

<?=aform_open__Delete_Selected()?>
<table class="list">
<tr id="tdata_caption">
	<th width="20"><?=form_checkbox("toggle_all",'1',false,"onclick='ToggleAll()'")?></th>
	<th width="50"><?=anchor_field_title("id")?></th>
	<th><?=anchor_field_title("sections")?></th>
	<th><?=anchor_field_title("code")?></th>
	<?foreach (get_multilang_codes() as $lang_code):?>
	<th><?=language($BC->lang_model->getLanguageByLangCode($lang_code))?></th>
	<?endforeach?>
	<th width="50">&nbsp;</th>
</tr>

<?foreach ($query->result() as $row):?>
<tr>
	<td><?=form_checkbox("check[$row->id]",'1',false)?></td>
	<td class="tdata" id="<?=$row->code?>__id"><?=$row->id?></td>
	<td class="tdata" id="<?=$row->code?>__sections"><?=$row->sections?></td>
	<td class="tdata" id="<?=$row->code?>__code"><?=$row->code?></td>
	<?foreach (get_multilang_codes() as $lang_code):?>
	<td class="tdata" id="<?=$row->code?>__<?=$lang_code?>"><?=$row->$lang_code?></td>
	<?endforeach?>
	<td width="100">
		<?if(userAccess($BC->_getController(),'edit')):?>
			<span class="css3-icon css3-icon-edit"><a href="javascript:void(0);" class="edit_tdata" title="<?=language('edit')?>"><?=language('edit')?></a></span>
		<?endif?>
	</td>
</tr>
<?endforeach;?>

</table>
</form>

<div class="pagination"><?=$paginate?></div>

<?endif;?>

<script>

$j(document).ready(function() 
{
	var update_url = '<?=site_url($BC->_getBaseURI()."/update")?>';
	var delete_url = '<?=site_url($BC->_getBaseURI()."/delete")?>';
	
	$j("#add_tdata").click(function(){
		link = $j('a[code=NEW]');
		
		if(link.length==0)
		{
			$j('<tr><td id="new_checkbox"></td><td class="tdata" id="NEW__id"></td><td class="tdata" id="NEW__sections"></td><td class="tdata" id="NEW__code"></td><?foreach (get_multilang_codes() as $lang_code):?><td class="tdata" id="NEW__<?=$lang_code?>"></td><?endforeach?><td width="100"><span class="css3-icon css3-icon-edit"><a href="javascript:void(0);" class="edit_tdata" code="NEW">Add</a></span></td></tr>').insertAfter("#tdata_caption");
			
			link = $j('a[code=NEW]');
			
			activate_tdata(link,update_url);
			
			$j(link).click(function(){
				activate_tdata(this,update_url);
			});
		}
	});
	
	$j(".edit_tdata").click(function(){
		activate_tdata(this,update_url);
	});
	
	$j(".delete_tdata").click(function(){
		delete_tdata(this,delete_url);
	});
	
});

</script>