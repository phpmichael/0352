<?
load_model('articles_model');
$recent_articles = $BC->zen->articles_model->getRecent(3);
?>

<?if(!empty($recent_articles['posts_list'])):?>
<h3><?=language('recent_articles')?></h3>

<div class="well">

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

</div>
<?endif?>