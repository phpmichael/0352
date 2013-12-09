<h1><?=$BC->_getPageTitle()?></h1>

<div id="find-instructor">
	<?fb_form("find_instructor",FALSE)?>
</div>

<div>
    
    <?if( $posts_list ):?>
    
    	<div class="toolbar-top"></div>
	    <br class="clear" />
    
	    <div>
			<?$i=0; foreach ($posts_list as $post): $i++; ?>
			<div>
				
				<p>
					<img src="<?=base_url()?>images/data/s/instructors/<?=$post->photo1?>" alt="" />
				</p>
				
				<p>
					<?=$post->customer_name?> <?=$post->customer_surname?>
				</p>
				
				<p>
					<?=fb_input_label("instructor_on","instructors")?>: <?=fb_answers($post->instructor_on)?>
				</p>
				
				<p>
					<?=fb_input_label("experience_skiing","instructors")?>: <?=fb_answers($post->experience_skiing,",","experience_skiing","instructors")?>
				</p>
				
				<p>
					<?=fb_input_label("experience_instructor","instructors")?>: <?=fb_answers($post->experience_instructor,",","experience_instructor","instructors")?>
				</p>
				
				<p>
					<?=fb_input_label("fluency_in_languages","instructors")?>: <?=fb_answers($post->fluency_in_languages)?>
				</p>

				<p>
					<a href="<?=site_url('instructors/view_profile/'.$post->data_key)?>">Детальніше</a>
				</p>
			</div>
			<?endforeach?>
			
		</div>
        
        <div class="pagination"><?=$paginate?></div>
        
        <br class="clear" />
        <div class="toolbar-top"></div>
    
    <?else:?>
        <h2><?=language('search_did_not_give_any_results')?></h2>
    <?endif?>
</div>