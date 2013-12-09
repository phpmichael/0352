<?load_theme_view($BC->formbuilder_model->getInputPartsPath().'label',array('item'=>$item))?>

<?load_theme_view($BC->formbuilder_model->getInputPartsPath().'div_open',array('item'=>$item))?>

	<?if($BC->formbuilder_model->getFormMode()=='edit'):?>
    	<?=form_upload($BC->formbuilder_model->getInputName($item),'',$BC->formbuilder_model->buildInputExtra($item))?>
    	<?=(isset($item['hint'])?$item['hint']:'')?>
    <?endif?>
    
    <?if($item['value']):?>
    <div>
    	<?if(preg_match("/\.(jpg|jpeg|png|gif)$/i",$item['value'])):?>
        	<a href="<?=base_url().'images/data/b/'.$this->formbuilder_model->getFormFilesStorePath().'/'.$item['value']?>" class="lightbox"><?=img('images/data/s/'.$this->formbuilder_model->getFormFilesStorePath().'/'.$item['value'])?></a>
        <?else:?>
        	<a href="<?=base_url().'images/data/files/'.$this->formbuilder_model->getFormFilesStorePath().'/'.$item['value']?>"><?=language('file')?></a>
        <?endif?>
        
        <?if($BC->formbuilder_model->getFormMode()=='edit'):?>
	        <br />
	        <?=anchor($this->formbuilder_model->getRemoveFileURL($item['name']),language('remove'),"class='remove-file'")?>
	    <?endif?>
    </div>
    <?endif?>
    
</div>