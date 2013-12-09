<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for system tools.
 * 
 * @package tools  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Tools extends Admin 
{
	private $pathToProjects = "Z:/home/localhost/www/CI/";
	
    /**
	 * Init models, set pages' titles, fields' titles, set languages' sections.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model('tools_model');
		// === Load Libraries === //
		$this->load->library('tools_lib');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	/**
	 * Build rigth top admin menu.
	 * Overrides parent method.
	 * 
	 * @return string
	 */
	public function _built_right_menu()
	{
		return "";
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Main action.
	 *
	 */
	public function Index(){}
	
	/**
	 * Create new project folder with symlinks.
	 *
	 * @param string $projectName
	 * @param string $sourceName
	 * @return void
	 */
	public function create_project($projectName, $sourceName = '0352')
	{
		if(!$projectName) return FALSE;
		
		$soureDir = "{$this->pathToProjects}{$sourceName}/";
	    $projectDir = "{$this->pathToProjects}{$projectName}/";
	    
	    $this->tools_lib->createProject($soureDir,$projectDir);
	}
	
	/**
	 * Upgrade all databases (projects).
	 *
	 */
	public function upgrade_databases()
	{
		//$sql = "UPDATE `settings` SET `value`='1' WHERE `param`='ratings_for_articles_allowed'";
	    
		if(isset($sql)) $this->tools_model->upgradeDatabases($sql);
	}
	
	/**
	 * Create new symlink in project.
	 *
	 * @param string $symlink (ie - 'images/social')
	 * @param bool $is_dir 
	 * @param string $projectName
	 * @param string $sourceName
	 */
	public function add_symlink($symlink, $is_dir, $projectName, $sourceName = '0352')
	{
	    if(!$projectName) return FALSE;
		
		$soureDir = "{$this->pathToProjects}{$sourceName}/";
	    $projectDir = "{$this->pathToProjects}{$projectName}/";
		
	    $this->tools_lib->mksymlink($soureDir.$symlink,$projectDir.$symlink,$is_dir);
	}
	
	/**
	 * Check writable permissions.
	 *
	 * @param string $projectName
	 */
	public function check_project_config($projectName=FALSE)
    {
    	if(!$projectName) 
    	{
    	    preg_match("#/CI/([\w\-]+)/#i",$this->input->server('REQUEST_URI'),$matches);
    	    $projectName = @$matches[1];
    	}
    	
    	if(!$projectName) return FALSE;
    	
    	$front_theme = "default";
    	
    	$writeableFolders = array('store'=>0,'application/cache'=>0,'application/logs'=>0,'images/captcha'=>0,'images/data'=>0,"themes/{$front_theme}/css"=>0,"themes/{$front_theme}/js"=>0);
    	
    	foreach ($writeableFolders as $folderName=>$isWritable)
    	{
    		if( is_writable("{$this->pathToProjects}{$projectName}/{$folderName}") )
    		{
    			$writeableFolders[$folderName] = 1;
    		}
    	}
    	
    	dump($writeableFolders);
    }

}