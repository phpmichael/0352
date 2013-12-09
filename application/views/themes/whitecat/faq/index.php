<div id="page">
    <h2 class="title"><span><span><?=$BC->_getPageTitle()?></span></span></h2>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <?if(!empty($faq_records)):?>

                    <?foreach ($faq_records as $record):?>
                    	<h3><?=$record['question']?></h3>
                    	
                    	<p>
                    		<?=nl2br($record['answer'])?>
                    	</p>
                    	<br />
                    <?endforeach;?>
                    
                    <?if($paginate):?>
                    <div class="pagination"><p><?=language('page')?>: </p><?=$paginate?></div>
                    <?endif?>
                
                <?endif;?>
                
                <br class="clear" />
            </div>
        </div>
    </div>
</div>