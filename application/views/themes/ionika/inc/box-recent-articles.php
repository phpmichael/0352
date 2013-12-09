<?
$articles_model = load_model('articles_model');
$recent_articles = $articles_model->getRecent(3);
?>

<div class="module">
    <h3><span><span><?=language('recent_articles')?></span></span></h3>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <?if(!empty($recent_articles['posts_list'])):?>
				<div class="item-list">
					<ul>
						<?foreach ($recent_articles['posts_list'] as $article):?>
						<li>
							<div>
								<?=anchor_base('article/'.$article->slug,$article->head)?>
							</div>
							<div>
								<small><?=date('d/m/Y H:i',strtotime($article->pub_date))?></small>
							</div>
						</li>
						<?endforeach?>
					</ul>
				</div>
			   <?endif?>
            </div>
        </div>
    </div>
</div>