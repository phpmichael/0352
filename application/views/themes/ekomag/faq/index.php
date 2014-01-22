
    <h2><?=$BC->_getPageTitle()?></h2>

    <div class="boxIndent" id="faq">
        <?if(!empty($faq_records)):?>

            <?foreach ($faq_records as $record):?>
            	<h3><a href='javascript:void(0)'> + <?=$record['question']?></a></h3>
            	
            	<p style="display:none;">
            		<?=nl2br($record['answer'])?>
            	</p>
            <?endforeach;?>
            
            <?if($paginate):?>
            <div class="pagination"><p><?=language('page')?>: </p><?=$paginate?></div>
            <?endif?>
        
        <?endif;?>
        
        <br class="clear" />
    </div>
    
    <script>

    $j(document).ready(function(){
        //show/hide answer for FAQ
    	$j("#faq h3 a").click(function(){
    		$j(this).parent().next().toggle();
    	});
    });

    </script>