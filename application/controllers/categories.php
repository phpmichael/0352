<?php
require_once(APPPATH.'controllers/abstract/base.php');

/** 
 * This is controller for categories.
 * 
 * @package messageboard  
 * @author Michael Kovalskiy
 * @version 2011
 * @access public
 */
class Categories extends Base  
{
	// +++++++++++++ INNER METHODS +++++++++++++++ //


	// +++++++++++++ INNER METHODS +++++++++++++++ //

	// ============= ACTION METHODS ================ //

    /**
     * Returns children categories in JSON format.
     *
     * @param int $parent_id
     * @param string $categories_model
     * @return string
     */
	public function Get($parent_id=0,$categories_model='categories')
	{
		// === Init Language Section === //
		$this->lang_model->init(array('label'));
		
		// === Load Models === //
		$model = $categories_model.'_model';
		$this->load->model($model);
	    
	    $categories = array();
		
		if($parent_id>=0)
		{
			$result = $this->$model->GetChildren($parent_id);
			
			if(!empty($result))
			{
				$categories[] = array('category_id'=>-1,'category'=>language('choose')."...");
				foreach ($result as $key=>$val)
				{
					$categories[] = array('category_id'=>$key,'category'=>$val);
				}
			}
		}
		
		echo json_encode($categories);
	}
}