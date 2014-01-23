<?$poll_data = poll_data();?>

<?if($poll_data):?>
<h3><?=language('community_poll')?></h3>

<div class="well">
    <?if(!poll_is_voted($poll_data)):?>
        <?=poll_form_open($poll_data)?>
            <div class="poll">
                <div class="width">
                
                    <div class="question">
                        <?=poll_title($poll_data)?>
                    </div>
                   
                    <ul id="poll-answers" class="unstyled">
                    <?foreach (poll_answers($poll_data) as $answer):?>
                	<li>
                		<?=poll_answer_option($answer)?>
                	</li>
                    <?endforeach;?>
                    </ul>
            
                    <div>
                        <?=form_submit("submit",language('vote'),"class='btn'");?>
                    </div>

                </div>
            </div>
        </form>
        <?=load_inline_js('inc/js-poll-process',array('poll_data'=>$poll_data));?>
    <?else:?>
        <?load_theme_view('poll/results',array('poll_data'=>$poll_data));?>
    <?endif?>
</div>
<?endif?>