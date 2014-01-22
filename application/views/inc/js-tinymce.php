<?=include_js($BC->_getFolder('js').'tiny_mce/jquery.tinymce.js')?>
<script>

function init_richtext()
{
	$j(".richtext").tinymce({
        script_url : '<?=base_url().$BC->_getFolder('js')?>tiny_mce/tiny_mce.js',
        // General options
        theme : "advanced",
        plugins : "more,advhr,advimage,advlink,iespell,media,contextmenu,paste,fullscreen,visualchars,xhtmlxtras,template,advlist,images",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "link,unlink,image,images,|,pastetext,pasteword,|,outdent,indent,blockquote,|,forecolor,|,more,charmap,iespell,media,advhr,|,undo,redo,|,code,cleanup,fullscreen,help,",
        theme_advanced_buttons3 : "",
        theme_advanced_buttons4 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : false,

        //Path
        relative_urls : true,
        remove_script_host : true
	});
}

$j(document).ready(function(){
	init_richtext();
});

</script>