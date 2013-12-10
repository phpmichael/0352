<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is instant messenger model.
 * 
 * @package IM  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Im_model extends Base_model
{
	//name of table
	protected $c_table = 'im';
	
    /**
	 * Insert message in table. Returns ID field.
	 * 
	 * @param integer $from_id
	 * @param integer $to_id
	 * @param string $message
	 * @return integer
	 */
	public function addMessage($from_id,$to_id,$message)
	{
		parent::insert(array('from_id'=>(int)$from_id,'to_id'=>(int)$to_id,'message'=>$message));
	}
	
	/**
	 * Returns all new messages sent from $from_id to $to_id. 
	 * 
	 * @param integer $from_id
	 * @param integer $to_id
	 * @return array
	 */
	public function getNewMessages($from_id,$to_id)
	{
		$this->db->where(array('from_id'=>$from_id,'to_id'=>$to_id,'read'=>0));
		$records = $this->db->get($this->c_table)->result_array();
		
		foreach ($records as &$record)
		{
			$record['seconds'] = strtotime($record['date']);
			$record['message'] = str_replace("\n","<br />",$record['message']);
			
			//set read
			$this->db->update($this->c_table,array('read'=>1),array('id'=>$record['id']));
		}
		
		return $records;
	}

    /**
     * Returns history (read) messages sent from $from_id to $to_id.
     *
     * @param integer $from_id
     * @param integer $to_id
     * @param int $limit
     * @return array
     */
	public function getHistoryMessages($from_id,$to_id,$limit=9999)
	{
		$from_id = intval($from_id);
		$to_id = intval($to_id);
		
	    $this->db->where("(from_id={$from_id} AND to_id={$to_id} AND `read`=1) OR (from_id={$to_id} AND to_id={$from_id})");
		$this->db->order_by('date desc');
		$this->db->limit($limit);
		$records = $this->db->get($this->c_table)->result_array();
		
		$results = array();
		foreach ($records as $record)
		{
			$results[$record['id']] = $record;
		    $results[$record['id']]['seconds'] = strtotime($record['date']);
		    $record['message'] = str_replace("\r","",$record['message']);
			$results[$record['id']]['message'] = str_replace("\n","<br />",$record['message']);
		}
		
		ksort($results);
		
		return $results;
	}
}