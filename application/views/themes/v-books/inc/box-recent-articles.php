<?
$articles_model = load_model('articles_model');
$recent_articles = $articles_model->getRecent(3);
?>

<h3><?=language('recent_articles')?></h3>

<div class="well">
    <?if(!empty($recent_articles['posts_list'])):?>
	<ul class="nav nav-list">
		<?foreach ($recent_articles['posts_list'] as $article):?>
		<li>
			<?=anchor_base('article/'.$article->slug,$article->head)?>
		</li>
		<li>
			<small><?=date('d/m/Y H:i',strtotime($article->pub_date))?></small>
		</li>
		<li class="divider"></li>
		<?endforeach?>
	</ul>
   <?endif?>

</div>