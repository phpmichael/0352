<?php
require_once(APPPATH.'models/posts_model.php');

/** 
 * This is model for instructors table.
 * Project: kurort-bukovel
 * 
 * @package instructors  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Instructors_model extends Posts_model
{
	//name of table
	protected $c_table = 'instructors';
	//name of primary field
	protected $id_column = 'data_key';
	
	protected $with_customer_info = TRUE;
    
    /**
	 * Make sql criterias based on $filter_data.
	 * 
	 * @param $filter_data
	 * @return string
	 */
    protected function _buildWhere(array $filter_data = array())
    {
        $where = "1";
    	
        //Instructor on
		if( isset($filter_data['instructor_on']) && $filter_data['instructor_on'] )
		{
			$where .= " AND {$this->c_table}.instructor_on LIKE '%".$this->db->escape_str($filter_data['instructor_on'])."%'";
		}
		
		//Name
		if( isset($filter_data['customer_name']) && $filter_data['customer_name'] )
		{
			$where .= " AND {$this->customers_table}.name = '".$this->db->escape_str($filter_data['customer_name'])."'";
		}
		if( isset($filter_data['customer_surname']) && $filter_data['customer_surname'] )
		{
			$where .= " AND {$this->customers_table}.surname = '".$this->db->escape_str($filter_data['customer_surname'])."'";
		}
		
		//Experience skiing
		if( isset($filter_data['experience_skiing_1']) && $filter_data['experience_skiing_1'] )
		{
			$where .= " AND {$this->c_table}.experience_skiing >= ".intval($filter_data['experience_skiing_1']);
		}
		if( isset($filter_data['experience_skiing_2']) && $filter_data['experience_skiing_2'] )
		{
			$where .= " AND {$this->c_table}.experience_skiing <= ".intval($filter_data['experience_skiing_2']);
		}
		
		//Work experience instructor or trainer
		if( isset($filter_data['experience_instructor_1']) && $filter_data['experience_instructor_1'] )
		{
			$where .= " AND {$this->c_table}.experience_instructor >= ".intval($filter_data['experience_instructor_1']);
		}
		if( isset($filter_data['experience_instructor_2']) && $filter_data['experience_instructor_2'] )
		{
			$where .= " AND {$this->c_table}.experience_instructor <= ".intval($filter_data['experience_instructor_2']);
		}
		
		//Experience on TK Bukovel
		if( isset($filter_data['experience_bukovel_1']) && $filter_data['experience_bukovel_1'] )
		{
			$where .= " AND {$this->c_table}.experience_bukovel >= ".intval($filter_data['experience_bukovel_1']);
		}
		if( isset($filter_data['experience_bukovel_2']) && $filter_data['experience_bukovel_2'] )
		{
			$where .= " AND {$this->c_table}.experience_bukovel <= ".intval($filter_data['experience_bukovel_2']);
		}
		
		//Specialization
		if( isset($filter_data['specialization']) && strlen($filter_data['specialization'])>=3 )
		{
			$where .= " AND {$this->c_table}.specialization LIKE '%".$this->db->escape_str($filter_data['specialization'])."%'";
		}
		
		//With video
		if( isset($filter_data['with_video']) && $filter_data['with_video'] )
		{
			$where .= " AND {$this->c_table}.youtube_video1 != ''";
		}
		
		//Teaching skiing
		if( isset($filter_data['teaching_skiing']) && !empty($filter_data['teaching_skiing']) )
		{
			$where .= $this->_buildOrWhereForArray('teaching_skiing',$filter_data['teaching_skiing']);
		}
		
		//Fluency in languages
		if( isset($filter_data['fluency_in_languages']) && !empty($filter_data['fluency_in_languages']) )
		{
			$where .= $this->_buildOrWhereForArray('fluency_in_languages',$filter_data['fluency_in_languages']);
		}
        
		return $where;
    }
}