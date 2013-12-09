    <h2><?=$BC->_getPageTitle()?></h2>

    <div class="boxIndent">           
		<div><?=nl2br($video['description'])?></div>
		
		<p><?social_buttons()?></p>
		
		<div>
			<?=show_embed_video($video);?>
		</div>
    </div>