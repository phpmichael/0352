<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for comments.
 * 
 * @package comments  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Comments_model extends Base_model
{
	//name of table
	protected $c_table = 'comments';
	
    /**
	 * Returns list of comments for post (comment).
	 * 
	 * @param string $table ie pages, photos, news
	 * @param integer $post_id
	 * @param integer $parent_id for comments on comment
	 * @return array
	 */
	 public function getList($table,$post_id,$parent_id=0)
    {
    	$this->db->order_by('comment_date');
    	$list = $this->db->get_where($this->c_table,array('`table`'=>$table,'post_id'=>$post_id,'parent_id'=>$parent_id))->result_array();
    	
    	//add ratings
    	$ratings_model = load_model('ratings_model');
    	foreach ($list as &$item)
    	{
    	    $item['rating'] = $ratings_model->getRating($this->c_table,$item['id']);
    	    $item['already_rated'] = $ratings_model->alreadyRated($this->c_table,$item['id']);
    	}
    	return $list;
    }
    
    /**
     * Add comment. 
     * 
     * @param array $data
     * @return integer comment ID
     */
    public function add(array $data)
    {
    	//prepare data
		$data['comment_content'] = $this->censor(strip_tags($data['comment_content'],'<b><strong><a><cite><i><small>'));
		$data['comment_author_ip'] = $_SERVER['REMOTE_ADDR'];
		$data['customer_id'] = $this->CI->session->userdata('customer_id');
		$data['comment_approved'] = (@$this->CI->settings_model['automatic_approve_comments'])?1:0;
    	
    	return parent::Insert($data);
    }
    
    /**
     * Replace censored words.
     *
     * @param string $text
     * @return string
     */
    private function censor($text)
    {
        $censor_words = @$this->CI->settings_model['comments_censor_list'];
        
        $censor_words = explode("\n",$censor_words);
        
        foreach ($censor_words as $censor_word)
        {
            $text = preg_replace("/\b".preg_quote(trim($censor_word))."\b/Ui","[censored]",$text);
        }
        
        return $text;
    }

    /**
     * Edit comment.
     *
     * @param array $data
     * @param $id
     * @return void
     */
    public function edit(array $data, $id)
    {
       $data['comment_content'] = $this->censor(strip_tags($data['comment_content'],'<b><strong><a><cite><i><small>'));
       $data['id'] = $id;
        
       parent::Update($data);
    }
      
    /**
     * Returns comments tree: comments on post and comments on comments.
     *
     * @param string $table
     * @param integer $post_id
     * @param integer $parent_id
     * @return array
     */
    public function getTree($table,$post_id,$parent_id=0)
    {
    	$comments = $this->getList($table,$post_id,$parent_id);
    	
    	foreach ($comments as &$comment)
    	{
    		$comment['children'] = $this->getTree($table,$post_id,$comment['id']);
    	}
    	
    	return $comments;
    }
    
    /**
     * Return count of comments for post.
     *
     * @param string $table
     * @param integer $post_id
     * @return integer
     */
    public function getCount($table,$post_id)
    {
        $result = $this->db->select('COUNT(*) AS amount')->get_where($this->c_table,array('table'=>$table,'post_id'=>$post_id))->row_array();
        return $result['amount'];
    }
    
    /**
	 * Delete comments for post (with its ratings).
	 * 
	 * @param string $table
	 * @param integer $post_id
	 * @return void
	 */
	public function deletePostComments($table, $post_id)
	{
		if(intval($post_id)) 
		{
		    $records = $this->db->get_where($this->c_table,array('`table`'=>$table,'post_id'=>$post_id))->result_array();
		    foreach ($records as $record)
		    {
		        $this->DeleteId($record['id']);
		    }
		}
	}
	
	/**
	 * Delete comment (with ratings for it) by ID.
	 * 
	 * @param integer $id
	 * @return void
	 */
    public function DeleteId($id)
    {
    	//delete post ratings
    	$ratings_model = load_model('ratings_model');
    	$ratings_model->deletePostRatings($this->c_table,$id);
    	
    	//delete post
    	parent::DeleteId($id);
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
    	
    	$tables = array('articles','news','products');
    	
    	foreach ($tables as $table)
    	{
    		if(isCommentsAllowed($table))
    		{
    			$widget['content'] .= "
		    	<p>
		    		".$this->CI->filters_model->filterAnchorByCode('comments_for_'.$table,language('for_'.$table),'comments')." - ".$this->count(array('table'=>$table))."
		    	</p>
		    	";
    		}
    	}
    	
    	return $widget;
    }
    // === Dashboard: End === //
}