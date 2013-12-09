<?
    //show poll results after user voted
    if(!isset($poll_data)) $poll_data = poll_data($poll_id);
?>
<div class="poll-results-box">
    
	<div class="question"><?=poll_title($poll_data)?></div>
    		
    <?foreach (poll_results($poll_data) as $result):?>
	<div class="poll-result-bar" <?=poll_result_bar($result)?>>
	   <span><?=poll_answer($result)?></span>
	</div>
    <?endforeach;?>

</div>