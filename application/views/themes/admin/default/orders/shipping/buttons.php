<?$orders_customer_info = $BC->orders_model->getOrderCustomerInfo($orders_customer_info_id);?>
<?if($orders_customer_info['shipping_type']=='ukrposhta'):?>
    <?=anchor_base("shipping/printUrkPost/".$orders_customer_info_id, 'Друк квитанції для Укрпошти', 'target="_blank"' )?>
<?elseif($orders_customer_info['shipping_type']=='novaposhta'):?>
    <?=anchor_base("shipping/novaposhtaSend/".$id, 'Надіслати в Нову Пошту')?>
    <?if($orders_customer_info['doc_number']):?>
        | <a href="https://my.novaposhta.ua/orders/printDocument/orders[]/<?=$orders_customer_info['doc_number']?>/type/pdf/apiKey/<?=@$BC->settings_model['novaposhta_apiKey']?>" target="_blank">Друк накладної</a>
    <?endif?>
<?endif?>