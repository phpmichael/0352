<?$BC->load->helper('blog');?>

<div id="categories-tree">
    <?=get_categories_tree('articles',0,0,array('root_id'=>'articles-categories'));?>
</div>

<?=include_js($BC->_getFolder('js').'jquery/jquery.cookie.js')?>
<?=include_js($BC->_getFolder('js').'jquery/jquery.hotkeys.js')?>
<?=include_js($BC->_getFolder('js').'jquery/jstree/jquery.jstree.js')?>

<script type="text/javascript">
$j(function () {
	$j("#categories-tree").jstree({ 
	    "themes" : {
            "theme" : "classic"
            //"dots" : false,
            //"icons" : false
        },
		"plugins" : [ "themes", "html_data" ]
	});
});
</script>