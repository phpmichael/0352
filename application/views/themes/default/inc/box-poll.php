<?$poll_data = poll_data();?>

<?if($poll_data):?>
<div class="poll-box">
<?if(!poll_is_voted($poll_data)):?>
	<h4><?=poll_title($poll_data)?></h4>
    
    <?=poll_form_open($poll_data)?>
    		
    <?foreach (poll_answers($poll_data) as $answer):?>
	<div>
		<?=poll_answer_option($answer)?>
	</div>
    <?endforeach;?>
    
    <p><?=form_submit("submit",language('vote'));?></p>
    
    </form>
    
    <?=load_inline_js('inc/js-poll-process',array('poll_data'=>$poll_data));?>
<?else:?>
    <?load_theme_view('poll/results',array('poll_data'=>$poll_data));?>
<?endif?>
</div>
<?endif?>