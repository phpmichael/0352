<div>
    <div id="slider-container">
        <div id="slider">
            <?
                load_model('slideshow_model');
                $slides = $BC->zen->slideshow_model->getAll();
            ?>

            <?foreach ($slides as $slide):?>
            <div>
                <a href="<?=$slide['link']?>" title="<?=htmlspecialchars($slide['title'])?>">
                    <?=img(array('src'=>'images/data/m/slideshow/'.$slide['image'], 'alt'=>htmlspecialchars($slide['title']), 'width'=>'852', 'height'=>'296'))?>
                </a>
            </div>
            <?endforeach?>
        </div>

        <div class="slider-arrow-left"></div>
        <div class="slider-arrow-right"></div>
    </div>

    <div class="clearfix"></div>

    <?if(trim($body)):?>
    <div class="full-box">
        <?=$body?>
    </div>
    <?endif?>
    
    <h2><?=language('novelty')?></h2>

    <div>
        <?
            load_model('books_model');
            $recent_books = $BC->zen->books_model->getFeatured(15);
        ?>
    	<?load_theme_view('inc/tpl-books-grid',$recent_books);?>
    </div>
    
</div>