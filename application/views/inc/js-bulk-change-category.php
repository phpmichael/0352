<script>
    $j(document).ready(function(){
        $j("#bulk_change_category").click(function(){
            var category_id = parseInt( $j('select[name=category_id]').val() );//get category from search form
            if(category_id) //check if category selected
            {
                $j('input[name=new_category_id]').val( category_id );
                $j('form[name=form]').attr('action','<?=aurl('bulk_change_category')?>').submit();
            }
            else alert("<?=language('choose_category')?>");
        });
    });
</script>