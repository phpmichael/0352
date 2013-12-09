<?
if( @$search_category_title ):

	$articles_categories_model = load_model('articles_categories_model');
	$article_category_id = $articles_categories_model->getIdByTitle($search_category_title);

	if($article_category_id):

	$articles_model = load_model('articles_model');
	$articles = $articles_model->getRandomOfCategory(3,$article_category_id);
	
		if($articles['total_rows']>0):?>
		
			<h2><?=language('articles')?></h2>
			
			<div class="boxIndent list">  
			    <ul>
				    <?foreach ($articles['posts_list'] as $article):?>
				    <li><?=anchor_base('/articles/name/'.$article->slug,$article->head)?></li>
				    <?endforeach?>
			    </ul>
			</div>
			
		<?endif?>
	<?endif?>
<?endif?>