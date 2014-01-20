$j(document).ready(function(){
    $j("a[rel=facebox]").facebox();
    $j(".close-facebox").live('click',function(){
        $j(document).trigger('close.facebox');
    });
});
