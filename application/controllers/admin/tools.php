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
	private $pathToProjects = "F:/OpenServer/domains/localhost/CI/";

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Tools
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
	 * Build right top admin menu.
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
	 * @return bool
	 */
	public function create_project($projectName, $sourceName = '0352')
	{
		if(!$projectName) return FALSE;
		
		$sourceDir = "{$this->pathToProjects}{$sourceName}/";
	    $projectDir = "{$this->pathToProjects}{$projectName}/";
	    
	    $this->tools_lib->createProject($sourceDir,$projectDir);

        return TRUE;
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
     * @return bool
	 */
	public function add_symlink($symlink, $is_dir, $projectName, $sourceName = '0352')
	{
	    if(!$projectName) return FALSE;
		
		$sourceDir = "{$this->pathToProjects}{$sourceName}/";
	    $projectDir = "{$this->pathToProjects}{$projectName}/";
		
	    $this->tools_lib->mksymlink($sourceDir.$symlink,$projectDir.$symlink,$is_dir);

        return TRUE;
	}

    /**
     * Check writable permissions.
     *
     * @param bool|string $projectName
     * @return bool
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

        return TRUE;
    }

    public function cache()
    {
        $this->load->driver('cache');

        if ($this->cache->apc->is_supported())
        {
            echo "APC"."<br/>";
        }
        if ($this->cache->memcached->is_supported())
        {
            echo "Memcache"."<br/>";
        }
        if ($this->cache->file->is_supported())
        {
            echo "File"."<br/>";
        }
    }

    public function optimize_images($quality = 83){
        $dirs = array(
            './images/data/b/slideshow/',
            './images/data/m/slideshow/',
            './images/data/s/slideshow/',
        );

        foreach($dirs as $dir)
        {
            $scan = glob(rtrim($dir,'/').'/*');
            foreach($scan as $filename)
            {
                if(!stristr($filename,'.jpg')) continue;

                //$destination_filename = str_replace('.jpg','-'.$quality.'.jpg',$filename);
                $destination_filename = $filename;

                $resource = imagecreatefromjpeg($filename);
                imagejpeg($resource, $destination_filename, $quality);
            }
        }
    }
}