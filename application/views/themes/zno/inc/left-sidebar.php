<?load_theme_view('inc/box-products-categories')?>

<?//recent articles: just for home page?>
<?if (($BC->is_home_page())):?>
    <?load_theme_view('inc/box-recent-articles')?>
<?endif?>



<?if (($BC->is_home_page())):?>
    <h2>Програми ЗНО-2017 </h2>
    <ul>
        <li><a href="<?=site_url('documents/search/category/6')?>">Українська мова і література</a></li>
        <li><a href="<?=site_url('documents/search/category/4')?>">Історія України</a></li>
        <li><a href="<?=site_url('documents/search/category/5')?>">Математика</a></li>
        <li><a href="<?=site_url('documents/search/category/8')?>">Фізика</a></li>
        <li><a href="<?=site_url('documents/search/category/9')?>">Хімія</a></li>
        <li><a href="<?=site_url('documents/search/category/2')?>">Біологія</a></li>
        <li><a href="<?=site_url('documents/search/category/3')?>">Географія</a></li>
        <li><a href="<?=site_url('documents/search/category/1')?>">Англійська мова</a></li>
        <li><a href="#">Французька мова</a></li>
        <li><a href="<?=site_url('documents/search/category/7')?>">Німецька мова</a></li>
        <li><a href="#">Іспанська мова</a></li>
        <li><a href="#">Російська мова</a></li>
    </ul>
<?endif?>