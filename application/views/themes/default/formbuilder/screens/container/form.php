<div class="fb-output-screen">

	<?if($BC->formbuilder_model->getFormMode()=='edit'):?>

		<div class="error">
	    	<?=validation_errors()?>
	    </div>
	
		<?=(($item['multipart']=='yes')?form_open_multipart($item['action']):form_open(str_replace('[LANG]',$BC->_getInterfaceLang(),$item['action'])))?>
	
	<?endif?>
	
		<?if(isset($item['children'])):?>
		    <?load_theme_view($BC->formbuilder_model->getScreensPath().'template/list',array('items'=>$item['children'],'parent'=>$item))?>
		<?endif?>
		
	<?if($BC->formbuilder_model->getFormMode()=='edit'):?>
	
		</form>
	
	<?endif?>

</div>