<?
load_model('articles_model');
$recent_articles = $BC->zen->articles_model->getRecent(3);
?>

<?if(!empty($recent_articles['posts_list'])):?>
    <h2><?=language('news')?></h2>

    <ul class="nav nav-list news-list">
    <?foreach ($recent_articles['posts_list'] as $article):?>
        <li>
            <small><?=date('d/m/Y H:i',strtotime($article->pub_date))?></small>
        </li>
        <li>
            <?=anchor_base('article/'.$article->slug,$article->head)?>
        </li>
    <li class="divider"></li>
    <?endforeach?>
    </ul>
<?endif?>