<?//always?>
<?if( !$this->session->userdata('customer_id') ):?>
    <?load_theme_view('inc/box-login')?>
<?endif?>

<?//recent articles: just for home page?>
<?if (($BC->is_home_page())):?>
    <?//load_theme_view('inc/box-recent-articles')?>
<?endif?>

<?//books categories: just for books section?>
<?if (($BC->is_home_page()) || in_array($BC->_getController(),array('books'))):?>
    <?load_theme_view('inc/box-products-manufacturers')?>
<?endif?>

<?//poll: not for some sections?>
<?if (!in_array($BC->_getController(),array('cart','wishlist','orders'))):?>
    <?//load_theme_view('inc/box-poll')?>
<?endif?>

<?//specials: for some sections?>
<?if (in_array($BC->_getController(),array('books','cart','orders','wishlist'))):?>
    <?//load_theme_view('inc/box-specials')?>
<?endif?>

<?//specials: for some sections?>
<?if (in_array($BC->_getController(),array('articles'))):?>
    <?load_theme_view('inc/box-tags-cloud');?>
<?endif?>

<?load_theme_view('inc/box-featured')?>

<?//partners: ?>
<?if (@$BC->settings_model['site_partners']):?>
    <?=$BC->settings_model['site_partners']?>
<?endif?>
