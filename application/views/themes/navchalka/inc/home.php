<div>
    <div class="search-box">
        <?=form_open($BC->_getBaseURL()."books/search")?>
            <?=form_input("keywords",trim(urldecode(@$keywords)))?>
            <input type="submit" value="<?=language('search')?>" />
        </form>
        <div class="search-example">
            <?if($BC->config->item('language')=='ukrainian'):?>
                Наприклад: <span>алгебра</span>,  <span>атлас</span> і т.п.
            <?else:?>
                Например: <span>алгебра</span>,  <span>атлас</span>
            <?endif?>
        </div>
    </div>

    <div id="slider-container">
        <div id="slider">
            <?
                load_model('slideshow_model');
                $slides = $BC->zen->slideshow_model->getAll();
            ?>

            <?foreach ($slides as $slide):?>
            <div>
                <a href="<?=$slide['link']?>" title="<?=htmlspecialchars($slide['title'])?>">
                    <?=img(array('src'=>'images/data/m/slideshow/'.$slide['image'], 'alt'=>htmlspecialchars($slide['title']), 'width'=>'579', 'height'=>'194'))?>
                </a>
            </div>
            <?endforeach?>
        </div>

        <div class="slider-arrow-left"></div>
        <div class="slider-arrow-right"></div>

        <div id="slider-nav"></div>
    </div>

    <div class="clearfix"></div>
    
    <h2><?=language('novelty')?></h2>

    <div>
        <?
            load_model('books_model');
            $recent_books = $BC->zen->books_model->getRecent(6);
        ?>
    	<?load_theme_view('inc/tpl-books-grid',$recent_books);?>
    </div>

    <h2><?=language('featured')?></h2>

    <div>
        <?
            load_model('books_model');
            $featured_books = $BC->zen->books_model->getFeatured(2);
        ?>
        <?load_theme_view('inc/tpl-books-grid',$featured_books);?>
    </div>
    
</div>

<?=load_inline_js('inc/js-add-to-cart'); ?>