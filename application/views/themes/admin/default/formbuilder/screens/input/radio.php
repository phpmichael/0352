<fieldset>

    <?load_theme_view($BC->formbuilder_model->getInputPartsPath().'legend',array('item'=>$item))?>

    <?load_theme_view($BC->formbuilder_model->getInputPartsPath().'div_open',array('item'=>$item))?>
        <?$answers = $BC->formbuilder_model->getAnswersetsValues($item['answerset_id']);?>
        
        <?foreach ($answers as $answer): 
            $answer_value = $BC->formbuilder_model->getAnswerValue($answer);
            $checked = ($answer_value==$item['value']);
            $item['html_id'] = $BC->formbuilder_model->getAnswerCSSId($item,$answer);
            ?>
            
            <?if($BC->formbuilder_model->getFormMode()=='edit'):?>
	            <span>
	                <?=form_radio($BC->formbuilder_model->getInputName($item),$answer_value,$checked,$BC->formbuilder_model->buildInputExtra($item))?>
	                <?=form_label($answer['label'],$item['html_id'],array('class'=>'choice'))?>
	            </span>
	        <?else:?>
	        	<?if($checked) echo '<div>'.$answer['label'].'</div>'?>
	        <?endif?>
	        
        <?endforeach;?>
    </div>

</fieldset>