<?$poll_data = poll_data();?>

<?if($poll_data):?>
<div class="block block-poll">
    <div class="full-width">
        <div class="block-title">
            <strong><span><?=language('community_poll')?></span></strong>
        </div>

        <div class="block-content">
            <p class="block-subtitle"><?=poll_title($poll_data)?></p>
            
                <?if(!poll_is_voted($poll_data)):?>
                
                	<?=poll_form_open($poll_data)?>
                    
                        <ul id="poll-answers">
                        <?foreach (poll_answers($poll_data) as $answer):?>
                    	<li>
                    		<?=poll_answer_option($answer)?>
                    	</li>
                        <?endforeach;?>
                        </ul>
                
                        <div class="actions">
                            <?=form_button("submit",'<span><span>'.language('vote').'</span></span>',"class='button' onclick='\$j(\"#poll-form\").submit()'");?>
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