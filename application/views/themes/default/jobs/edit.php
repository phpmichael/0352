<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<?load_theme_view('inc/form-job')?>

<?=load_inline_js('inc/js-selectboxes')?>

<?=load_inline_js('inc/js-load-category',array('parent_category'=>0))?>

<?=load_inline_js('inc/js-meio-mask')?>
<?=load_inline_js('inc/js-init-mask')?>

<script>
$j(document).ready(function(){
	<?if(!isset($post_categories)):?>
	load_category(0,false);
	<?endif?>
});
</script>