<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for form builder.
 * 
 * @package formbuilder  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 * @property Formbuilder_model $model
 */
class Formbuilder extends Admin 
{
	//name of table
	protected $c_table = 'forms';
	
	//what model used
	protected $model_name = 'formbuilder_model';

    /**
     * Init models, set pages' titles, fields' titles, set languages' sections.
     *
     * @return \Formbuilder
     */
	public function __construct()
	{
		parent::__construct();
		
		// === Load Models === //
		$this->load->model($this->model_name);
		$this->model = $this->{$this->model_name};
		
		// === Load Helpers === //
		$this->load->helper('formbuilder');
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin','formbuilder'));
		
		// === Labels === //
		$this->fields_titles['html_id'] = "HTML id";
		$this->fields_titles['store_in_table'] = language('store_in_table');
		$this->fields_titles['action'] = 'Action';
		$this->fields_titles['method'] = language('method');
		$this->fields_titles['multipart'] = 'Multipart';
		$this->fields_titles['label'] = language('label');
		
		$this->fields_titles['type'] = language('type');
		$this->fields_titles['template'] = language('template');
		$this->fields_titles['columns'] = language('columns');
		$this->fields_titles['hide_label'] = language('hide_label');
		$this->fields_titles['html_class'] = 'HTML class';
		$this->fields_titles['skip_rule'] = 'Skip rule';
		
		$this->fields_titles['name'] = language('thing_name');
		$this->fields_titles['default_value'] = language('default_value');
		$this->fields_titles['special_value'] = language('special_value');
		$this->fields_titles['validation'] = language('validation');
		$this->fields_titles['show_on_list'] = language('show_on_list');
		$this->fields_titles['align'] = language('align');
		$this->fields_titles['hint'] = language('hint');
		$this->fields_titles['height'] = language('height');
		$this->fields_titles['width'] = language('width');
		$this->fields_titles['label_position'] = language('label_position');
		$this->fields_titles['label_align'] = language('label_align');
		$this->fields_titles['label_width'] = language('label_width');
		$this->fields_titles['parent_id'] = language('parent_id');
		$this->fields_titles['sort'] = language('sort');
		$this->fields_titles['image_small_height'] = language('height').'(Small image)';
		$this->fields_titles['image_small_width'] = language('width').'(Small image)';
		$this->fields_titles['image_small_crop'] = 'Crop (Small image)';
		$this->fields_titles['image_medium_height'] = language('height').'(Medium image)';
		$this->fields_titles['image_medium_width'] = language('width').'(Medium image)';
		$this->fields_titles['image_medium_crop'] = 'Crop (Medium image)';
		$this->fields_titles['image_big_height'] = language('height').'(Big image)';
		$this->fields_titles['image_big_width'] = language('width').'(Big image)';
		$this->fields_titles['image_big_crop'] = 'Crop (Big image)';
		
		$this->fields_titles['content'] = language('content');
		
		$this->fields_titles['generic_answers'] = "Generic Answers";
		
		// === Page Titles === //
		$this->page_titles['index'] = 'Form Builder';
		
		$this->page_titles['add'] = 'Add Form';
		$this->page_titles['edit'] = 'Edit Form';
		
		$this->page_titles['containers_add'] = 'Add Container';
		$this->page_titles['containers_edit'] = 'Edit Container';
		
		$this->page_titles['inputs_add'] = 'Add Input';
		$this->page_titles['inputs_edit'] = 'Edit Input';
		
		$this->page_titles['answersets_add'] = 'Add Answerset';
		$this->page_titles['answersets_edit'] = 'Edit Answerset';
		
		$this->page_titles['answersets_values_add'] = 'Add Answerset Value';
		$this->page_titles['answersets_values_edit'] = 'Edit Answerset Value';
		
		//default page title
		$this->_setDefaultPageTitle();
	}
	

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	/**
	 * Build right top admin menu.
	 * Overrides parent method.
	 * 
	 * @return string
	 */
	public function _built_right_menu()
	{
		return "";
	}
	
