<?php
require_once(APPPATH.'models/posts_model.php');

/** 
 * This is models for articles table.
 * 
 * @package articles  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Articles_model extends Posts_model
{
	//name of table
	protected $c_table = 'articles';
	//name of ...
	protected $c_type = "article";
    //name of tags table
	protected $tags_table = "tags";
	//name of categories table
	protected $categories_list_table = 'articles_categories_list';
    
	/**
	 * Make sql criterias based on $filter_data.
	 * 
	 * @param $filter_data
	 * @return string
	 */
    protected function _buildWhere(array $filter_data = array())
    {
		$where = "1";
    	
    	if( isset($filter_data['category']) && $filter_data['category'] )
		{
			$where .= " AND {$this->posts_categories_table}.category_id=".intval($filter_data['category']);
		}
		if( isset($filter_data['keywords']) && ($keywords = $this->CI->security->xss_clean(trim(urldecode($filter_data['keywords'])))) )
		{
			$where .= " AND CONCAT(".$this->prepareFieldForSearch('head').",'|',".$this->prepareFieldForSearch('body').") LIKE '%".$this->db->escape_str($keywords)."%'";
		}
		//filter by date
		if(isset($filter_data['date']) && preg_match("/^\d{4}(-\d{2})?(-\d{2})?$/",$filter_data['date']))
    	{
    		$where .= " AND `pub_date` LIKE '".$filter_data['date']."%'";
    	}
    	//calendar filter
    	if(isset($filter_data['year']) && preg_match("/^\d{4}$/",$filter_data['year']) && isset($filter_data['month']) && preg_match("/^\d{2}$/",$filter_data['month']) )
    	{
    		$where .= " AND `pub_date` LIKE '{$filter_data['year']}-{$filter_data['month']}%'";
    	}
    	//filter by tag
		if( isset($filter_data['tag']) && ($tag = $this->CI->security->xss_clean(trim(urldecode($filter_data['tag'])))) )
		{
		    $where .= " AND {$this->tags_table}.table='{$this->c_table}' AND {$this->tags_table}.tag='".$this->db->escape_str($tag)."'";
		}
		
		return $where;
    }
    
    /**
	 * Make order by based on $filter_data.
	 * 
	 * @param $filter_data
	 * @return string
	 */
    protected function _buildOrderBy(array $filter_data=array())
    {
    	if( !isset($filter_data['sort_by']) ) $filter_data['sort_by'] = 'id';
    	if( !isset($filter_data['sort_order']) ) $filter_data['sort_order'] = 'desc';
    	
    	return parent::_buildOrderBy($filter_data);
    }
    
    /**
	 * Return list of months when posts were added with amount of posts per month.
	 *
	 * @param array $args
	 * @return array
	 */
	public function getArchivesList(array $args=array())
    {
		$archives = array();
		
		$args['limit'] = intval($args['limit']);
		
		if ( 'monthly' == $args['type'] ) 
		{
			$sql = "
			SELECT YEAR(`pub_date`) AS `year`, MONTH(`pub_date`) AS `month`, COUNT(id) as amount
			FROM {$this->c_table}  
			GROUP BY YEAR(`pub_date`), MONTH(`pub_date`)
			ORDER BY `pub_date` DESC LIMIT {$args['limit']}
			";
			
    		$archives = $this->db->query($sql)->result_array();
		}
		
		return $archives;
    }
	
    /**
     * Return list of days when posts were addded with amount of posts per day (for defined month).
     * 
     * @param string $year
     * @param string $month
     * @return array
     */
    protected function getMonthList($year,$month)
    {
    	if(strlen($month)==1) $month = '0'.$month;
    	
    	$sql = "
		SELECT DAY(`pub_date`) AS `day`, COUNT(id) as amount
		FROM {$this->c_table}  
		WHERE `pub_date` LIKE ?
		GROUP BY YEAR(`pub_date`), MONTH(`pub_date`), DAY(`pub_date`)
		ORDER BY `pub_date`
		";
		
		return $this->db->query($sql,array("{$year}-{$month}-%"))->result_array();
    }

    /**
     * Return html of calendar.
     *
     * @return string
     */
    public function buildCalendarBox()
    {
    	$assoc_uri = $this->CI->uri->uri_to_assoc($this->CI->_getSegmentsOffset()+3);
    	
    	$year = (isset($assoc_uri['year']))? $assoc_uri['year'] : date('Y');
    	$month = (isset($assoc_uri['month']))? $assoc_uri['month'] : date('m');
		
		$config = array(
			'start_day' => 'monday',
			'show_next_prev' => TRUE,
			'next_prev_url' => base_url().$this->CI->_getBaseURI().'/calendar',
		);
		
		$this->load->library('calendar',$config);
		
		$list = $this->getMonthList($year,$month);
		
		$calendar_data = array();
		
		foreach ($list as $item)
		{
			$calendar_data[$item['day']] = site_url($this->CI->_getBaseURI()."/index/date/".$year."-".$month."-".$item['day']);
		}
		
		return $this->CI->calendar->generate($year,$month,$calendar_data);
    }
}