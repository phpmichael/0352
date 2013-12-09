<div id="right">
    <div class="wrapper">
        <div class="extra-indent">
  
            <?//always?>
            <?if( $this->session->userdata('customer_id') ):?>
                <?//if customer logged - customer menu?>
				<?load_theme_view('inc/customer-menu')?>
			<?else:?>
			    <?//if customer not logged - login box?>
				<?load_theme_view('inc/box-login')?>
			<?endif?>
			
			<?//products categories: just for products section?>
            <?if (($BC->is_home_page()) || in_array($BC->_getController(),array('products'))):?>
                <?load_theme_view('inc/box-products-categories')?>
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
                <?load_theme_view('inc/box-tags-cloud');?>
            <?endif?>
            
            <?//testimonials: not for some sections?>
            <?if (!in_array($BC->_getController(),array('testimonials','cart','articles','wishlist','orders')) && !in_array($BC->_getMethod(),array('register')) ):?>
                <?load_theme_view('inc/box-random-testimonial')?>
            <?endif?>
            
        </div>
    </div>
</div>