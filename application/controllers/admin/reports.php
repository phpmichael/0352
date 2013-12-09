<?php
require_once(APPPATH.'controllers/abstract/admin_fb.php');

/** 
 * This is admin controller for reports.
 * 
 * @package reports  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Reports extends Admin_fb 
{
    protected $process_form_html_id = "reports"; 
    
    /**
    * Init models, set pages' titles, fields' titles, set languages' sections.
    * 
    * @return void
    */
	public function __construct()
	{
		parent::__construct();	
		
		// === Page Titles === //
		$this->page_titles['table'] = language('report');
		$this->page_titles['chart'] = language('chart');
		//default page title
		$this->_setDefaultPageTitle();
	}
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Generate report.
	 *
	 */
	private function report()
	{
		$data_key = $this->segment_item;
		$data = $this->reports_model->report($data_key,$this->input->post());
		
		if($this->input->post()) $data = array_merge($data,$this->input->post());
	    
		parent::_OnOutput($data);
	}
	
	/**
	 * Show report as chart.
	 *
	 */
	public function chart()
	{
	    $this->report();
	}
	
	/**
	 * Show report as HTML table.
	 *
	 */
	public function table()
	{
		$this->report();
	}
	
	/**
	 * Save report in CSV file.
	 *
	 */
	public function csv_export()
	{
		$data_key = $this->segment_item;
		$data = $this->reports_model->report($data_key);
		
		$csv_array[] = array_merge(array('Items'),$data['groups']);
		foreach ($data['items'] as $item)
		{
			$line = array($item['name']);
			foreach ($data['groups'] as $group)
			{
				$line[] = intval(@$item['amounts'][$group]);
			}
			$csv_array[] = $line;
		}
		 
		$this->load->helper('csv');
		array_to_csv($csv_array,'report.csv');
		
		exit;
	}
}