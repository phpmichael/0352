<?$poll_data = poll_data();?>

<?if($poll_data):?>
    <h2><?=language('community_poll')?></h2>

    <div class="boxIndent">
        <?if(!poll_is_voted($poll_data)):?>
            <?=poll_form_open($poll_data)?>
                <div class="poll">
                    <div class="width">
                    
                        <div class="question">
                            <?=poll_title($poll_data)?>
                        </div>
                       
                        <ul id="poll-answers">
                        <?foreach (poll_answers($poll_data) as $answer):?>
                    	<li>
                    		<?=poll_answer_option($answer)?>
                    	</li>
                        <?endforeach;?>
                        </ul>
                
                        <div>
                            <?=form_submit("submit",language('vote'),"class='button'");?>
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