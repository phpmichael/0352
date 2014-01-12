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
            if ( !($slides = $BC->cache->get('slides')) )
            {
                $slideshow = load_model('slideshow_model');
                $slides = $slideshow->getAll();

                $BC->cache->save('slides', $slides, 5*60);
            }
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
        if ( !($recent_books = $BC->cache->get('recent_books')) )
        {
            $books_model = load_model('books_model');
            $recent_books = $books_model->getRecent(6);

            $BC->cache->save('recent_books', $recent_books, 5*60);
        }
        ?>
    	<?load_theme_view('inc/tpl-books-grid',$recent_books);?>
    </div>
    
</div>

<?$this->load->view('inc/js-add-to-cart'); ?>