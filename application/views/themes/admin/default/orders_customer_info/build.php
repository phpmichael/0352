<?$BC->load->model('orders_model');?>
<?if($order = $BC->orders_model->getOneByUnique('orders_customer_info_id', $data_key)):?>
   <h2><?=anchor($BC->_getBaseURL().'orders/edit/id/desc/0/'.$order['id'],'Order #'.$order['id'])?></h2>
<?endif;?>

<?fb_form($form_id,$data_key)?>