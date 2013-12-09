<h1><?=$BC->_getPageTitle()?></h1>

<div id="find-food">
	<?fb_form("find_food",FALSE)?>
</div>

<div>
    
    <?if( $posts_list ):?>
    
    	<div class="toolbar-top"></div>
	    <br class="clear" />
    
	    <div>
			<?$i=0; foreach ($posts_list as $post): $i++; ?>
			<div>
				
				<p>
					<img src="<?=base_url()?>images/data/s/food/<?=$post->photo1?>" alt="" />
				</p>
				
				<p>
					<?=fb_input_label("price","food")?>: <?=$post->price?>
				</p>
				
				<p>
					<?=fb_input_label("place","food")?>: <br /> <?=nl2br($post->place)?>
				</p>
				
				<p>
					<?=fb_input_label("business_lunch","food")?>: <?=($post->business_lunch?language('yes'):language('no'))?>
				</p>
				
				<p>
					<?=fb_input_label("possible_activities","food")?>: <?=fb_answers($post->possible_activities)?>
				</p>

				<p>
					<a href="<?=site_url('food/view/'.$post->data_key)?>">Детальніше</a>
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