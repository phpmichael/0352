<div id="booklet">
    <?foreach ($list as $key=>$record):?>
	<div> 
		<?=img(array('src'=>base_url().'images/data/b/photos/'.$record['file_name'],'width'=>800,'height'=>500))?>
	</div>
	<div> 
	    <?=img(array('src'=>base_url().'images/data/b/photos/'.$record['file_name'],'width'=>800,'height'=>500,'style'=>'margin-left:-400px;'))?>
	</div>
	<?endforeach?>
</div>

<?=load_inline_js('inc/js-jquery-ui')?>

<!-- booklet -->
<?=include_minified($BC->_getTheme().'js/booklet/jquery.easing.1.3.js','js')?>
<?=include_css($BC->_getTheme().'js/booklet/jquery.booklet.1.3.1.css')?>
<?=include_js($BC->_getTheme().'js/booklet/jquery.booklet.1.3.1.min.js')?>

<script>
$j(function() {
	$j('#booklet').booklet({
		width:800,
		height:500,
		pagePadding:0,
		speed:600,
		keyboard: true,
		arrows: true,
        arrowsHide: false,
        manual: true
		/*tabs:  true,
        tabWidth:  180,
        tabHeight:  20
		auto: true,
        delay: 2000,*/
	});
});
</script>