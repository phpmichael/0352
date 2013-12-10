<?php
require_once(APPPATH.'controllers/abstract/admin_fb.php');

/** 
 * This is admin controller for agenda.
 * 
 * @package agenda  
 * @author Michael Kovalskiy
 * @version 2013
 * @access public
 */
class Agenda extends Admin_fb
{
    protected $process_form_html_id = "agenda";

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Agenda
     */
	public function __construct()
	{
		parent::__construct();	
		
		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
		
		// === Page Titles === //
		$this->page_titles['index'] = 'Agenda';
		//default page title
		$this->_setDefaultPageTitle();
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	/**
	 * Build right top admin menu.
	 * Overrides parent method.
	 * 
	 * @return string
	 */
	public function _built_right_menu()
	{
		return '';
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	

	/**
	 * Show agenda.
	 *
	 */
	public function Index() 
    {	
    	$data['tpl_page'] = $this->_getController().'/index';
		
    	parent::_OnOutput($data);
    }
    
    /**
     * Return agenda events in JSON format.
     *
     */
    public function get_events()
    {   	
    	$events = $this->agenda_model->getEvents($this->input->get('start'),$this->input->get('end'));
        
        echo json_encode($events);
    }
    
    /**
     * Change agenda event.
     *
     * @param bool|string(16) $data_key
     * @param bool|char(10) $date
     */
    public function edit_event($data_key=FALSE,$date=FALSE)
    {
        if($this->input->post())
		{
			$data_key = $this->model->storeForm($this->input->post(),$this->process_form_id,$data_key);
		    
		    if($this->input->is_ajax_request()) 
		    {
		    	if($data_key) echo json_encode(array('status'=>'success','id'=>$data_key));
		    	else echo json_encode(array('status'=>'error','message'=>'Data validation failed.'));
		    	
		    	exit;
		    }
		}
		
	    $data['form_id'] = $this->process_form_id;
	    $data['data_key'] = $data_key;
	    
	    if(!$data_key) $this->model->setFormData(array('start_date' => $date));//add new - set default date
	    
		load_theme_view('admin_fb/build',$data);
    }

    /**
     * Delete agenda event.
     *
     * @param bool|string(16) $data_key
     */
    public function delete_event($data_key=FALSE)
	{
		$this->agenda_model->deleteId($data_key);
		
		if($data_key) echo json_encode(array('status'=>'success','id'=>$data_key));
		else echo json_encode(array('status'=>'error','message'=>'Please set event ID.'));
	}
	
	/**
	 * Move agenda event (change event's start date/time).
	 *
	 * @param string(16) $id
	 * @param integer $dayDelta
	 * @param integer $minuteDelta
	 * @param string (true|false) $allDay
	 */
	public function move_event($id, $dayDelta, $minuteDelta, $allDay)
	{
		$event = $this->agenda_model->getOneById($id);
		
		if($event)
		{
			$this->agenda_model->moveEvent($event, $dayDelta, $minuteDelta, $allDay);
			
			echo json_encode(array('status'=>'success','id'=>$id));
		}
		else echo json_encode(array('status'=>'error','message'=>'Event not found.'));
	}
	
	/**
     * Extend event (change event's end date/time).
     *
     * @param string(16) $id
     * @param integer $dayDelta
     * @param integer $minuteDelta
     */
	public function extend_event($id, $dayDelta, $minuteDelta)
	{
		$event = $this->agenda_model->getOneById($id);
		
		if($event)
		{
			$this->agenda_model->extendEvent($event, $dayDelta, $minuteDelta);
			
			echo json_encode(array('status'=>'success','id'=>$id));
		}
		else echo json_encode(array('status'=>'error','message'=>'Event not found.'));
	}
}