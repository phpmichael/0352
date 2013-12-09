<!--Load JS-->
<?php $this->load->view('inc/js-jquery-ui'); ?>

<?=include_css($BC->_getFolder('js').'fullcalendar/fullcalendar.css')?>
<?=include_css($BC->_getFolder('js').'fullcalendar/fullcalendar.print.css','print')?>
<?=include_js($BC->_getFolder('js').'fullcalendar/fullcalendar.min.js')?>

<style>
.fb-output-screen { 
	width:370px;
}
</style>
<?$this->load->view('inc/js-facebox'); ?>

<!--Load JS-->

<script>

	var curCalEvent = {};

	$j(document).ready(function() {
	
		$j('#agenda').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			
			firstDay: 1, //start week from Monday
			
			weekMode: 'liquid', //change default view of 6 row always
		
			editable: true,
			
			timeFormat: 'H(:mm)', // uppercase H for 24-hour clock
			
			//agenda options
			minTime: 8,
			maxTime: 23,
			
			//load events
			events: "<?=site_url($BC->_getBaseURI().'/get_events')?>",
			
			//move event
			eventDrop: function(event, dayDelta, minuteDelta, allDay) {
				$j.getJSON( "<?=site_url($BC->_getBaseURI().'/move_event')?>/"+event.id+'/'+dayDelta+'/'+minuteDelta+'/'+allDay, {}, function(response) 
				{
					if(response.status=='error')
					{
						alert(response.message);
						return false;
					}
				});
			},
			
			//extend event
			eventResize: function(event, dayDelta, minuteDelta) {
				$j.getJSON( "<?=site_url($BC->_getBaseURI().'/extend_event')?>/"+event.id+'/'+dayDelta+'/'+minuteDelta, {}, function(response) 
				{
					if(response.status=='error')
					{
						alert(response.message);
						return false;
					}
				});
			},
			
			/*loading: function(bool) {
				if (bool) $('#loading').show();
				else $('#loading').hide();
			}*/
			
			//edit event
			eventClick: function(calEvent) {
                window.curCalEvent = calEvent;
                
                $j.facebox( {ajax:"<?=site_url($BC->_getBaseURI().'/edit_event')?>/"+calEvent.id} );
            },
            
            //create event
            dayClick: function(date) {
            	window.curCalEvent = {};
            	
            	var date_string = $j.fullCalendar.formatDate( date, 'yyyy-MM-dd');
            	
            	$j.facebox( {ajax:"<?=site_url($BC->_getBaseURI().'/edit_event')?>/0/"+date_string} );
            }
			
		});
		
		//splash box for create/edit event
		$j("#facebox :input[type='submit']").live('click',function()
		{
			var form = $j("#facebox form");
			var form_action = $j(form).attr('action');
			var post = $j(form).serialize();
			
			//Send form						
			$j.post( form_action, post, function(response) 
			{
				if(response.status=='error')
				{
					alert(response.message);
					return false;
				}
				
				window.curCalEvent.title = $j(":input[name=title]", form).val();
				window.curCalEvent.allDay = $j(":input[name=allDay]", form).attr('checked')? true : false ;
				
				var start_date = $j(":input[name=start_date]", form).val();
				var start_time = $j(":input[name=start_time]", form).val();
				if(start_date=='') window.curCalEvent.start = '';
				else
				{
					var start_date_arr = start_date.split("/");
					var start_time_arr = start_time.split(":");
					if(!parseInt(start_time_arr[0])) start_time_arr[0] = 0;
					if(!parseInt(start_time_arr[1])) start_time_arr[1] = 0;
					window.curCalEvent.start = new Date(start_date_arr[2], start_date_arr[1]-1, start_date_arr[0], start_time_arr[0], start_time_arr[1]);
				}
				
				var end_date = $j(":input[name=end_date]", form).val();
				var end_time = $j(":input[name=end_time]", form).val();
				if(end_date=='') window.curCalEvent.end = '';
				else
				{
					var end_date_arr = end_date.split("/");
					var end_time_arr = end_time.split(":");
					if(!parseInt(end_time_arr[0])) end_time_arr[0] = 0;
					if(!parseInt(end_time_arr[1])) end_time_arr[1] = 0;
					window.curCalEvent.end = new Date(end_date_arr[2], end_date_arr[1]-1, end_date_arr[0], end_time_arr[0], end_time_arr[1]);
				}
				
				if(typeof(window.curCalEvent.id)=='undefined') 
				{
					window.curCalEvent.id = response.id;
					
					$j('#agenda').fullCalendar('renderEvent', window.curCalEvent, true );
				}
				else 
				{
					$j('#agenda').fullCalendar('updateEvent', window.curCalEvent);
				}
				
				$j(document).trigger('close.facebox');
				
			},'json');
			
			return false;	
		});
		
		//delete event
		$j("#facebox :input[type='button']").live('click',function()
		{
		    if(typeof(window.curCalEvent.id)!='undefined') 
		    {
		        if(confirm('<?=language('are_you_sure')?>'))
		        {
    		        $j.getJSON("<?=site_url($BC->_getBaseURI().'/delete_event')?>/"+window.curCalEvent.id,{},function(response){
    		            
    		            if(response.status=='error')
        				{
        					alert(response.message);
        					return false;
        				}
        				
        				$j('#agenda').fullCalendar('refetchEvents');
        				
        				$j(document).trigger('close.facebox');
    		        });
		        }
		    }
		});
		
	});

</script>

<div id="agenda"></div>