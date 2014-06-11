<?php
require_once(APPPATH.'libraries/REST_Controller.php');

class Books extends REST_Controller
{
    protected $segmentsOffset = 0;
    protected $interface_lang;
    protected $process_form_html_id = "books";

    public function __construct()
    {
        parent::__construct();

        // === Load Models === //
        $this->load->model('books_model');
        $this->load->model('formbuilder_model');

        //set language based on URL
        $this->lang_model->setApplicationLanguage($this);
    }

    protected function _perform_library_auth($email, $password)
    {
        //if($this->request->method === 'get') return TRUE;

        $user = $this->customers_model->checkLogin($email,$password);
        if(!$user) return FALSE;

        $this->load->model('groups_model');
        return $this->groups_model->hasApiAccess($user,$this->request->method,'books','admin');
    }

    public function index_get()
    {
        if($id = $this->get('id'))
        {
            if($item = $this->books_model->getOneById($id))
            {
                $this->response($item, 200);
            }
            else
            {
                $this->response(array('error' => 'Not found'), 404);
            }
        }
        else
        {
            $filter_data = $this->books_model->getFilterData();
            $data = $this->books_model->get('',$filter_data);

            //strip tags from description
           /* foreach($data['posts_list'] as &$item)
                $item->description = strip_tags($item->description);*/

            $this->response($data, 200);
        }
    }

    public function index_post()
    {
        $data = $this->post();

        if(!$saved = $this->formbuilder_model->storeForm($data,$this->process_form_html_id))
        {
            echo validation_errors();
        }
    }

    public function index_put()
    {
        if(!($data_key = $this->put('data_key')))
        {
            $this->response(array('error' => 'Please provide item\'s ID'), 404);
        }

        $data = $_POST = $this->put();

        if(!$this->formbuilder_model->storeForm($data,$this->process_form_html_id,$data_key))
        {
            $this->response(array('error' => validation_errors(' ',' ')), 200);
        }
    }

    public function index_delete()
    {
        if($id = $this->delete('id'))
        {
            if($item = $this->books_model->getOneById($id))
            {
                $this->books_model->deleteId($id);

                $this->response(array('success' => 'Book deleted'), 200);
            }
            else
            {
                $this->response(array('error' => 'Not found'), 404);
            }
        }
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
     * Increment segment offset
     */
    public function incSegmentsOffset()
    {
        $this->segmentsOffset++;
    }
}