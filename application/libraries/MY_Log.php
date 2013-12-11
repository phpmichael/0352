<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class for logs.
 *
 * @package log
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class MY_Log extends CI_Log 
{
	//array for store logs
    public $logs = array();

    /**
     * Constructor for MY_Log
     */
    public function __construct()
	{
		parent::__construct();
	}

    /**
     * Write message to logs.
     * @param string $level
     * @param string $msg
     * @param bool $php_error
     * @return bool|void
     */
    public function write_log($level = 'error', $msg, $php_error = FALSE)
	{
		//write logs
	    if( 
	    	   !preg_match("/Severity: Notice/",$msg) 
	    	&& !preg_match("/404 Page Not Found --> favicon\.ico/",$msg) 
	    	&& !preg_match("/404 Page Not Found --> apple-touch-icon\.png/",$msg) 
	    	&& !preg_match("/404 Page Not Found --> apple-touch-icon-precomposed\.png/",$msg) 
	    ) 
	    {
	        $user_agent = "";
	        
	        if($level=='error') $user_agent = "   User Agent: {$_SERVER['HTTP_USER_AGENT']}";
	        
	        parent::write_log($level, $msg . $user_agent, $php_error);
	    }
		
		//$memory	 = (!function_exists('memory_get_usage')) ? '0' : memory_get_usage();
		$b = load_class('Benchmark');
		$b->mark($msg);
		
		//store logs for debug toolbar
		if( !preg_match("/Severity: Notice/",$msg) ) $this->logs[] = array(date('Y-m-d H:i:s P'), $level, $msg);
	}
	
}