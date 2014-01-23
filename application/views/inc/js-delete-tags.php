<script>
    $j(document).ready(function(){
        $j(".del_tag").click(function(){
            var tag_id = $j(this).attr('tag_id');
            var url = "<?=relative_url().$BC->_getFolder()."tags/delete/"?>"+tag_id;

            $j("#tag-"+tag_id).remove();
            $j(this).remove();

            $j.post(url,function(){});
        });
    });
</script>