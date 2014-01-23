<?$pages['top_news'] = $BC->pages_model->getByLink('top-news');?>

<?$books_model = load_model('books_model');?>

<div>

    <h2><?=language('most_popular')?></h2>

    <div class="well">
		<?load_theme_view('inc/tpl-books-grid',$books_model->getMostPopular(3));?>
    </div>
    
    <h2><?=language('novelty')?></h2>

    <div class="well">
    	<?load_theme_view('inc/tpl-books-grid',$books_model->getRecent(3));?>
    </div>
    
    <h2><?=language('featured')?></h2>

    <div class="well">
    	<?load_theme_view('inc/tpl-books-grid',$books_model->getFeatured(3));?>
    </div>
    
    <?if(trim($body)):?>
    <h2><?=language('about_us')?></h2>
    
    <div class="well">
         <?=$body?>
    </div>
    <?endif?>
</div>

<?=load_inline_js('inc/js-add-to-cart'); ?>