<?$form_id = $this->uri->segment($BC->_getSegmentsOffset()+3);?>

<?=include_css($BC->_getFolder('js').'custom/fb/fb.css')?>

<div id="formbuilder">

	<div id="flash-messages-box"></div>
	
	<div>
		<div id="form-tree-buttons">
	        <a href="javascript:void(0)" id="preview-form" title="Preview Form" class="preview-item"></a>
	        <a href="javascript:void(0)" id="add-form" title="Add Form" class="add-item"></a>
	        <a href="javascript:void(0)" id="add-container" title="Add Container" class="add-item"></a>
	        <a href="javascript:void(0)" id="add-input" title="Add Input" class="add-item"></a>
	        <a href="javascript:void(0)" id="remove-forms-item" title="Remove" class="remove-item"></a>
	        <a href="javascript:void(0)" id="export-form" title="Export Form" class="export-item"></a>
	        <a href="javascript:void(0)" id="create-table" title="Create Table" class="create-item"></a>
	        
	        <a href="javascript:void(0)" id="attach-answerset" title="Attach Answerset" class="attach-detach"></a>
	        <a href="javascript:void(0)" id="detach-answerset" title="Detach Answerset" class="attach-detach"></a>
	        
	        <a href="javascript:void(0)" id="copy-item" title="Copy" class="copy-item"></a>
	        <a href="javascript:void(0)" id="paste-item" title="Paste" class="paste-item"></a>
        </div>
        
        <div id="answerset-tree-buttons" style="display:none;">
	        <a href="javascript:void(0)" id="add-answerset" title="Add Answerset" class="add-item"></a>
			<a href="javascript:void(0)" id="add-answerset-value" title="Add Answer" class="add-item"></a>
			<a href="javascript:void(0)" id="remove-answersets-item" title="Remove" class="remove-item"></a>
		</div>
    </div>
    <div class="clear"></div>
	
	<div id="formbuilder-left">
	
		<div id="accordion">
        
	    	<h3 id="form-tree-header">Form Builder</h3>
	        <div class="accordion-item">
		        <div id="form-tree">
		            <?=$BC->formbuilder_model->showTree($form_id)?>
		        </div>
	        </div>
	        
	        <h3 id="answerset-tree-header">Answerset Builder</h3>
	        <div class="accordion-item">
		        <div id="answerset-tree">
		            <?=$BC->formbuilder_model->showAnswersetTree()?>
		        </div>
	        </div>
	        
	    </div>
	
	</div>
	
	<div id="formbuilder-right">
	
		<div id="screen">
        
    	</div>
	
	</div>
	
	<div class="clear"></div>

</div>

<?$this->load->view('inc/js-jquery-ui')?>
<?=include_js($BC->_getFolder('js').'jquery/jquery.cookie.js')?>
<?=include_js($BC->_getFolder('js').'jquery/jquery.hotkeys.js')?>
<?=include_js($BC->_getFolder('js').'jquery/jstree/jquery.jstree.js')?>

<?//$this->load->view('inc/js-tinymce')?>

<script>
//<![CDATA[
var URLS = 
{
	base : "<?=base_url().$BC->_getBaseURI()?>",
	preview_form : "<?=base_url().$BC->_getBaseURI().'/preview_form'?>",
	export_form : "<?=base_url().$BC->_getBaseURI().'/export_form'?>",
	create_table : "<?=base_url().$BC->_getBaseURI().'/create_table'?>",
	add_form : "<?=base_url().$BC->_getBaseURI().'/forms_add'?>",
	add_container : "<?=base_url().$BC->_getBaseURI().'/containers_add'?>",
	add_input : "<?=base_url().$BC->_getBaseURI().'/inputs_add'?>",
	add_answerset : "<?=base_url().$BC->_getBaseURI().'/answersets_add'?>",
	add_answerset_value : "<?=base_url().$BC->_getBaseURI().'/answersets_values_add'?>",
	copy_form_item : "<?=base_url().$BC->_getBaseURI().'/copy_form_item'?>",
	move_form_item : "<?=base_url().$BC->_getBaseURI().'/move_form_item'?>",
	move_answerset_value : "<?=base_url().$BC->_getBaseURI().'/move_answerset_value'?>"
}

var ICONS = 
{
	input : "<?=base_url()."js/jquery/jstree/img/input.png"?>",
	form : "<?=base_url()."js/jquery/jstree/img/form.png"?>",
	answerset : "<?=base_url()."js/jquery/jstree/img/answerset.png"?>",
	answerset_value : "<?=base_url()."js/jquery/jstree/img/answerset_value.png"?>"
}

var MESSAGES = 
{
	are_you_sure : "<?=language("are_you_sure")?>"
}
//]]>
</script>

<?=include_js($BC->_getFolder('js').'custom/fb/fb.js')?>