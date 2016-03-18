<?load_theme_view('inc/box-products-categories')?>

<?//recent articles: just for home page?>
<?if (($BC->is_home_page())):?>
    <?load_theme_view('inc/box-recent-articles')?>
<?endif?>



<?if (($BC->is_home_page())):?>
    <h2>Графік ЗНО-2015</h2>
    <?=img(array('src'=>'store/zno-agenda-2015.png', 'height'=>'379', 'width'=>'196', 'alt'=>'Графік ЗНО-2015'))?>
<?endif?>