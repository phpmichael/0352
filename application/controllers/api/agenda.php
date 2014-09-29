<?php
require_once(APPPATH.'controllers/abstract/api.php');

class Agenda extends API
{
    protected $process_form_html_id = "agenda";
    protected $model_name = "agenda_model";
    protected $c_table = "agenda";

    /**
     * Return items list
     */
    protected function getItems()
    {
        if( ($start = $this->get('start')) && ($end = $this->get('end')) )
        {
            $events = $this->agenda_model->getEvents($start, $end, $this->user['id']);
        }
        elseif( $date = $this->get('date') )
        {
            $events = $this->agenda_model->getDayEvents($date, $this->user['id']);
        }
        else
        {
            $events = array();
        }

        $data['posts_list'] = $events;

        $this->response($data, 200);
    }
}