<?if($item['answerset_id']):?>

<fieldset>

    <?load_theme_view($BC->formbuilder_model->getInputPartsPath().'legend',array('item'=>$item))?>

    <?load_theme_view($BC->formbuilder_model->getInputPartsPath().'div_open',array('item'=>$item))?>
        <?$answers = $BC->formbuilder_model->getAnswersetsValues($item['answerset_id']);?>
        
        <?foreach ($answers as $answer): 
            $answer_value = $BC->formbuilder_model->getAnswerValue($answer);
            if(is_array($item['value'])) $checked = in_array($answer_value,$item['value']);
            else $checked = ($answer_value==$item['value']);
            $item['html_id'] = $BC->formbuilder_model->getAnswerCSSId($item,$answer);
            ?>
            
            <?if($BC->formbuilder_model->getFormMode()=='edit'):?>
	            <span>
	                <?=form_checkbox($BC->formbuilder_model->getInputName($item)."[]",$answer_value,$checked,$BC->formbuilder_model->buildInputExtra($item))?>
	                <?=form_label($answer['label'],$item['html_id'],array('class'=>'choice'))?>
	            </span>
	        <?else:?>
	        	<?if($checked) echo '<div>'.$answer['label'].'</div>'?>
	        <?endif?>
            
        <?endforeach;?>
    </div>

</fieldset>

<?else:?>

	<?$checked = (bool)$item['value']?>

	<?if($BC->formbuilder_model->getFormMode()=='edit'):?>
	
		<?load_theme_view($BC->formbuilder_model->getInputPartsPath().'label',array('item'=>$item))?>
	
		<?load_theme_view($BC->formbuilder_model->getInputPartsPath().'div_open',array('item'=>$item))?>
		    <?=form_checkbox($BC->formbuilder_model->getInputName($item),1,$checked,$BC->formbuilder_model->buildInputExtra($item))?>
		</div>

	<?else:?>
	
		<?load_theme_view($BC->formbuilder_model->getInputPartsPath().'label',array('item'=>$item))?>
        
        <?if($checked && isset($answer['label'])) echo '<div>'.$answer['label'].'</div>'?>
	
	<?endif?>
		
<?endif?>