<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

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
			
				<div>
					<?if(is_array($customer_answers[$q['id']])):?>
					
						<div class="fl"><input type="checkbox" disabled="disabled" <?if( in_array($q_answer['id'],$customer_answers[$q['id']]) ):?>checked="checked"<?endif?> /></div>
						
						<div class="quiz-answer <?if( (is_array($correct_answers[$q['id']]) && in_array($q_answer['id'],$correct_answers[$q['id']])) ):?> quiz-answer-correct<?endif?>"></div>
					
						<div class="fl"><?=htmlspecialchars($q_answer['answer'])?></div>
						
					<?else:?>
					
						<div class="fl"><?=language('your_answer')?>: <strong><?=htmlspecialchars($customer_answers[$q['id']])?></strong>. <?=language('correct_answer')?>: <?=htmlspecialchars($q_answer['answer'])?></div>
						
					<?endif?>
					
					<div class="clear"></div>
				</div>
				
			<?endforeach?>
			
		</div>
		
		<hr />
	
	<?endif?>
	
<?endforeach?>
