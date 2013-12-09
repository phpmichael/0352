<h1><?=$BC->_getPageTitle()?></h1>

<div id="find-carriers">
	<?fb_form("find_carrier",FALSE)?>
</div>

<div>
    
    <?if( $posts_list ):?>
    
    	<div class="toolbar-top"></div>
	    <br class="clear" />
    
	    <div>
			<?$i=0; foreach ($posts_list as $post): $i++; ?>
			<div>
				
				<p>
					<img src="<?=base_url()?>images/data/s/carriers/<?=$post->photo1?>" alt="" />
				</p>
				
				<p>
					<?=fb_input_label("route_name","carriers")?>: <?=$post->route_name?>
				</p>
				
				<p>
					<?=fb_input_label("ownership_of_carrier","carriers")?>: <?=$post->ownership_of_carrier?>
				</p>
				
				<p>
					<?=fb_input_label("vehicle_model","carriers")?>: <?=$post->vehicle_model?>
				</p>
				
				<p>
					<?=fb_input_label("price","carriers")?>: <?=$post->price?>
				</p>
				
				<p>
					<?=fb_input_label("presence_of_folding_seats","carriers")?>: <?=$post->presence_of_folding_seats?>
				</p>
				
				<p>
					<?=fb_input_label("ability_to_view_video","carriers")?>: <?=fb_answers($post->ability_to_view_video,$format=",","ability_to_view_video","carriers")?>
				</p>

				<p>
					<a href="<?=site_url('carriers/view/'.$post->data_key)?>">Детальніше</a>
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