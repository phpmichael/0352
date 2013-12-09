<h2><?=$BC->_getPageTitle()?></h2>

<div>
    <?if(!empty($testimonials_records)):?>

        <?foreach ($testimonials_records as $record):?>
        	<h3><?=$record['name']?>:</h3>
        	
        	<p>
        		<?=nl2br($record['content'])?>
        	</p>
        	<br />
        <?endforeach;?>
        
        <?if($paginate):?>
        <div class="pagination"><p><?=language('page')?>: </p><?=$paginate?></div>
        <?endif?>
    
    <?endif;?>
</div>