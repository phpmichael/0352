<div class="fb-output-screen">

	<?if($BC->formbuilder_model->getFormMode()=='edit'):?>

		<div class="error">
	    	<?=validation_errors()?>
	    </div>
	
	    <?
	       $form_action = str_replace('[LANG]',$BC->_getInterfaceLang(),$item['action']);
	       $form_attributes = array( 'data_key' => $BC->formbuilder_model->getDataKey() );
	       if($item['multipart']=='yes') $form_attributes['enctype'] = 'multipart/form-data';
	    ?>
	    
		<?=form_open($form_action,$form_attributes)?>
	
	<?endif?>
	
		<?if(isset($item['children'])):?>
		    <?load_theme_view($BC->formbuilder_model->getScreensPath().'template/list',array('items'=>$item['children'],'parent'=>$item))?>
		<?endif?>
		
	<?if($BC->formbuilder_model->getFormMode()=='edit'):?>
	
		</form>
	
	<?endif?>

</div>