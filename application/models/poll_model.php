<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for poll.
 * 
 * @package poll  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Poll_model extends Base_model
{
	//name of table
	protected $c_table = 'poll_list';
	//list of colors used for display poll results
	private $result_colors = array(
	   '#9BB4DE',
	   '#46A86B',
	   '#E17B1A',
	   '#DA3838',
	   '#D9AA26',
	   '#00AFF0',
	   '#D732E6',
	   '#1E5397',
	   'pink',
	   'brown',
	   'grey'
	);
	
    /**
	 * Returns records from table by $params.
	 * 
	 * @param array $params
	 * @return array
	 */
	private function getPollRecords(array $params=array())
	{
		$this->db->order_by('title');
	    return $this->db->get_where('poll_list',$params)->result_array();
	}
	
	/**
	 * Build poll data: poll title with answers.
	 * If poll ID is not set than get random.
	 * 
	 * @param integer|bool $poll_id
	 * @return array
	 */
	public function getPollData($poll_id=false)
	{
	    if($poll_id) $data['poll'] = $this->getOneById($poll_id);
	    else $data['poll'] = $this->getRandomPoll();
	    
	    if(!$data['poll']) return FALSE;
	    
	    $data['answers'] = $this->getAnswers($data['poll']['id']);
	    return $data;
	}
	
	/**
	 * Returns random poll record.
	 * 
	 * @return array
	 */
	private function getRandomPoll()
	{
	    $this->db->order_by('RAND()');
	    $record = $this->db->get_where($this->c_table,array('active'=>1))->row_array();
	    if(!$record) return FALSE;
	    return $this->getOneById($record['id']);
	}
	
	/**
	 * Returns answers for poll.
	 * 
	 * @param integer $poll_id
	 * @return array
	 */
	public function getAnswers($poll_id)
	{
		$this->c_table = 'poll_answers';
		
		//multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect());
		$this->_buildMultilangJoin(FALSE);
		
		$records = $this->db->get_where($this->c_table,array('poll_id'=>$poll_id))->result_array();
		
		$this->c_table = 'poll_list';
		
		return $records;
	}
	
	/**
	 * Returns answer record by ID.
	 * 
	 * @param integer $id
	 * @return array
	 */
	public function getAnswerById($id)
	{
		$this->c_table = 'poll_answers';
		
		return $this->getOneById($id);
	}
	
	/**
	 * Insert or update answer. Depends if ID field is set.
	 * 
	 * @param array $post
	 * @return void
	 */
	public function insertOrUpdateAnswer($post)
	{
		$this->c_table = 'poll_answers';
		
		parent::insertOrUpdate($post);
	}
	
	/**
	 * Delete polls by IDs.
	 * 
	 * @param array $delArr
	 * @return void
	 */
	public function DeleteSelectedPoll($delArr)
	{
		if( !empty($delArr) )
		{
			foreach ($delArr as $id=>$selected)
			{
				//delete answers (with multilang data)
				$answers = $this->getAnswers($id);
				$this->c_table = 'poll_answers';
				foreach ($answers as $answer)
				{
					$this->DeleteId($answer['id']);
				}
				
				//delete stored answers for poll
				$this->db->delete('poll_store', array('poll_id' => $id));
				
				//delete poll (with multilang data)
				$this->c_table = 'poll_list';
				$this->DeleteId($id);
			}
		}
	}
	
	/**
	 * Delete answers by IDs.
	 * 
	 * @param array $delArr
	 * @return void
	 */
	public function DeleteSelectedAnswers($delArr)
	{
		if( !empty($delArr) )
		{
			$this->c_table = 'poll_answers';
		    
		    foreach ($delArr as $id=>$selected)
			{
				$this->DeleteId($id);
			}
		}
	}
	
	/**
	 * Calc how many times this answer was voted. 
	 * 
	 * @param integer $answer_id
	 * @return integer
	 */
	public function getCountForAnswer($answer_id)
	{
		return count($this->db->select('answer_id')->get_where('poll_store',array('answer_id'=>$answer_id))->result_array());
	}
	
	/**
	 * Store customer's vote in table and set "voted" in cookie. 
	 * 
	 * @param integer $poll_id
	 * @param integer $answer_id
	 * @param integer $customer_id
	 * @return integer
	 */
	public function storeAnswer($poll_id,$answer_id,$customer_id)
	{
	    $this->c_table = 'poll_store';
	    
	    $this->CI->load->library('user_agent');
	    $this->CI->load->helper('cookie');
	    
	    $cookie = array(
        	'name'   => 'voted_'.$poll_id,
            'value'  => $answer_id,
            'expire' => 3600*24*365,
            'path'   => '/',
            );
        set_cookie($cookie);
		
		parent::Insert(array('poll_id'=>$poll_id,'answer_id'=>$answer_id,'customer_id'=>$customer_id,'ip'=>$_SERVER['REMOTE_ADDR'],'browser'=>$this->CI->agent->browser(),'os'=>$this->CI->agent->platform()));
	}
	
	/**
	 * Check if customer already voted current poll. 
	 * There is 3 way to check: ID,IP,cookie.
	 * 
	 * @param integer $poll_id
	 * @param integer $customer_id
	 * @return integer
	 */
	public function isVoted($poll_id,$customer_id)
	{
        $settings = $this->CI->settings_model;
        
        $voted = FALSE;
        
        if(!$voted && $settings['poll_check_by_id'])
        {
	       if(!$customer_id) $voted = TRUE;
           else $voted = (bool)$this->db->select('id')->get_where('poll_store',array('poll_id'=>$poll_id,'customer_id'=>$customer_id))->row_array();
        }
	    
        if(!$voted && $settings['poll_check_by_ip'])
        {
	       $voted = (bool)$this->db->select('id')->get_where('poll_store',array('poll_id'=>$poll_id,'ip'=>$_SERVER['REMOTE_ADDR']))->row_array();
        }
        
        if(!$voted && $settings['poll_check_by_cookie'])
        {
	       $this->CI->load->helper('cookie');
	       $voted = (bool)get_cookie('voted_'.$poll_id, TRUE);
        }
	    
	    return $voted;
	}
	
	/**
	 * Get amount of available poll's answers. 
	 * 
	 * @param integer $poll_id
	 * @return integer
	 */
	public function getTotalPollAnswers($poll_id)
	{
	    return count($this->db->select('poll_id')->get_where('poll_answers',array('poll_id'=>$poll_id))->result_array());
	}
	
	/**
	 * Generate poll results, for each answer: amount votes, width for bar, color for bar, answer title.
	 * 
	 * @param integer $poll_id
	 * @return array
	 */
	public function getPollResults($poll_id)
	{
	    $answers = $this->getAnswers($poll_id);
	    
	    $most_popular_answer = $this->getMostPopularAnswer($poll_id);
	    $max_amount = ($most_popular_answer) ? $most_popular_answer['amount'] : 0;
	    
	    $results = array();
	    
	    foreach ($answers as $key=>$answer)
	    {
	        $results[$key]['amount'] = $this->getVotesForAnswer($answer['id']);
	        $results[$key]['width'] = ($max_amount) ? ($results[$key]['amount']/$max_amount)*100 : 0;
	        $results[$key]['color'] = $this->result_colors[$key];
	        $results[$key]['answer'] = $answers[$key]['answer'];
	    }
	    
	    return $results;
	}
	
	/**
	 * Returns most popular answer for poll.
	 * 
	 * @param integer $poll_id
	 * @return array
	 */
	private function getMostPopularAnswer($poll_id)
	{
	    $this->db->group_by('answer_id');
	    $this->db->order_by('amount','desc');
	    return $this->db->select('*, COUNT(*) AS amount')->get_where('poll_store',array('poll_id'=>$poll_id))->row_array();
	}
	
	/**
	 * Calculate amount votes for answer.
	 * 
	 * @param integer $answer_id
	 * @return integer
	 */
	private function getVotesForAnswer($answer_id)
	{
	    $this->db->group_by('answer_id');
	    $record = $this->db->select('COUNT(*) AS amount')->get_where('poll_store',array('answer_id'=>$answer_id))->row_array();
	    return intval(@$record['amount']);
	}
	
	// === Dashboard: Start === //
    /**
     * Generate widget for dashboard.
     *
     * @return string
     */
    public function dashboardWidget()
    {
    	$widget = parent::dashboardWidget();
    	
    	$widget['content'] .= "
    	<p>
    		".$this->CI->filters_model->filterAnchorByCode('active_polls',language('amount_of_active'),'poll')." - ".$this->count(array('active'=>1))."
    	</p>
    	";
    	
    	return $widget;
    }
    // === Dashboard: End === //
}