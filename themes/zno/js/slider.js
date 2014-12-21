$j(document).ready(function() {
    $j('#slider').cycle({
        fx: 'fade',
        prev: $j('.slider-arrow-left'),
        next: $j('.slider-arrow-right'),
        pager: '#slider-nav' ,
        activePagerClass: 'active-slide',
        pagerAnchorBuilder: function(idx, slide) {
            page_id = parseInt(idx)+1;
            return '<div class="pager-item pager-num-'+page_id+'"><a href="#"></a></div>';
        }
    });
});