<div id="page">
    <h2 class="title"><span><span><?=$BC->_getPageTitle()?></span></span></h2>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
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
                
                <br class="clear" />
            </div>
        </div>
    </div>
</div>