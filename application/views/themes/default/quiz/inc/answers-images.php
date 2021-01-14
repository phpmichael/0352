<!-- Answer images: Start -->
<?php
//make layers the same height for correct float
$answerImagesHeight = array();
foreach ($answers as $aIndex=>$answer) {
    if($answer['image']) {
        list($width, $height) = getimagesize($BC->_getFolder('images') . 'data/b/quiz/' . $answer['image']);
        $answerImagesHeight[] = $height;
    }
}
$imgLayerHeight = max($answerImagesHeight)+20;
?>
<?foreach ($answers as $aIndex=>$answer):?>
    <?if($answer['image']):?>
        <div class="quiz-answer-image" style="height: <?=$imgLayerHeight?>px">
            <?=img(array('src'=>'images/data/b/quiz/'.$answer['image']))?>
            <div><?=lang_chr($aIndex)?></div>
        </div>
    <?endif?>
<?endforeach;?>
<div class="clearfix"></div>
<!-- Answer images: End -->