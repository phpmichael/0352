<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<?load_theme_view('inc/form-poster')?>

<?$this->load->view('inc/js-selectboxes')?>

<?$this->load->view('inc/js-load-category',array('parent_category'=>0))?>

<?$this->load->view('inc/js-meio-mask')?>
<?$this->load->view('inc/js-init-mask')?>

<script type="text/javascript">

$j(document).ready(function(){
	
	<?if(!isset($post_categories)):?>
	load_category(0,false);
	<?endif?>
	
});

</script>