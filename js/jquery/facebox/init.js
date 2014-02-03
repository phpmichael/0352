$j(document).ready(function(){
    $j("a[rel=facebox]").facebox();
    $j(document.body).on('click', ".close-facebox", function(){
        $j(document).trigger('close.facebox');
    });
});
