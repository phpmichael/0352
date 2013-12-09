<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for tags. It used for photos, news, articles etc.
 * 
 * @package tags  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Tags_model extends Base_model 
{
	//name of table
	protected $c_table = 'tags';
	//name of primary field
	protected $id_column = 'tag_id';
	
	// === General === //

	/**
	 * Get array of tags for post.
	 * 
	 * @param string $table
	 * @param integer $post_id
	 * @return array
	 */
	public function getPostTags($table,$post_id)
	{
		return $this->db->get_where($this->c_table, array('`table`' => $table,'post_id' => $post_id))->result_array();
	}

	/**
	 * Get string of tags for post.
	 * 
	 * @param string $table
	 * @param integer $post_id
	 * @return string
	 */
	public function getPostTagsStr($table,$post_id)
	{
		$arr = $this->getPostTags($table,$post_id);

		$tags = array();
		
		foreach ($arr as $tag)
		{
			$tags[] = $tag['tag'];
		}

		return join(", ",$tags);
	}

	// === FrontEnd === //

	/**
	 * Generates tags cloud. Font of tag depends from its count in table.
	 * 
	 * @param string $table
	 * @param integer $count_tags
	 * @param integer $min_font_size
	 * @param integer $max_font_size
	 * @return string
	 */
	public function generateTagCloud($table, $count_tags = 15,$min_font_size = 10,$max_font_size = 18)
	{
	    $table = $this->db->escape_str($table);
		$count_tags = intval($count_tags);
	    
	    $font_sizes = range($min_font_size,$max_font_size);
		$tag_cloud = "";

		$arr = $result = $this->db->query("SELECT *, COUNT(*) AS amount FROM `{$this->c_table}` WHERE `table` = '{$table}' GROUP BY tag ORDER BY RAND() LIMIT $count_tags")->result_array();

		uasort($result,"sorttags");

		$first = reset($result);
		$min_val = $first['amount'];
		$result = array_reverse($result);
		$last = reset($result);
		$max_val = $last['amount'];

		$i=0;
		foreach ($arr as $key=>$val)
		{
			$i++;
			
			//Calc tags' font sizes
			if( $val['amount']==$min_val ) $arr[$key]['font_size'] = $min_font_size;
			elseif( $val['amount']==$max_val ) $arr[$key]['font_size'] = $max_font_size;
			else 
			{
				$d = round($last['amount']/$val['amount']);
				$s = round(($max_font_size-$min_font_size)/$d);
				$arr[$key]['font_size'] = min($font_sizes[$s],$max_font_size);
			}

			//build tag cloud
			$tag = $val['tag'];
			$font_size = $arr[$key]['font_size'];
			
			if($i%2) $class ="odd";
			else $class = "";
			
			$tag_cloud .= anchor($this->CI->_getBaseURL().$table.'/tag/'.urlencode($tag),$tag," style='font-size:{$font_size}px;' class='{$class}'")." ";
		}

		return $tag_cloud;
	}

	// === BackEnd === //
	
	/**
	 * Delete tags for post.
	 * 
	 * @param string $table
	 * @param integer $post_id
	 * @return void
	 */
	public function deletePostTags($table, $post_id)
	{
		if(intval($post_id)) $this->db->delete($this->c_table, array('`table`' => $table, 'post_id' => $post_id));
	}
	
	/**
	 * Add tags (separated by comma) to table.
	 * Overloads parent method.
	 * 
	 * @param string $table
	 * @param integer $post_id
	 * @param string $tags
	 * @return string
	 */
	public function Insert($table,$post_id,$tags)
	{
	    $tags = explode(",",$tags);

		foreach ($tags as $tag)
		{
			$tag = trim($tag);
			
			//if empty tag
			if(!$tag) continue;

			// === Check if tag exist === //
			$tag_exists = $this->db->get_where($this->c_table, array('`table`' => $table,'tag' => $tag, 'post_id' => $post_id))->result_array();
			if(!empty($tag_exists)) continue;

			// === Add Tags === //
			$post['table'] = $table;
			$post['post_id'] = $post_id;
			$post['tag'] = $tag;

			// === Add to DB === //
			parent::Insert($post);
		}
	}
}