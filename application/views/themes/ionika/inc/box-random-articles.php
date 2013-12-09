<div class="module">
    <h3><span><span><?=language('articles')?></span></span></h3>

    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <?$articles_model = load_model('articles_model'); $random_articles = $articles_model->getRandom(3)?>
                <ul>
	                <?foreach ($random_articles as $article):?>
	                <li><?=anchor_base('article/'.$article['slug'],$article['head'])?></li>
	                <?endforeach?>
                </ul>
            </div>
        </div>
    </div>
</div>