<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for system tools.
 * 
 * @package tools  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Tools_model extends Base_model 
{
	//name of table
	protected $c_table = '';
	
	private $dblist = array(
	   'CI-0352',
	   'CI-angel',
	   'CI-cancer',
	   'CI-ekomag',
	   'CI-eurodah',
	   'CI-gallery-fit',
	   'CI-haogang',
	   'CI-ionika',
	   'CI-pozitiv',
	   'CI-whitecat',
	);
	
	/**
	 * Run some SQL in database.
	 *
	 * @param string $dbname
	 * @param string $sql
	 */
	private function runSql($dbname,$sql)
	{
	    if($dbname && $sql) 
	    {
	        $this->db->query("USE `{$dbname}`");
	        $this->db->query($sql);
	    }
	}
	
	/**
	 * Upgrade all databases (projects).
	 *
	 * @param string $sql
	 */
	public function upgradeDatabases($sql)
	{
	    foreach ($this->dblist as $dbname)
	    {
	        $this->runSql($dbname,$sql);
	        echo $dbname.' <br />';
	        @flush();
	        @ob_flush();
	    }
	}

    /**
     * Backup database
     * @param string $backupPath
     */
    public function backup($backupPath)
    {
        $this->changeDbDriver('mysql');//just mysql driver allowed

        $this->load->dbutil();
        $this->load->helper('file');

        write_file($backupPath, $this->dbutil->backup());
    }
	
}