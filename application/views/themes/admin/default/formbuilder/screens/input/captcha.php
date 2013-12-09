<?if($BC->formbuilder_model->getFormMode()=='edit'):?>

	<?load_theme_view($BC->formbuilder_model->getInputPartsPath().'label',array('item'=>$item))?>
	
	<?load_theme_view($BC->formbuilder_model->getInputPartsPath().'div_open',array('item'=>$item))?>
		<?load_model('captcha_model')?>
		<div>
			<?=$BC->captcha_model->make()?>
		</div>
	    <div>
	    	<?=form_input($BC->formbuilder_model->getInputName($item),'',$BC->formbuilder_model->buildInputExtra($item))?>
	    	<?=(isset($item['hint'])?$item['hint']:'')?>
	    </div>
	    <div style="clear:both"></div>
	</div>

<?endif?>