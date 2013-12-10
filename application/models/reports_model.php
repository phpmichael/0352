<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for reports.
 * 
 * @package reports  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Reports_model extends Base_model
{
	//name of table
	protected $c_table = 'reports';
	//name of primary field
	protected $id_column = 'data_key';
	
	/**
	 * Generate report.
	 *
	 * @param string(16) $data_key
	 * @param array $params
	 * @return array
	 */
	public function report($data_key,$params = array() )
	{
		//get report fields
		$report = $this->getOneById($data_key);
		
		$date_field = $report['date_field'];

		//build items array
		$items = array();
		foreach ($report as $field=>$value)
		{
			if(preg_match("/^item_name_(\d+)$/",$field,$matches) && $value) //if field is item's name
			{
				$items[$matches[1]]['name'] = $value;
			}
			elseif(preg_match("/^item_sql_(\d+)$/",$field,$matches) && $value) //if field is item's sql
			{
				$items[$matches[1]]['sql'] = $value;
			}
		}
		
		//calculate items' amounts
		foreach ($items as &$item)
		{
			//add period to where clause
			if(preg_match("/^year-(\d{4})$/",$report['period'],$matches))
			{
				$year = $matches[1];
				$item['sql'] .= " AND {$date_field}>='{$year}-01-01 00:00:00' AND {$date_field}<='{$year}-12-31 23:59:59' ";
			}
			elseif(preg_match("/^recent-(\d+)-months?$/",$report['period'],$matches))
			{
				$months = $matches[1];
				$item['sql'] .= " AND TO_DAYS({$date_field})>=(TO_DAYS(CURDATE())-{$months}*30) ";
			}
			
			
			switch ($report['group_by'])
			{
				case "year":
					$item['sql'] = str_ireplace("SELECT ","SELECT SUBSTR(`{$date_field}`,1,4) AS group_by, ",$item['sql']);//add to select year like '2012'
					$item['sql'] .= " GROUP BY SUBSTR(`{$date_field}`,1,4)";//group by month like '2012'
					
					$results = $this->db->query($item['sql'])->result_array();
					foreach ($results as &$result)
					{
						$item['amounts'][$result['group_by']] = $result['amount'];
					}
				break;
				
				case "month":
					$item['sql'] = str_ireplace("SELECT ","SELECT SUBSTR(`{$date_field}`,1,7) AS group_by, ",$item['sql']);//add to select month like '2012-01'
					$item['sql'] .= " GROUP BY SUBSTR(`{$date_field}`,1,7)";//group by month like '2012-01'
					
					$results = $this->db->query($item['sql'])->result_array();
					
					$item['amounts'] = array();
					foreach ($results as &$result)
					{
						$result['group_by'] = date('F',strtotime($result['group_by'].'-01')).' '.substr($result['group_by'],0,4);//format month like "January 2012"
						$item['amounts'][$result['group_by']] = $result['amount'];
					}
				break;
				
				default:
					$result = $this->db->query($item['sql'])->row_array();
					$item['amounts']['Amount'] = array_pop($result);
			}
			
			//dump($item['sql']);
		}
		//dump($items);exit;
		
		//store unique groups in array
		$groups = array();
		foreach ($items as $el)
		{
			$groups = array_merge($groups,array_keys($el['amounts']));
		}
		$groups = array_unique($groups);
		
		//sort by months
		if($report['group_by']=='month') $groups = $this->sortByDate($groups);
		
		$report['items'] = $items;
		$report['groups'] = $groups;
		
		if(isset($params['rotate'])) $report = $this->rotateXY($report);
		
		//dump($report);exit;
		return $report;
	}
	
	/**
	 * Sort by months.
	 *
	 * @param array $groups
	 * @return array
	 */
	private function sortByDate($groups)
	{
		$dates = array();
		foreach ($groups as $group)
		{
			$dateArr = date_parse($group);
			
			$year = $dateArr['year'];
			$month = (strlen($dateArr['month'])==2)?$dateArr['month']:'0'.$dateArr['month'];
			
			$dates["{$year}-{$month}"] = $group;
			
		}
		ksort($dates);
		
		return $dates;
	}
	
	/**
	 * Rotate report lines X/Y.
	 *
	 * @param array $report
	 * @return array
	 */
	private function rotateXY($report)
	{
		$rotated_groups = array();
		$rotated_items = array();
		
		$i=1;
		/*foreach ($report['items'] as $key=>$item)
		{
			foreach ($item['amounts'] as $group=>$amount)
			{
				//if already exist item with name==$group - get its index
				if( ($index = $this->getItemIndexByName($rotated_items,$group)) !== false)
				{
					$rotated_items[$index]['name'] = $group;
					$rotated_items[$index]['amounts'][$item['name']] = $amount;
					if(isset($item['urls'][$group])) $rotated_items[$index]['urls'][$item['name']] = $item['urls'][$group];
				}
				else 
				{
					$rotated_items[$i]['name'] = $group;
					$rotated_items[$i]['amounts'][$item['name']] = $amount;
					if(isset($item['urls'][$group])) $rotated_items[$i]['urls'][$item['name']] = $item['urls'][$group];
					
					$i++;
				}
			}
			
			//rotating groups
			$rotated_groups[] = $item['name'];
		}*/
		foreach ($report['items'] as $key=>$item)
		{
			foreach ($report['groups'] as $group)
			{
				if($amount = @$item['amounts'][$group])
				{
    			    //if already exist item with name==$group - get its index
    				if( ($index = $this->getItemIndexByName($rotated_items,$group)) !== false)
    				{
    					$rotated_items[$index]['name'] = $group;
    					$rotated_items[$index]['amounts'][$item['name']] = $amount;
    					if(isset($item['urls'][$group])) $rotated_items[$index]['urls'][$item['name']] = $item['urls'][$group];
    				}
    				else 
    				{
    					$rotated_items[$i]['name'] = $group;
    					$rotated_items[$i]['amounts'][$item['name']] = $amount;
    					if(isset($item['urls'][$group])) $rotated_items[$i]['urls'][$item['name']] = $item['urls'][$group];
    					
    					$i++;
    				}
				}
				elseif( ($index = $this->getItemIndexByName($rotated_items,$group)) === false) 
				{
				    $rotated_items[$i]['name'] = $group;
				    $rotated_items[$i]['amounts'][$item['name']] = 0;
				    
				    $i++;
				}
			}
			
			//rotating groups
			$rotated_groups[] = $item['name'];
		}
		
		$report['groups'] = $rotated_groups;
		$report['items'] = $rotated_items;
		
		return $report;
	}
	
	/**
	 * Return item's index(key) by its name.
	 *
	 * @param array $items
	 * @param string $name
	 * @return integer
	 */
	private function getItemIndexByName($items,$name)
	{
		foreach ($items as $key=>$item)
		{
			if($item['name']==$name) return $key;
		}
		
		return false;
	}
	
}