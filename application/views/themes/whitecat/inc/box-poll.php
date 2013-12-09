<?$poll_data = poll_data();?>

<?if($poll_data):?>
<div class="module">
    <h3><span><span><?=language('community_poll')?></span></span></h3>

    <div class="boxIndent">
        <div class="wrapper">

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
                <?$this->load->view('inc/js-poll-process',array('poll_data'=>$poll_data));?>
            <?else:?>
                <?load_theme_view('poll/results',array('poll_data'=>$poll_data));?>
            <?endif?>
        </div>
    </div>
</div>
<?endif?>