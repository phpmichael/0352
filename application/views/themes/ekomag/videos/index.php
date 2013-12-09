
    <h2><?=$BC->_getPageTitle()?></h2>

    <div class="boxIndent">
        <?if(!empty($videos_records)):?>

            <?foreach ($videos_records as $record):?>
            	<h3><?=anchor_base('videos/view/'.$record['data_key'],$record['title'])?></h3>
            	<?=nl2br($record['description'])?>
            <?endforeach;?>
            
            <?if($paginate):?>
            <div class="pagination"><p><?=language('page')?>: </p><?=$paginate?></div>
            <?endif?>
        
        <?endif;?>
        
        <br class="clear" />
    </div>