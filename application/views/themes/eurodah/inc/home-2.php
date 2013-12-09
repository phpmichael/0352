<aside id="sidebar-first">
    <div class="section">
        <div class="region region-sidebar-first">
			<section class="block">
			    <?$poll_data = poll_data();?>

                <?if($poll_data):?>
                    <h2><?=language('community_poll')?></h2>
                
                    <div class="content">
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
                    </div><!-- /.content -->
                <?endif?>
				<!-- /.block -->
			</section>
			
			<section class="block">
				<h2>Партнери</h2>
				
				<div id="partner-slider">
				    <?
                    $partner_slider_model = load_model('partner_slider_model');
                    $partner_sliders = $partner_slider_model->getAll();
                    ?>
				    <?foreach ($partner_sliders as $partner_slider):?>
				    <img src="<?=base_url()?>images/data/s/partner_slider/<?=$partner_slider['logo']?>" width="200" height="150" alt="<?=$partner_slider['name']?>" />
				    <?endforeach?>
				</div>
                    
				<div class="content">
					<?=$BC->settings_model['site_partners']?>
				</div><!-- /.content -->
				<!-- /.block -->
			</section>
        </div>
    </div><!-- /.section -->
</aside><!-- /#sidebar-first -->

<?
$articles_model = load_model('articles_model');
$recent_articles = $articles_model->getRecent(3);
?>

<aside id="sidebar-second">
    <div class="section">
        <div class="region region-sidebar-second">
		
			<section id="block-views-latest-news-block" class="block">
				<h2>Нові статті</h2>

				<div class="content">

				   <?if(!empty($recent_articles['posts_list'])):?>
					<div class="item-list">
						<ul>
							<?foreach ($recent_articles['posts_list'] as $article):?>
							<li>
								<div class="views-field-created">
									<span><?=date('d m',strtotime($article->pub_date))?></span>
								</div>

								<div class="views-field-title">
									<?=anchor_base('articles/name/'.$article->slug,$article->head)?>
								</div>
							</li>
							<?endforeach?>
						</ul>
					</div>
				   <?endif?>
				</div><!-- /.content -->
			</section>
            <!-- /.block -->

			<section id="block-simplenews-11" class="block">
				<h2>Розсилка</h2>

				<div class="content">
					<form method="post" id="subscribe_form" action="#">
						<div>
							<div class="form-item form-type-textfield form-item-mail">
								<label>Email <span class="form-required" title="This field is required.">*</span></label> 
								<input id="subscribe_email" name="email" value="" size="20" maxlength="128" class="form-text required" type="text" />
							</div>
							<input id="subscribe" name="op" value="" class="form-submit" type="submit" />
						</div>
					</form>
				</div><!-- /.content -->
            </section><!-- /.block -->
            
            <div id="subscribe_results"></div>
            
            <?=include_js($BC->_getFolder('js').'custom/subscribe/subscribe.js')?>
        </div>
    </div><!-- /.section -->
</aside><!-- /#sidebar-second -->