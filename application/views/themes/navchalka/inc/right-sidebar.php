<?//always?>
<?if( !$this->session->userdata('customer_id') ):?>
    <?load_theme_view('inc/box-login')?>
<?endif?>

<?if (!($BC->is_home_page())):?>
    <?load_theme_view('inc/box-featured')?>
<?endif?>

<?//recent articles: just for home page?>
<?if (($BC->is_home_page())):?>
    <?load_theme_view('inc/box-recent-articles')?>
<?endif?>

<?//specials: for some sections?>
<?if (in_array($BC->_getController(),array('articles'))):?>
    <?load_theme_view('inc/box-tags-cloud');?>
<?endif?>

<?//books categories: just for books section?>
<?if (($BC->is_home_page()) || in_array($BC->_getController(),array('books'))):?>
    <?load_theme_view('inc/box-products-manufacturers')?>
<?endif?>

<?//partners: ?>
<?if (@$BC->settings_model['site_partners']):?>
    <?=$BC->settings_model['site_partners']?>
<?endif?>
