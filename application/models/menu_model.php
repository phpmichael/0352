<?php
require_once(APPPATH.'models/base_model.php');

/** 
 * This is model for website menu.
 * 
 * @package menu  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Menu_model extends Base_model
{
	//name of table
	protected $c_table = 'menu';
	
	
	/**
	 * Insert data. Returns ID field.
	 * Overloads parent method.
	 * 
	 * @param array $post
	 * @return integer
	 */
	public function Insert($post)
	{
		//set sort = last sort + 1
	    $post['sort'] = parent::last_sort_val(array('menu' => $post['menu']));

		return parent::Insert($post);
	}
	
	/**
	 * Update data.
	 * Overloads parent method.
	 * 
	 * @param array $post
	 * @return integer
	 */
	public function Update($post)
	{
		//change sort if menu changed (ie from left to bottom)
	    $current = $this->getOneById($post[$this->id_column]);
		
		if( $current['menu'] != $post['menu'] )
		{
			$post['sort'] = parent::last_sort_val(array('menu' => $post['menu']));
		}
		
		//update multilang data
		//$this->CI->lang_gen_model->updateMultilang($post['name'],$post['name_lang_id']);
		
		//update data
		parent::Update($post);
		
		//reset sort if menu changed (ie from left to bottom)
		if( $current['menu'] != $post['menu'] )
		{
            parent::reset_sort(array('menu' => $current['menu']));
		}
	}
	
	/**
	 * Delete few records by IDs array and reset sorting.
	 * Overloads parent method.
	 * 
	 * @param array $delArr
	 * @param string $menu
	 * @return void
	 */
	public function DeleteSelectedInMenu($delArr,$menu)
	{
		if( !empty($delArr) )
		{
			foreach ($delArr as $id=>$selected)
			{
				$this->DeleteId($id);
			}
		}

        parent::reset_sort(array('menu' => $menu));
	}
	
	/**
	 * Generate HTML of menu.
	 *
	 * @param string $menu
	 * @param string $format
	 * @return string
	 */
	public function build($menu='left',$format='list')
	{
	    //multilang stuff
		$this->db->select($this->c_table.'.* '.$this->_buildMultilangSelect());
		$this->_buildMultilangJoin(FALSE);

		$this->db->order_by('sort','asc');
		$menuArr = $this->db->get_where('menu', array('menu' => $menu))->result_array();

		$html = '';

		foreach ($menuArr as $val)
		{
			//if set content page
			if($val['page_id'])
			{
				$page = $this->pages_model->getOneById($val['page_id']);
				if($page['slug']!='home') $val['link'] = 'page/'.$page['slug'].$this->CI->config->item('url_suffix');
			}
			
			//generate link
			if( stristr($val['link'],'http://') ) $link = $val['link'];
			else if(!$val['link']) $link = base_url().$this->CI->_getBaseURL();
			else if($this->CI->config->item('url_suffix') && stristr($val['link'],$this->CI->config->item('url_suffix'))) $link = site_url(str_replace($this->CI->config->item('url_suffix'),"",$this->CI->_getBaseURL().$val['link']));
			else $link = site_url($this->CI->_getBaseURL().$val['link']);

			//detect active item
			$active = ($link == 'http://'.$this->input->server('HTTP_HOST').$this->input->server('REQUEST_URI')) ? "class='active'" : "";
			//$active = (stristr('http://'.$this->input->server('HTTP_HOST').$this->input->server('REQUEST_URI'),$link)) ? "class='active'" : "";
			
			//generate output
			if( $format=='separator' ) $html .= "<a {$active} href='{$link}'>{$val['name']}</a> | ";
			elseif( $format=='list' ) $html .= "<li><a {$active} href='{$link}'>{$val['name']}</a></li>\n";
			else $html .= strtr($format,array('{link}'=>$link, '{title}'=>$val['name'], '{active}'=>$active));
		}
		
		if($format=='separator') $html = substr($html,0,-3);

		return $html;
	}
	
	// === Dashboard: Start === //
    /**
     * Generate widget for dashboard.
     *
     * @return string
     */
    public function dashboardWidget()
    {
    	$content = "
    	<p>
			".anchor_base('menu/left',language('left_menu'))." - ".$this->count(array('menu'=>'left'))."
		</p>
		<p>
			".anchor_base('menu/bottom',language('bottom_menu'))." - ".$this->count(array('menu'=>'bottom'))."
		</p>
    	";
    	
    	$widget['title'] = language('menu_settings');
    	$widget['content'] = $content;
    	
    	return $widget;
    }
    // === Dashboard: End === //
	
}