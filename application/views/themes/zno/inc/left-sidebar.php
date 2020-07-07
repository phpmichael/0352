<?load_theme_view('inc/box-products-categories')?>

<?//publishers and authors: home page and books controller?>
<?if ($BC->is_home_page() || in_array($BC->_getController(),array('books'))):?>
    <?load_theme_view('inc/box-books-authors')?>
    <?load_theme_view('inc/box-products-manufacturers')?>
<?endif?>

<?//recent articles: just for home page?>
<?if (($BC->is_home_page())):?>
    <?load_theme_view('inc/box-recent-articles')?>
<?endif?>