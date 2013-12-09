<?load_theme_view($BC->formbuilder_model->getInputPartsPath().'label',array('item'=>$item))?>

<?
$answers = $BC->formbuilder_model->getAnswersetsValues($item['answerset_id']); 
foreach ($answers as &$answer)
{
    $answer['value'] = $BC->formbuilder_model->getAnswerValue($answer);
}
$answers = multi2singleArray('value','label',$answers);
?>

<?load_theme_view($BC->formbuilder_model->getInputPartsPath().'div_open',array('item'=>$item))?>

    <?if($BC->formbuilder_model->getFormMode()=='edit'):?>
    	<?=form_dropdown($BC->formbuilder_model->getInputName($item),$answers,$item['value'],$BC->formbuilder_model->buildInputExtra($item))?>
    	<?=(isset($item['hint'])?$item['hint']:'')?>
    <?else:?>
		<?=$answers[$item['value']]?>
	<?endif?>
    
</div>