<?if( 
	( (!isset($comments_opened) || $comments_opened=='default') && isCommentsAllowed($table) )
	||
	( isset($comments_opened) && $comments_opened=='yes' )
):?>

    <div id="commentsbox">
    
        <?show_add_comment_link()?>
        
        <?show_comment_form($table,$post_id);?>
        
        <?if($comments = get_comments($table,$post_id)):?>
        
        	<h3 id="comments"><?=comments_number($table,$post_id);?></h3>
        
        	<?show_comments($this,$comments);?>
        	
        <?endif?>
    
    </div>
    
    <script>
    var success_message = "<?=language('comment_added')?>";
    </script>

<?endif?>