	/**
	 * Validate and insert or update form.
	 * 
	 * @param array $record
	 * @return void
	 */
	protected function _processInsertForm(array $record=array())
	{
		$this->_CheckLogged(FALSE);
		
		$id = intval(@$record['id']);
	    
	    $this->load->library('form_validation');
		
		$configValidation = array( 
		      array(
                     'field'   => 'html_id', 
                     'label'   => parent::_getFieldTitle('html_id'), 
                     'rules'   => 'trim|required|max_length[50]|callback__unique_field_for_edit[html_id,'.$id.']|xss_clean'
                  ),
              array(
                     'field'   => 'store_in_table', 
                     'label'   => parent::_getFieldTitle('html_id'), 
                     'rules'   => 'trim|max_length[50]|alphanum'
                  ),
              array(
                     'field'   => 'action', 
                     'label'   => parent::_getFieldTitle('action'), 
                     'rules'   => 'trim|xss_clean'
                  ),
              array(
                     'field'   => 'method', 
                     'label'   => parent::_getFieldTitle('method'), 
                     'rules'   => 'required|xss_clean'
                  ),
              array(
                     'field'   => 'multipart', 
                     'label'   => parent::_getFieldTitle('multipart'), 
                     'rules'   => 'required|xss_clean'
                  )
            );
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "label[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('label')." ({$lang_code})", 
                     'rules'   => 'trim|required|min_length[3]|max_length[255]|xss_clean'
                  );
        }

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() !== FALSE)
		{
			$post = array_merge($record,$this->input->post());
			
			$id = $this->model->insertOrUpdateForm($post);
			
			//redirect($this->_getBaseURI().'/edit/'.$id);
			
			$response['item_type'] = 'form';
			$response['item_url'] = site_url($this->_getBaseURI().'/forms_edit/'.$id);
			$response['item_title'] = $post['label'][strtoupper($this->_getInterfaceLang(TRUE))];
			$response['item_id'] = $id;
			$response['success'] = '<p>'.language('successfully_saved').'</p>';
			
			die(json_encode($response));
		}
		else 
		{
			$response['errors'] = validation_errors();
			
			if( $response['errors'] ) //if validation unsuccess
			{
				die(json_encode($response));
			}
			else //if just page load 
			{
				$this->notCacheHeaders();
		
				$record['tpl_page'] = $this->_getController().'/forms_add';
				$this->layout = 'blank';
			    parent::_OnOutput($record);
			}
		}
	}
	
	/**
	 * Validate and insert or update container.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsertContainer(array $record=array())
	{
	    $this->_CheckLogged(FALSE);
	    
	    $this->load->library('form_validation');
		
		
		$configValidation = array( 
		      array(
                     'field'   => 'html_id', 
                     'label'   => parent::_getFieldTitle('html_id'), 
                     'rules'   => 'trim|max_length[100]||xss_clean'
                  ),
               array(
                     'field'   => 'type', 
                     'label'   => parent::_getFieldTitle('type'), 
                     'rules'   => 'required|alphanum'
                  ),
              array(
                     'field'   => 'template', 
                     'label'   => parent::_getFieldTitle('template'), 
                     'rules'   => 'required|xss_clean'
                  ),
              array(
                     'field'   => 'columns', 
                     'label'   => parent::_getFieldTitle('columns'), 
                     'rules'   => 'required|natural'
                  ),
              array(
                     'field'   => 'hide_label', 
                     'label'   => parent::_getFieldTitle('hide_label'), 
                     'rules'   => 'required|alphanum'
                  ),
              array(
                     'field'   => 'html_class', 
                     'label'   => parent::_getFieldTitle('hide_label'), 
                     'rules'   => 'trim|max_length[100]|xss_clean'
                  ),
              array(
                     'field'   => 'skip_rule', 
                     'label'   => parent::_getFieldTitle('skip_rule'), 
                     'rules'   => 'trim|max_length[100]|xss_clean'
                  )
            );
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "label[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('label')." ({$lang_code})", 
                     'rules'   => 'trim|required|min_length[3]|max_length[100]|xss_clean'
                  );
        }

		$this->form_validation->set_rules($configValidation);
		
		if ($this->form_validation->run() !== FALSE)
		{
			$post = array_merge($record,$this->input->post());
			
			$id = $this->model->insertOrUpdateContainer($post);
			
			//redirect($this->_getBaseURI().'/containers_edit/'.$post['form_id'].'/'.$post['container_id'].'/'.$id);
			
			$response['item_type'] = 'container';
			$response['item_url'] = site_url($this->_getBaseURI().'/containers_edit/'.$post['form_id'].'/'.$post['container_id'].'/'.$id);
			$response['item_title'] = $post['label'][strtoupper($this->_getInterfaceLang(TRUE))];
			$response['item_id'] = $id;
			$response['success'] = '<p>'.language('successfully_saved').'</p>';
			
			die(json_encode($response));
		}
		else 
		{
			$response['errors'] = validation_errors();
			
			if( $response['errors'] ) //if validation unsuccess
			{
				die(json_encode($response));
			}
			else //if just page load 
			{
				$this->notCacheHeaders();
		
				$record['tpl_page'] = $this->_getController().'/containers_add';
				$this->layout = 'blank';
			    parent::_OnOutput($record);
			}
		}
	}
	
	/**
	 * Validate and insert or update input.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsertInput(array $record=array())
	{
	    $this->_CheckLogged(FALSE);
	    
	    $this->load->library('form_validation');
		
		
		$configValidation = array( 
		      array(
                     'field'   => 'name', 
                     'label'   => parent::_getFieldTitle('name'), 
                     'rules'   => 'trim|max_length[100]|alphanum'
                  ),
		      array(
                     'field'   => 'html_id', 
                     'label'   => parent::_getFieldTitle('html_id'), 
                     'rules'   => 'trim|max_length[100]||xss_clean'
                  ),
               array(
                     'field'   => 'type', 
                     'label'   => parent::_getFieldTitle('type'), 
                     'rules'   => 'required|alphanum'
                  ),
              array(
                     'field'   => 'value', 
                     'label'   => parent::_getFieldTitle('default_value'), 
                     'rules'   => 'trim|xss_clean'
                  ),
              array(
                     'field'   => 'validation', 
                     'label'   => parent::_getFieldTitle('validation'), 
                     'rules'   => 'trim|xss_clean'
                  ),
              array(
                     'field'   => 'show_on_list', 
                     'label'   => parent::_getFieldTitle('show_on_list'), 
                     'rules'   => 'required|alpha'
                  ),
              array(
                     'field'   => 'align', 
                     'label'   => parent::_getFieldTitle('align'), 
                     'rules'   => 'required|alpha'
                  ),
              array(
                     'field'   => 'hint', 
                     'label'   => parent::_getFieldTitle('hint'), 
                     'rules'   => 'max_length[255]|xss_clean'
                  ),
              array(
                     'field'   => 'height', 
                     'label'   => parent::_getFieldTitle('height'), 
                     'rules'   => 'trim|natural'
                  ),
              array(
                     'field'   => 'width', 
                     'label'   => parent::_getFieldTitle('width'), 
                     'rules'   => 'trim|natural'
                  ),
              array(
                     'field'   => 'label_position', 
                     'label'   => parent::_getFieldTitle('label_position'), 
                     'rules'   => 'trim|alphanum'
                  ),
              array(
                     'field'   => 'hide_label', 
                     'label'   => parent::_getFieldTitle('hide_label'), 
                     'rules'   => 'required|alphanum'
                  ),
              array(
                     'field'   => 'html_class', 
                     'label'   => parent::_getFieldTitle('hide_label'), 
                     'rules'   => 'trim|max_length[100]|xss_clean'
                  ),
              array(
                     'field'   => 'skip_rule', 
                     'label'   => parent::_getFieldTitle('skip_rule'), 
                     'rules'   => 'trim|max_length[100]|xss_clean'
                  ),
              array(
                     'field'   => 'image_small_height', 
                     'label'   => parent::_getFieldTitle('image_small_height'), 
                     'rules'   => 'trim|natural'
                  ),
              array(
                     'field'   => 'image_small_width', 
                     'label'   => parent::_getFieldTitle('image_small_width'), 
                     'rules'   => 'trim|natural'
                  ),
              array(
                     'field'   => 'image_medium_height', 
                     'label'   => parent::_getFieldTitle('image_small_height'), 
                     'rules'   => 'trim|natural'
                  ),
              array(
                     'field'   => 'image_medium_width', 
                     'label'   => parent::_getFieldTitle('image_small_width'), 
                     'rules'   => 'trim|natural'
                  ),
              array(
                     'field'   => 'image_big_height', 
                     'label'   => parent::_getFieldTitle('image_small_height'), 
                     'rules'   => 'trim|natural'
                  ),
              array(
                     'field'   => 'image_big_width', 
                     'label'   => parent::_getFieldTitle('image_small_width'), 
                     'rules'   => 'trim|natural'
                  )
            );
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "label[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('label')." ({$lang_code})", 
                     'rules'   => 'trim|required|min_length[3]|max_length[255]|xss_clean'
                  );
        }

		$this->form_validation->set_rules($configValidation);
			
		if ($this->form_validation->run() !== FALSE)
		{
			$post = array_merge($record,$this->input->post());
			
			//if type is not content than no need to store content in lang_gen, leave content_lang_id=0
			if($post['type']!='content') unset($post['content']);
			
			$id = $this->model->insertOrUpdateInput($post);
			
			//redirect($this->_getBaseURI().'/inputs_edit/'.$post['form_id'].'/'.$post['container_id'].'/'.$id);
			
			$response['item_type'] = 'input';
			$response['item_url'] = site_url($this->_getBaseURI().'/inputs_edit/'.$post['form_id'].'/'.$post['container_id'].'/'.$id);
			$response['item_title'] = $post['label'][strtoupper($this->_getInterfaceLang(TRUE))];
			$response['item_id'] = $id;
			$response['success'] = '<p>'.language('successfully_saved').'</p>';
			
			die(json_encode($response));
		}
		else 
		{
			$response['errors'] = validation_errors();
			
			if( $response['errors'] ) //if validation unsuccess
			{
				die(json_encode($response));
			}
			else //if just page load 
			{
				$this->notCacheHeaders();
		
				$record['tpl_page'] = $this->_getController().'/inputs_add';
				$this->layout = 'blank';
			    parent::_OnOutput($record);
			}
		}
	}
	
	
	/**
	 * Validate and insert or update answerset.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsertAnswerset(array $record=array())
	{
	    $this->_CheckLogged(FALSE);
	    
	    $this->load->library('form_validation');
		
		$configValidation = array();
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "label[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('label')." ({$lang_code})", 
                     'rules'   => 'trim|required|min_length[3]|max_length[255]|xss_clean'
                  );
        }

		$this->form_validation->set_rules($configValidation);
		
		if ($this->form_validation->run() !== FALSE)
		{
			$post = array_merge($record,$this->input->post());
			
			$id = $this->model->insertOrUpdateAnswerset($post);
			
			$response['item_type'] = 'answerset';
			$response['item_url'] = site_url($this->_getBaseURI().'/answersets_edit/'.$id);
			$response['item_title'] = $post['label'][strtoupper($this->_getInterfaceLang(TRUE))];
			$response['item_id'] = $id;
			$response['success'] = '<p>'.language('successfully_saved').'</p>';
			
			die(json_encode($response));
		}
		else 
		{
			$response['errors'] = validation_errors();
			
			if( $response['errors'] ) //if validation unsuccess
			{
				die(json_encode($response));
			}
			else //if just page load 
			{
				$this->notCacheHeaders();
		
				$record['tpl_page'] = $this->_getController().'/answersets_add';
				$this->layout = 'blank';
			    parent::_OnOutput($record);
			}
		}
	}
	
	/**
	 * Validate and insert or update answerset value.
	 * 
	 * @param array $record
	 * @return void
	 */
	private function _processInsertAnswersetValue(array $record=array())
	{
	    $this->_CheckLogged(FALSE);
	    
	    $this->load->library('form_validation');
		
		$configValidation = array( 
		      array(
                     'field'   => 'value', 
                     'label'   => parent::_getFieldTitle('special_value'), 
                     'rules'   => 'trim|max_length[255]|xss_clean'
                  )
		      );
            
        foreach (get_multilang_codes() as $lang_code)
        {
            $configValidation[] = array(
                     'field'   => "label[{$lang_code}]", 
                     'label'   => parent::_getFieldTitle('label')." ({$lang_code})", 
                     'rules'   => 'trim|required|max_length[255]|xss_clean'
                  );
        }

		$this->form_validation->set_rules($configValidation);
		
		if ($this->form_validation->run() !== FALSE)
		{
			$post = array_merge($record,$this->input->post());
			
			$id = $this->model->insertOrUpdateAnswersetValue($post);
			
			$response['item_type'] = 'answersets_value';
			$response['item_url'] = site_url($this->_getBaseURI().'/answersets_values_edit/'.$post['answerset_id'].'/'.$id);
			$response['item_title'] = $post['label'][strtoupper($this->_getInterfaceLang(TRUE))];
			$response['item_id'] = $id;
			$response['success'] = '<p>'.language('successfully_saved').'</p>';
			
			die(json_encode($response));
		}
		else 
		{
			$response['errors'] = validation_errors();
			
			if( $response['errors'] ) //if validation unsuccess
			{
				die(json_encode($response));
			}
			else //if just page load 
			{
				$this->notCacheHeaders();
		
				$record['tpl_page'] = $this->_getController().'/answersets_values_add';
				$this->layout = 'blank';
			    parent::_OnOutput($record);
			}
		}
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Show formbuilder.
	 *
	 * @param integer $form_id
	 */
	public function Index($form_id=0)
	{
		$this->_CheckLogged();
		
		$data['form_id'] = $form_id;
	    parent::_OnOutput($data);
	}
	
	/**
	 * Add form.
	 * 
	 * @return void
	 */
	public function Forms_Add()
	{
		$this->_processInsertForm();
	}
	
	/**
	 * Edit form by $form_id.
	 * 
	 * @param integer $form_id
	 * @return void
	 */
	public function Forms_Edit($form_id)
	{
		// === GET RECORD === //
		$record = $this->model->getFormById($form_id);
		
		$this->_processInsertForm($record);
	}
	
	/**
	 * Show form's containers.
	 *
	 * @param integer $form_id
	 * @param integer $container_id
	 * @return void
	 */
	/*public function Containers_List($form_id,$container_id)
	{
		$this->c_table = 'form_containers';
	    
	    $data = parent::_ListData($this->_getPageTitle($this->method), 9999, "form_id = ".intval($form_id)." AND container_id = ".intval($container_id), "", $form_id."/","id","asc");

		$data['tpl_page'] = $this->_getController().'/containers_list';
		parent::_OnOutput($data);
	}*/
	
	/**
	 * Add container.
	 * 
	 * @param integer $form_id
	 * @param integer $container_id
	 * @return void
	 */
	public function Containers_Add($form_id,$container_id)
	{
		$record['form_id'] = $form_id;
		$record['container_id'] = $container_id;
		$this->_processInsertContainer($record);
	}
	
	/**
	 * Edit container by $id.
	 * 
	 * @param integer $form_id
	 * @param integer $container_id parent container
	 * @param integer $id
	 * @return void
	 */
	public function Containers_Edit($form_id,$container_id,$id)
	{
	    // === GET RECORD === //
		$record = $this->model->getContainerById($id);
		$record['form_id'] = $form_id;
		$record['container_id'] = $container_id;
		
		$this->_processInsertContainer($record);
	}
	
	
	/**
	 * Show container's inputs.
	 *
	 * @param integer $form_id
	 * @param integer $container_id
	 * @return void
	 */
	/*public function Inputs_List($form_id,$container_id)
	{
		$this->c_table = 'form_inputs';
	    
	    $data = parent::_ListData($this->_getPageTitle($this->method), 9999, "container_id = ".intval($container_id), "", $form_id."/","id","asc");

		$data['tpl_page'] = $this->_getController().'/inputs_list';
		parent::_OnOutput($data);
	}*/
	
	/**
	 * Add input.
	 * 
	 * @param integer $form_id
	 * @param integer $container_id
	 * @return void
	 */
	public function Inputs_Add($form_id,$container_id)
	{
		$record['form_id'] = $form_id;
		$record['container_id'] = $container_id;
		$this->_processInsertInput($record);
	}
	
	/**
	 * Edit input by $input_id.
	 * 
	 * @param integer $form_id
	 * @param integer $container_id
	 * @param integer $input_id
	 * @return void
	 */
	public function Inputs_Edit($form_id,$container_id,$input_id)
	{
		// === GET RECORD === //
		$record = $this->model->getInputById($input_id);
		$record['form_id'] = $form_id;
		$record['container_id'] = $container_id;
		
		$this->_processInsertInput($record);
	}
	
	/**
	 * Remove form by $form_id;
	 *
	 * @param integer $form_id
	 * @return void
	 */
	public function Forms_Remove($form_id)
	{
		$this->_CheckLogged(FALSE);
		
		$this->model->DeleteFormById($form_id);
	}
	
	/**
	 * Remove container by $container_id;
	 *
	 * @param integer $container_id
	 * @return void
	 */
	public function Containers_Remove($container_id)
	{
		$this->_CheckLogged(FALSE);
		
		$this->model->DeleteContainerById($container_id);
	}
	
	/**
	 * Remove input by $input_id;
	 *
	 * @param integer $input_id
	 * @return void
	 */
	public function Inputs_Remove($input_id)
	{
		$this->_CheckLogged(FALSE);
		
		$this->model->DeleteInputById($input_id);
	}
	
	/**
	 * Copy containers and inputs.
	 *
	 */
	public function Copy_Form_Item()
	{
		$this->_CheckLogged(FALSE);
		
		$copy_id = $this->model->copyFormItem(
			$this->input->post('item_type'),
			$this->input->post('item_id'),
			$this->input->post('form_id'),
			$this->input->post('container_id')
		);
		
		if($copy_id) die(json_encode(array('status'=>200,'copy_id'=>$copy_id)));
	}
	
	/**
	 * Move containers and inputs.
	 *
	 */
	public function Move_Form_Item()
	{
		$this->_CheckLogged(FALSE);
		
		$moved = $this->model->moveFormItem(
			$this->input->post('item_type'),
			$this->input->post('item_id'),
			$this->input->post('form_id'),
			$this->input->post('ref_type'),
			$this->input->post('ref_id'),
			$this->input->post('move_type')
		);
		
		if($moved) die(json_encode(array('status'=>200)));
	}
	
	/// ==== Answersets Stuff: Start === ///
	
	/**
	 * Add answerset.
	 * 
	 * @return void
	 */
	public function Answersets_Add()
	{
		$this->_processInsertAnswerset();
	}
	
	/**
	 * Edit answerset by $answerset_id.
	 * 
	 * @param integer $answerset_id
	 * @return void
	 */
	public function Answersets_Edit($answerset_id)
	{
		// === GET RECORD === //
		$record = $this->model->getAnswersetById($answerset_id);
		
		$this->_processInsertAnswerset($record);
	}
	
	/**
	 * Add answerset value.
	 * 
	 * @param integer $answerset_id
	 * @return void
	 */
	public function Answersets_Values_Add($answerset_id)
	{
		$record['answerset_id'] = $answerset_id;
		$this->_processInsertAnswersetValue($record);
	}
	
	/**
	 * Edit answerset value by $answerset_value_id.
	 * 
	 * @param integer $answerset_id
	 * @param integer $answerset_value_id
	 * @return void
	 */
	public function Answersets_Values_Edit($answerset_id,$answerset_value_id)
	{
		// === GET RECORD === //
		$record = $this->model->getAnswersetValueById($answerset_value_id);
		$record['answerset_id'] = $answerset_id;
		$record['answerset_value_id'] = $answerset_value_id;
		
		$this->_processInsertAnswersetValue($record);
	}
	
	/**
	 * Remove answersets by $answersets_id;
	 *
	 * @param integer $answersets_id
	 * @return void
	 */
	public function Answersets_Remove($answersets_id)
	{
		$this->_CheckLogged(FALSE);
		
		$this->model->DeleteAnswersetById($answersets_id);
	}
	
	/**
	 * Remove answerset value by $answerset_value_id;
	 *
	 * @param integer $answerset_value_id
	 * @return void
	 */
	public function Answersets_Values_Remove($answerset_value_id)
	{
		$this->_CheckLogged(FALSE);
		
		$this->model->DeleteAnswersetValueById($answerset_value_id);
	}
	
	/**
	 * Attach answerset to select,radio or checkbox.
	 *
	 * @param integer $answerset_id
	 * @param integer $input_id
	 * @return void
	 */
	public function Attach_Answerset($answerset_id,$input_id)
	{
	    $this->_CheckLogged(FALSE);
	    
	    $this->model->AttachAnswersetToInput($answerset_id,$input_id);
	}
	
	/**
	 * Detach answerset from select,radio or checkbox.
	 *
	 * @param integer $input_id
	 */
	public function Detach_Answerset($input_id)
	{
	    $this->_CheckLogged(FALSE);
	    
	    $this->model->DetachAnswersetFromInput($input_id);
	}
	
	/**
	 * Move answers.
	 *
	 */
	public function Move_Answerset_Value()
	{
		$this->_CheckLogged(FALSE);
		
		$moved = $this->model->moveAnswersetValue(
			$this->input->post('answer_id'),
			$this->input->post('answerset_id'),
			$this->input->post('ref_type'),
			$this->input->post('subling_id'),
			$this->input->post('move_type')
		);
		
		if($moved) die(json_encode(array('status'=>200)));
	}
	
	/// ==== Answersets Stuff: End === ///
	
	/// ==== Build Form Stuff: Start === ///
	
	/**
	 * Preview form.
	 *
	 * @param integer $form_id
	 */
	public function Preview_Form($form_id)
	{
		$this->_CheckLogged(FALSE);
		
		$this->notCacheHeaders();
	    
	    load_theme_view('formbuilder/preview',array('form_id'=>$form_id));
	}
	
	/**
	 * Remove stored image.
	 *
	 * @param integer $form_id
	 * @param string $file_field
	 * @param string(16) $data_key
	 */
	public function Remove_File($form_id,$file_field,$data_key)
	{
		$this->_CheckLogged(FALSE);
	    
	    $this->model->removeFile($form_id,$file_field,$data_key);
	}
	
	/**
	 * Create table for saving form data.
	 *
	 * @param integer $form_id
	 */
	public function Create_Table($form_id)
	{
		$this->_CheckLogged();
		
		$this->model->createTable($form_id);
		
		echo "Table created.";
	}
	
	/**
	 * Export form to another database.
	 *
	 * @param integer $form_id
	 * @param string $dbname
	 */
	public function Export_Form($form_id,$dbname)
	{
		$this->_CheckLogged();
		
		$this->model->exportFormToDb($form_id,$dbname);
		
		echo "Form exported to database '{$dbname}'.";
	}
	
	/**
	 * Export form to file "./[FORM_ID].form".
	 *
	 * @param integer $form_id
	 */
	public function Export_Form_To_File($form_id)
	{
		$this->_CheckLogged();
		
		$this->model->exportFormToFile($form_id);
		
		echo "Form exported to file.";
	}
	
	/**
	 * Import form from file "./[FORM_ID].form".
	 *
	 * @param integer $form_id
	 */
	public function Import_Form_From_File($form_id)
	{
		$this->_CheckLogged();
		
		$this->model->importFormFromFile($form_id);
		
		echo "Form imported from file.";
	}

}