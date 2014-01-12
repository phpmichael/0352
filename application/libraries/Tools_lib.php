<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tools_lib 
{
    /**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		log_message('debug', "Tools_lib Class Initialized");
	}
    
	/**
	 * Create new project folder with symlinks.
	 *
	 * @param string $soureDir
	 * @param string $projectDir
	 */
    public function createProject($soureDir,$projectDir)
    {
        $soureDir = trim($soureDir);
        $projectDir = trim($projectDir);
        
        if( $this->mkdir($projectDir,0755) )
        {
            $folders = array(
                'application' => 0755,
                'application/cache' => 0777,
                'application/config' => 0755,
                'application/logs' => 0777,
                'images' => 0755,
                'images/captcha' => 0777,
                'images/data' => 0777,
                'images/data/b' => 0777,
                'images/data/m' => 0777,
                'images/data/s' => 0777,
                'store' => 0777,
            );
            
            foreach ($folders as $folder=>$mode)
        	{
        		$this->mkdir($projectDir.$folder,$mode);
        	}
            
        	
        	$files = array(
                'index.php',
                'application/cache/.htaccess',
                'application/cache/index.html',
                'application/config/config.php',
                'application/config/database.php',
                'application/config/hooks.php',
            );
            
            foreach ($files as $file)
            {
                copy($soureDir.$file,$projectDir.$file);
            }
            
            $symlinks = array(
                //root
                'css' => 1,
                'js' => 1,
                'system' => 1,
                'themes' => 1,
                '.htaccess' => 0,
                'license.txt' => 0,
                'PIE.htc' => 0,
                'robots.txt' => 0,
                'site_offline.php' => 0,
                
                //application 
                'application/controllers' => 1,
                'application/core' => 1,
                'application/errors' => 1,
                'application/helpers' => 1,
                'application/hooks' => 1,
                'application/language' => 1,
                'application/libraries' => 1,
                'application/models' => 1,
                'application/third_party' => 1,
                'application/views' => 1,
                'application/.htaccess' => 0,
                'application/index.html' => 0,
                
                //application/config
                'application/config/autoload.php' => 0,
                'application/config/constants.php' => 0,
                'application/config/debug_toolbar.php' => 0,
                'application/config/doctypes.php' => 0,
                'application/config/foreign_chars.php' => 0,
                'application/config/hooks.php' => 0,
                'application/config/index.html' => 0,
                'application/config/migration.php' => 0,
                'application/config/mimes.php' => 0,
                'application/config/profiler.php' => 0,
                'application/config/routes.php' => 0,
                'application/config/smileys.php' => 0,
                'application/config/user_agents.php' => 0,
                'application/config/zen.php' => 0,

                //images
                'images/debug_toolbar' => 1,
                'images/file_types' => 1,
                'images/flags' => 1,
                'images/social' => 1,
                'images/index.html' => 0,
            );
        	
        	foreach ($symlinks as $symlink=>$is_dir)
        	{
        		//remove symlink
        		//exec("rm ".$projectDir.$symlink);
        		
        		//create symlink
        		$this->mksymlink($soureDir.$symlink,$projectDir.$symlink,$is_dir);
        	}
        	
        }
        
    }
    
    /**
     * Create folder if exists, with permissions.
     *
     * @param string $dir
     * @param integer $mode (ie 755)
     * @return bool
     */
    public function mkdir($dir,$mode) 
    {
        if( !file_exists($dir) )
    	{
    		mkdir($dir);
    		chmod($dir,$mode);
    		
    		return TRUE;
    	}
    	
    	return FALSE;
    }
   
    /**
     * Create synlink
     *
     * @param string $target
     * @param string $linkname
     * @param bool $is_dir
     * @return bool
     */
    public function mksymlink($target,$linkname,$is_dir=false) 
    {
        $is_windows = TRUE;
        /*echo "------------------------------------------------------------------<br/>";
        echo $target;
        echo '<br/>';
        echo $linkname;
        echo '<br/>';*/
        
        if( file_exists($target) && !file_exists($linkname) )
    	{
    		if($is_windows)
    		{
    		    $target = str_replace('/','\\\\',$target);
    		    $linkname = str_replace('/','\\\\',$linkname);
    		    
    		    $D = ($is_dir) ? "/D" : "";
    		    $command = "mklink {$D} {$linkname} {$target}";//need admin rights
    		}
    	    else 
    	    {
    	        $command = "ln -s {$target} {$linkname}";
    	    }
    		
    		exec($command);
    		echo "------------------------------------------------------------------<br/>";
    		echo $command;
    		echo '<br/>';
    		
    		return TRUE;
    	}
    	
    	return FALSE;
    }
    
    
}