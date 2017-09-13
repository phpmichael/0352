<div id="right">
    <div class="wrapper">
        <div class="extra-indent">
			
			<?if (!in_array($BC->_getController(),array('articles','cart'))):?>
        		<?load_theme_view('inc/box-short-cart')?>
        	<?endif?>
			
			<?//recent articles: just for home page?>
            <?if (($BC->is_home_page())):?>
                <?load_theme_view('inc/box-recent-articles')?>
            <?endif?>
        
        	<?//products categories: just for products section?>
            <?if (($BC->is_home_page()) || in_array($BC->_getController(),array('products'))):?>
                <?load_theme_view('inc/box-products-categories')?>
                <?load_theme_view('inc/box-products-manufacturers')?>
            <?endif?>
            
            <?//articles categories: just for articles section?>
            <?if (in_array($BC->_getController(),array('articles'))):?>
                <?load_theme_view('inc/box-articles-categories')?>
            <?endif?>
            
            <?//poll: not for some sections?>
			<?if (!in_array($BC->_getController(),array('cart','wishlist','orders'))):?>
                <?load_theme_view('inc/box-poll')?>
            <?endif?>
            
            <?//specials: for some sections?>
            <?if (in_array($BC->_getController(),array('products','cart','orders','wishlist'))):?>
                <?load_theme_view('inc/box-specials')?>
            <?endif?>
            
            <?//specials: for some sections?>
            <?if (in_array($BC->_getController(),array('products','articles'))):?>
                <?//load_theme_view('inc/box-tags-cloud');?>
            <?endif?>
            
            <?//testimonials: not for some sections?>
            <?if (!in_array($BC->_getController(),array('testimonials','cart','articles','wishlist','orders')) && !in_array($BC->_getMethod(),array('register')) ):?>
                <?load_theme_view('inc/box-random-testimonial')?>
            <?endif?>
            
            <?if (!in_array($BC->_getController(),array('cart','wishlist','orders'))):?>
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s); js.id = id;
                  js.src = "//connect.facebook.net/uk_UA/all.js#xfbml=1";
                  fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>
                
                <div class="fb-like-box" data-href="http://facebook.com/ionikator" data-width="220" data-height="300" data-show-faces="true" data-stream="true" data-header="true"></div>
            <?endif?>
            
        </div>
    </div>
</div>