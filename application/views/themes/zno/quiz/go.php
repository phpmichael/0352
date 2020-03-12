<?$BC->load->helper('quiz');?>

<?if($quiz['quiz']['use_timer']):?>
    <div id="quiz-timer"></div>
<?endif?>

<h1><?=htmlspecialchars($quiz['quiz']['name'])?></h1>

<p id="quiz-question-numbers">
    <?for($question_number = 1; $question_number <= $total_questions; $question_number++):?>
        <?if($amount_answered_questions+1 === $question_number):?>
            <span class="quiz-question-number"><?=$question_number?></span>
        <?else:?>
            <a class="quiz-question-number" href="<?=site_url($BC->_getBaseURL().'quiz/go/'.$quiz['quiz']['id'].'/'.$question_number)?>"><?=$question_number?></a>
        <?endif?>
    <?endfor;?>
</p>

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
<?elseif($quiz['type']=='digits3'):?>
    <div>
        <?foreach ($quiz['answers'] as $aIndex=>$answer):?>
            <div id="digits3-<?=$aIndex+1?>">
                <?=$aIndex+1?> <?=quiz_answer($answer, FALSE)?>
                <?=form_checkbox('answers['.$answer['id'].']',1,FALSE,"id='answer_{$answer['id']}' style='visibility:hidden'")?>
            </div>
        <?endforeach;?>
        <?=form_input('digits3[]','',"style='width:25px' maxlength='1'")?>
        <?=form_input('digits3[]','',"style='width:25px' maxlength='1'")?>
        <?=form_input('digits3[]','',"style='width:25px' maxlength='1'")?>
    </div>
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

<div>
    <?=form_submit("submit",language('reply'));?> &nbsp;
    <?=form_button("skip",language('skip'));?> &nbsp;
    <?=form_button("finish",language('finish_quiz'), "onclick='location.href=\"".site_url($BC->_getBaseURL().'quiz/finish/'.$quiz['quiz']['id'])."\"'");?>
</div>

</form>

<script>
var use_timer = <?=$quiz['quiz']['use_timer']?>;
var time_left = <?=$quiz['question']['time']?>;
var are_you_sure = "<?=language('are_you_sure')?>";
</script>

<?load_theme_view('inc/question-show-type',array('quiz'=>$quiz));?>
<p>Знайшли помилку? Пишіть на <a href="mailto:znobooks@ukr.net">znobooks@ukr.net</a></p>
