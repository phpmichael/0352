<?$BC->load->helper('quiz');?>

<div id="quiz-timer"></div>

<h1><?=$BC->_getPageTitle()?></h1>

<h3><?=language('progress')?>: <?=$amount_answered_questions+1?>/<?=$total_questions?></h3>

<div><?=htmlspecialchars($quiz['question']['question'])?></div>

<?if($quiz['question']['description']):?>
    <?=$quiz['question']['description']?>
<?endif?>

<?if($quiz['question']['code']):?>
	<div class="code">
		<?=highlight_code($quiz['question']['code'])?>
		<div class="plast"></div>
	</div>
<?endif?>

<?load_theme_view($BC->_getController().'/inc/answers-images', array('answers'=>$quiz['answers']));?>

<br />

<form id="quiz-form" class="form-inline form-horizontal" action="<?=site_url($BC->_getBaseURL().'quiz/submit/'.$quiz['quiz']['id'].'/'.$quiz['question']['id']);?>" method="post">

<?if($quiz['type']=='multi-radio'):?>
    <!-- Connected Answers List -->
    <ul class="multi-radio-connected-answers-list">
        <?foreach ($quiz['connected_answers'] as $caIndex=>$connected_answer):?>
            <?if(quiz_answer($connected_answer)):?>
                <li><?=$caIndex+1?>: <?=quiz_answer($connected_answer)?></li>
            <?endif?>
        <?endforeach;?>
    </ul>
    <!-- Answers List -->
    <ul class="multi-radio-answers-list">
        <?foreach ($quiz['answers'] as $aIndex=>$answer):?>
            <?if(quiz_answer($answer)):?>
                <li><?=lang_chr($aIndex)?>: <?=quiz_answer($answer)?></li>
            <?endif?>
        <?endforeach;?>
    </ul>

    <!-- Multi-radio Matrix -->
    <div class="multi-radio-chars">
        <?foreach ($quiz['answers'] as $aIndex=>$answer):?>
            <div>
                <?=lang_chr($aIndex)?>
            </div>
        <?endforeach;?>
    </div>
    <?foreach ($quiz['connected_answers'] as $aIndex=>$connected_answer):?>
        <div class="multi-radio-row">
            <?=$aIndex+1?>
            <?foreach ($quiz['answers'] as $answer):?>
                <?=form_radio('answers['.$connected_answer['id'].']',$answer['id'],FALSE,"id='answer_{$connected_answer['id']}_{$answer['id']}'")?>
                <!-- <label for="answer_<?=$connected_answer['id']?>_<?=$answer['id']?>"><?=quiz_answer($answer)?></label> -->
            <?endforeach;?>
        </div>
    <?endforeach;?>
<?else:?>
    <?foreach ($quiz['answers'] as $aIndex=>$answer):?>
        <div>
            <?if($quiz['type']=='input'):?>
                <?=form_input('custom_answer','')?>
            <?elseif($quiz['type']=='checkbox'):?>
                <?=form_checkbox('answers['.$answer['id'].']',1,FALSE,"id='answer_{$answer['id']}'")?> <label for="answer_<?=$answer['id']?>"><?=quiz_answer($answer, $aIndex)?></label>
            <?else:?>
                <?=form_radio('answer',$answer['id'],FALSE,"id='answer_{$answer['id']}'")?> <label for="answer_<?=$answer['id']?>"><?=quiz_answer($answer, $aIndex)?></label>
            <?endif?>
        </div>
    <?endforeach;?>
<?endif;?>

<div><?=form_submit("submit",language('next'));?></div>

</form>

<script>
var time_left = <?=$quiz['question']['time']?>;
var are_you_sure = "<?=language('are_you_sure')?>";
</script>