<!-- Answer images: Start -->
<?foreach ($answers as $aIndex=>$answer):?>
    <?if($answer['image']):?>
        <div class="pull-left" style="text-align: center">
            <?=img(array('src'=>'images/data/b/quiz/'.$answer['image']))?>
            <br>
            <?=lang_chr($aIndex)?>
        </div>
    <?endif?>
<?endforeach;?>
<div class="clearfix"></div>
<!-- Answer images: End -->