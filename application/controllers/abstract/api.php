<?php
require_once(APPPATH.'libraries/REST_Controller.php');

abstract class API extends REST_Controller
{
    protected $segmentsOffset = 0;
    protected $interface_lang;
    protected $process_form_html_id;
    protected $model_name;
    protected $model;
    protected $messages = array(
        'item_not_found' => 'Item not found',
        'empty_data' => 'No data posted',
        'item_saved' => 'Item saved',
        'no_item_id' => 'No item\'s ID',
        'item_updated' => 'Item updated',
        'item_deleted' => 'Item deleted',
        'enter_email_and_password' => 'Enter email and password',
        'access_allowed' => 'Access allowed',
        'access_denied' => 'Access denied',
    );

    public function __construct()
    {
        parent::__construct();

        // === Load Models === //
        $this->load->model($this->model_name);
        $this->model = $this->{$this->model_name};
        if($this->process_form_html_id) $this->load->model('formbuilder_model');

        //set language based on URL
        $this->lang_model->setApplicationLanguage($this);
    }

    public function index_get()
    {
        if($id = $this->get('id'))
        {
            if($item = $this->model->getOneById($id))
            {
                $this->response($item, 200);
            }
            else
            {
                $this->response(array('error' => array($this->messages['item_not_found'])), 404);
            }
        }
        else
        {
            $filter_data = $this->model->getFilterData();
            $data = $this->model->get('',$filter_data);

            $this->response($data, 200);
        }
    }

    public function index_post()
    {
        $data = $_POST = $this->post();

        if(empty($data))
        {
            $this->response(array('errors' => array($this->messages['empty_data'])), 200);
        }
        elseif($id = $this->model->storeForm($data,$this->process_form_html_id))
        {
            $this->response(array('success' => array('message' => $this->messages['item_saved'], 'id' => $id)), 200);
        }
        else
        {
            $errors = explode("\n",validation_errors(' ',' '));
            array_pop($errors);//remove last empty element
            $this->response(array('errors' => $errors), 200);
        }
    }

    public function index_put()
    {
        if(!($id = $this->get('id')))
        {
            $this->response(array('errors' => array($this->messages['no_item_id'])), 404);
        }

        $data = $_POST = $this->put();

        if(empty($data))
        {
            $this->response(array('errors' => array('No data posted')), 200);
        }
        elseif($this->model->storeForm($data,$this->process_form_html_id,$id))
        {
            $this->response(array('success' => array('message' => $this->messages['item_updated'])), 200);
        }
        else
        {
            $errors = explode("\n",validation_errors(' ',' '));
            array_pop($errors);//remove last empty element
            $this->response(array('errors' => $errors), 200);
        }
    }

    public function index_delete()
    {
        if($id = $this->get('id'))
        {
            if($item = $this->model->existsId($id))
            {
                $this->model->deleteId($id);

                $this->response(array('success' => array('message' => $this->messages['item_deleted'])), 200);
            }
            else
            {
                $this->response(array('errors' => array('Not found')), 404);
            }
        }
    }

    /* Auth functions */

    public function auth_post()
    {
        $email = $this->post('email');
        $password = $this->post('password');

        if(empty($email) || empty($password))
        {
            $this->response(array('errors' => array($this->messages['enter_email_and_password'])), 200);
        }
        elseif($this->hasAccess($email,$password))
        {
            $this->response(array('success' => array('message' => $this->messages['access_allowed'])), 200);
        }
        else
        {
            $this->response(array('errors' => array($this->messages['access_denied'])), 200);
        }
    }

    protected function _perform_library_auth($email, $password)
    {
        return $this->hasAccess($email, $password);
    }

    protected function hasAccess($email, $password)
    {
        //if($this->request->method === 'get') return TRUE;

        $user = $this->customers_model->checkLogin($email,$password);
        if(!$user) return FALSE;

        $this->load->model('groups_model');
        $section = str_replace('_model','',$this->model_name);
        $panel = 'admin';
        return $this->groups_model->hasApiAccess($user,$this->request->method,$section,$panel);
    }


    //Additional methods like in  Base controller
    public function _getSegmentsOffset()
    {
        return $this->segmentsOffset;
    }

    public function _isJustCurrentLang()
    {
        return TRUE;
    }

    public function _getFolder()
    {
        return 'api/';
    }

    /**
     * Set interface language.
     *
     * @param string $lang
     */
    public function setInterfaceLang($lang)
    {
        $this->interface_lang = $lang;
    }

    /**
     * Return interface language.
     *
     * @param bool $getDefault
     * @return string
     */
    public function _getInterfaceLang($getDefault=FALSE)
    {
        $lang = $this->interface_lang;
        if(!$lang && $getDefault)
        {
            return strtolower($this->lang_model->getDefaultLangCode());
        }
        return $lang;
    }

    /**
     * Increment segment offset
     */
    public function incSegmentsOffset()
    {
        $this->segmentsOffset++;
    }
}