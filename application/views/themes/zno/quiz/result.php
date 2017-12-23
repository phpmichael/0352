<?$BC->load->helper('quiz');?>

<h1><?=$BC->_getPageTitle()?></h1>

<?if( $scores >= $quiz['correct_count'] ):?>
	<h3 class="quiz-question-answered"><?=language('quiz_successfully_finished')?></h3>
<?else:?>
	<h3 class="quiz-question-wrong"><?=language('quiz_failed')?></h3>
<?endif?>

<h4><?=language('your_result')?>: <?=$scores?>/<?=$quiz['questions_count']?></h4>

<h4><?=language('details')?></h4>

<?$num=0; foreach ($quiz_questions as $q):?>

	<?if(isset($correctArr[$q['id']])):  $num++;?>

		<div <?if($correctArr[$q['id']]):?>class="quiz-question-answered"<?else:?>class="quiz-question-wrong"<?endif?>>
			<?=$num?>. <?=htmlspecialchars($q['question'])?>
		</div>

        <?if($q['description']):?>
            <?=$q['description']?>
        <?endif?>
		
		<?if($q['code']):?>
			<div class="code">
				<?=highlight_code($q['code'])?>
			</div>
		<?endif?>

        <?load_theme_view($BC->_getController().'/inc/answers-images', array('answers'=>$answers[$q['id']]));?>
		
		<div>

            <?if(!empty($connected_answers[$q['id']])):?>
                <!-- Multi-radio: start -->
                <!--
                <?foreach ($connected_answers[$q['id']] as $connected_answer):?>
                    <div class="clearfix">
                        <?foreach ($answers[$q['id']] as $q_answer):?>
                            <?if($connected_answer['connect_answer'] == $q_answer['id']):?>
                                <span><?=htmlspecialchars($connected_answer['answer'])?> - </span>
                            <?endif?>

                            <?if($q_answer['id'] == $customer_answers[$q['id']][$connected_answer['id']]):?>
                                <?if($customer_answers[$q['id']][$connected_answer['id']] == $correct_answers[$q['id']][$connected_answer['id']]):?>
                                    <div class="quiz-answer quiz-answer-correct"></div>
                                    <?=quiz_answer($q_answer)?>
                                <?else:?>
                                    <div class="quiz-answer"></div>
                                    <span class="red"><?=quiz_answer($q_answer)?></span>
                                <?endif?>
                            <?elseif($q_answer['id'] == $correct_answers[$q['id']][$connected_answer['id']]):?>
                                <span class="success">(<?=quiz_answer($q_answer)?>)</span>
                            <?endif?>
                        <?endforeach?>
                    </div>
                <?endforeach?>
                -->
                <br>

                <!-- Connected Answers List -->
                <ul class="multi-radio-connected-answers-list">
                    <?foreach ($connected_answers[$q['id']] as $caIndex=>$connected_answer):?>
                        <?if(quiz_answer($connected_answer)):?>
                            <li><?=$caIndex+1?>: <?=quiz_answer($connected_answer)?></li>
                        <?endif?>
                    <?endforeach;?>
                </ul>
                <!-- Answers List -->
                <ul class="multi-radio-answers-list">
                    <?foreach ($answers[$q['id']] as $aIndex=>$q_answer):?>
                        <?if(quiz_answer($q_answer)):?>
                            <li><?=lang_chr($aIndex)?>: <?=quiz_answer($q_answer)?></li>
                        <?endif?>
                    <?endforeach;?>
                </ul>

                <div>
                    <!-- Multi-radio Matrix -->
                    <div class="multi-radio-chars">
                        <?foreach ($answers[$q['id']] as $aIndex=>$q_answer):?>
                            <div>
                                <?=lang_chr($aIndex)?>
                            </div>
                        <?endforeach;?>
                    </div>

                    <?foreach ($connected_answers[$q['id']] as $aIndex=>$connected_answer):?>
                        <div class="multi-radio-row">
                            <?=$aIndex+1?>
                            <?foreach ($answers[$q['id']] as $q_answer):?>
                                <?
                                $correct = ($q_answer['id'] == $correct_answers[$q['id']][$connected_answer['id']] ) ? 1 : 0 ;
                                $checked = ($q_answer['id'] == $customer_answers[$q['id']][$connected_answer['id']] ) ? 1 : 0 ;
                                if($checked){
                                    if(!$correct) $css_class = 'incorrect';
                                    else $css_class = 'correct checked';
                                }
                                else {
                                    $css_class = $correct ? 'correct' : '';
                                }
                                ?>
                                <!--<?=form_radio('answers['.$connected_answer['id'].']',$q_answer['id'],FALSE,"disabled='disabled' class='$css_class'")?>-->
                                <div class="multi-radio-result <?=$css_class?>">
                                    <?if($css_class):?>X<?else:?>&nbsp;<?endif?>
                                </div>
                            <?endforeach;?>
                        </div>
                    <?endforeach;?>
                </div>
                <!-- Multi-radio: end -->
            <?else:?>

                <?foreach ($answers[$q['id']] as $aIndex=>$q_answer):?>

                    <div class="clearfix">
                        <?if(is_array($customer_answers[$q['id']])):?>

                            <div class="pull-left"><input type="checkbox" disabled="disabled" <?if( in_array($q_answer['id'],$customer_answers[$q['id']]) ):?>checked="checked"<?endif?> /></div>

                            <div class="quiz-answer <?if( (is_array($correct_answers[$q['id']]) && in_array($q_answer['id'],$correct_answers[$q['id']])) ):?> quiz-answer-correct<?endif?>"></div>

                            <div class="pull-left"><?=quiz_answer($q_answer, $aIndex)?></div>

                        <?else:?>

                            <div class="pull-left">
                                <?=language('your_answer')?>: <strong><?=htmlspecialchars($customer_answers[$q['id']])?></strong>.
                                <?=language('correct_answer')?>: <?=quiz_answer($q_answer)?>
                            </div>

                        <?endif?>
                    </div>

                <?endforeach?>

            <?endif?>
			
		</div>
		
		<hr />
	
	<?endif?>
	
<?endforeach?>
