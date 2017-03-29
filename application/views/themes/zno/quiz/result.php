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
		
		<?if($q['code']):?>
			<div class="code">
				<?=highlight_code($q['code'])?>
			</div>
		<?endif?>
		
		<div>
		
			<?foreach ($answers[$q['id']] as $q_answer):?>
			
				<div class="clearfix">
					<?if(!empty($connected_answers[$q['id']])):?>

						<div>
							<?=htmlspecialchars($q_answer['answer'])?> - 

							<?foreach ($connected_answers[$q['id']] as $connected_answer):?>
								<?if($connected_answer['id'] == $customer_answers[$q['id']][$q_answer['id']]):?>
									<?if($customer_answers[$q['id']][$q_answer['id']] == $correct_answers[$q['id']][$q_answer['id']]):?>
										<div class="quiz-answer quiz-answer-correct"></div>
										<?=htmlspecialchars($connected_answer['answer'])?>
									<?else:?>
										<div class="quiz-answer"></div>
										<span class="red"><?=htmlspecialchars($connected_answer['answer'])?><span>
									<?endif?>
								<?elseif($connected_answer['id'] == $correct_answers[$q['id']][$q_answer['id']]):?>
									<span class="success">(<?=htmlspecialchars($connected_answer['answer'])?>)</span>
								<?endif?>
							<?endforeach?>
						</div>

					<?elseif(is_array($customer_answers[$q['id']])):?>
					
						<div class="pull-left"><input type="checkbox" disabled="disabled" <?if( in_array($q_answer['id'],$customer_answers[$q['id']]) ):?>checked="checked"<?endif?> /></div>
						
						<div class="quiz-answer <?if( (is_array($correct_answers[$q['id']]) && in_array($q_answer['id'],$correct_answers[$q['id']])) ):?> quiz-answer-correct<?endif?>"></div>
					
						<div class="pull-left"><?=htmlspecialchars($q_answer['answer'])?></div>
						
					<?else:?>
					
						<div class="pull-left">
							<?=language('your_answer')?>: <strong><?=htmlspecialchars($customer_answers[$q['id']])?></strong>.
							<?=language('correct_answer')?>: <?=htmlspecialchars($q_answer['answer'])?>
						</div>
						
					<?endif?>
				</div>
				
			<?endforeach?>
			
		</div>
		
		<hr />
	
	<?endif?>
	
<?endforeach?>
