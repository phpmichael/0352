<h2><?=language('shopping_cart')?></h2>
<?load_theme_view('inc/box-short-cart')?>

<?//always?>
<?if( $this->session->userdata('customer_id') ):?>
    <?//if customer logged - customer menu?>
	<?load_theme_view('inc/customer-menu')?>
<?else:?>
    <?//if customer not logged - login box?>
	<?load_theme_view('inc/box-login')?>
<?endif?>

<?//articles categories: just for articles section?>
<?if (in_array($BC->_getController(),array('articles'))):?>
    <?load_theme_view('inc/box-articles-categories')?>
<?endif?>

<?//poll: not for some sections?>
<?if (!in_array($BC->_getController(),array('cart','wishlist','orders'))):?>
    <?load_theme_view('inc/box-poll')?>
<?endif?>

<?//random articles with category the same as product category: just for products section?>
<?if (in_array($BC->_getController(),array('products'))):?>
    <?load_theme_view('inc/box-random-articles')?>
<?endif?>

<?//videos: not for some sections?>
<?if (!in_array($BC->_getController(),array('videos','cart','wishlist','orders','products')) && !in_array($BC->_getMethod(),array('register')) ):?>
    <?load_theme_view('inc/box-random-videos')?>
<?endif?>

<?//testimonials: not for some sections?>
<?if (!in_array($BC->_getController(),array('testimonials','cart','articles','wishlist','orders')) && !in_array($BC->_getMethod(),array('register')) ):?>
    <?load_theme_view('inc/box-random-testimonial')?>
<?endif?>

<?if ($BC->is_home_page()):?>
    <h2><?=language('partners')?></h2>
    <div align="center"><?=@$BC->settings_model['site_partners']?></div>
<?endif?>

<?if(@$BC->settings_model['use_orphus']):?>
<div align="center">
	<br />
	<script type="text/javascript" src="/orphus/orphus.js"></script>
	<a href="http://orphus.ru" id="orphus" target="_blank"><img alt="Orphus" src="/orphus/orphus.gif" border="0" width="160" height="122" /></a>
</div> 
<?endif?>

