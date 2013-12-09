<h2><?=$BC->_getPageTitle()?></h2>

<div>
	<form method="post" action="<?=site_url($BC->_getBaseURI())?>">
		<input type="search" name="keywords" value="<?=trim(urldecode(@$keywords))?>" />
	</form>
</div>
<br class="clear" />
<?if(@trim(urldecode($keywords))):?>
<div class="search-results-for">
    <h4><?=language('search_results_for')?>: " <i><?=trim(urldecode($keywords))?></i> "</h4>
</div>
<?elseif(@trim(urldecode($tag))):?>
<div class="search-results-for">
    <h4><?=language('articles_with_tag')?>: " <i><?=trim(urldecode($tag))?></i> "</h4>
</div>
<?endif?>

<div>
    <?if(!empty($posts_list)):?>
		<?foreach ($posts_list as $key=>$record):?>
			<h2><?=anchor_base('articles/name/'.$record->slug,$record->head)?></h2>
			
			<div class='fl'><i><?=date('d/m/Y H:i',strtotime($record->pub_date))?></i></div>
			<div class='fr'><i><?=comments_number('articles',$record->id)?></i></div>
			
			<div class='clear article-content'>
				<?=word_limiter_more($record->body,80)?>
				<?=anchor_base('articles/name/'.$record->slug,language('read_more'))?>
			</div>
		    
		    <?=load_theme_view('inc/box-post-tags',array('post_id'=>$record->id),TRUE)?>
		<?endforeach?>
	<?else:?>
	   <h2><?=language('search_did_not_give_any_results')?></h2>
	<?endif?>
</div>

<?if($paginate):?>
<div class="pagination"><p><?=language('page')?>: </p><?=$paginate?></div>
<?endif?>
		