<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for agenda.
 * 
 * @package agenda  
 * @author Michael Kovalskiy
 * @version 2013
 * @access public
 */
class Agenda_model extends Base_model
{
	//name of table
	protected $c_table = 'agenda';
	//name of primary field
	protected $id_column = 'data_key';
	
	/**
	 * Return user's events.
	 *
	 * @param timestamp $start
	 * @param timestamp $end
	 * @return array
	 */
    public function getEvents($start,$end)
    {
        $start_date = date('Y-m-d',$start);
        $end_date = date('Y-m-d',$end);
        
        $customer_id = $this->CI->session->userdata('customer_id'); 
        
    	$events = $this->get(" customer_id = {$customer_id} AND start_date BETWEEN '{$start_date}' AND '{$end_date}'",'start_date, start_time');
        
        foreach ($events as &$event)
        {
            //set event start
        	if( $event['start_date'] == '0000-00-00' ) $event['start'] = '';//if date isn't set
        	else $event['start'] = $event['start_date'].' '.$event['start_time'];
            unset( $event['start_date'], $event['start_time'] );
            
            //set event end
            if( $event['end_date'] == '0000-00-00' ) $event['end'] = '';//if date isn't set
            else $event['end'] = $event['end_date'].' '.$event['end_time'];
            unset($event['end_date'],$event['end_time']);
            
            $event['id'] = $event[$this->id_column];
            unset($event[$this->id_column]);
            
            $event['allDay'] = ($event['allDay'])?true:false;//convert to boolean for javascript
        }
        
        return $events;
    }
    
    /**
     * Move event (change event's start date/time).
     *
     * @param array $event
     * @param integer $dayDelta
     * @param integer $minuteDelta
     * @param string (true|false) $allDay
     * @return char(16)
     */
    public function moveEvent(array $event, $dayDelta, $minuteDelta, $allDay)
    {
        if( !isset($dayDelta) || !isset($minuteDelta) || !isset($allDay) ) 
        {
            error_log("Agenda event couldn't be moved. Some required params not posted.");
            return FALSE;
        }
        
        $event['allDay'] = ($allDay=='true')?1:0;
			
		//move start
		$event['start'] = $event['start_date'].' '.$event['start_time'];
		
		$timestamp = strtotime($event['start'] . " {$dayDelta} days {$minuteDelta} mins ");
		unset($event['start']);
		
		$event['start_date'] = date('Y-m-d',$timestamp);
		$event['start_time'] = date('H:i:s',$timestamp);
		
		//move end
		if( $event['end_date'] != '0000-00-00' ) 
		{
		    $event['end'] = $event['end_date'].' '.$event['end_time'];
		    
		    $timestamp = strtotime($event['end'] . " {$dayDelta} days {$minuteDelta} mins ");
		    
		    $event['end_date'] = date('Y-m-d',$timestamp);
		    $event['end_time'] = date('H:i:s',$timestamp);
		}
		
		return $this->update($event);
    }
    
    /**
     * Extend event (change event's end date/time).
     *
     * @param array $event
     * @param integer $dayDelta
     * @param integer $minuteDelta
     * @return char(16)
     */
    public function extendEvent(array $event, $dayDelta, $minuteDelta)
    {
        if( $event['end_date'] == '0000-00-00' ) 
		{
			$event['end_date'] = $event['start_date'];
		}
		if( $event['end_date'] == '0000-00-00' || $event['end_time'] == '00:00:00' ) 
		{
			$event['end_time'] = $event['start_time'];
			$minuteDelta += 120;//default event duration
		}
		$event['end'] = $event['end_date'].' '.$event['end_time'];
		
		$timestamp = strtotime($event['end'] . " {$dayDelta} days {$minuteDelta} mins ");
		unset($event['end']);
		
		$event['end_date'] = date('Y-m-d',$timestamp);
		$event['end_time'] = date('H:i:s',$timestamp);
		
		return $this->update($event);
    }
    
    /**
	 * Insert data. Returns ID field.
	 * Overrides paramt method.
	 * 
	 * @param array $event
	 * @return char(16)
	 */
    public function Insert($event)
    {
		$event['customer_id'] = $this->CI->session->userdata('customer_id'); 
		
		$event = $this->prepareEvent($event);
		
		return parent::Insert($event);
    }
    
    /**
     * Update data. Returns ID field.
	 * Overrides paramt method.
     *
     * @param array $event
     * @return char(16)
     */
    public function update($event)
    {
        $event = $this->prepareEvent($event);
        
        parent::update($event);
        
        return $event[$this->id_column];
    }
    
    /**
     * Make some preparation before add/update event.
     *
     * @param array $event
     * @return array
     */
    private function prepareEvent($event)
    {
        $event['start'] = $event['start_date'].' '.$event['start_time'];    
	    $start = strtotime($event['start']);
		
		$event['end'] = $event['end_date'].' '.$event['end_time'];    
	    $end = strtotime($event['end']);
	    
	    //start of event couldn't be greater than end
	    if($start > $end)
	    {
	         $event['end_date'] = '0000-00-00';
	         $event['end_time'] = '00:00:00';
	    } 
	    
	    return $event;
    }
}