<script>
    $j(document).ready(function() {
        $j('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            firstDay: 1, //start week from Monday
            weekMode: 'liquid', //change default view of 6 row always
            timeFormat: 'H:mm', // uppercase H for 24-hour clock
            axisFormat: 'H:mm', // for agenda view (left)
            events: "<?=site_url($BC->_getBaseURI().'/calendar')?>",//load events
            eventClick: function(calEvent) {
                location.href = "<?=site_url($BC->_getBaseURI().'/edit/id/desc/0/')?>/"+calEvent.id ;
            }
        });
    });
</script>