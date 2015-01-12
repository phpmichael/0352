<?load_theme_view('inc/box-products-categories')?>

<div class="sidebar-box">
    <a class="btn btn-primary" href="#">ОНЛАЙН ТЕСТИ ЗНО<i class="icon-chevron-right icon-white"></i></a>
</div>

<?//recent articles: just for home page?>
<?if (($BC->is_home_page())):?>
    <?load_theme_view('inc/box-recent-articles')?>
<?endif?>

<h2><?=language('follow_us')?></h2>
<div class="row-fluid">
    <a class="social-icon social-google" href="#"></a>
    <a class="social-icon social-twitter" href="#"></a>
    <a class="social-icon social-vkontakte" href="#"></a>
    <a class="social-icon social-odnoklasniki" href="#"></a>
</div>
