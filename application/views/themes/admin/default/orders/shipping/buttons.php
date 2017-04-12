<?if($BC->orders_model->getShippingTitle($id)=='Укрпошта'):?>
    | <?=anchor_base("shipping/printUrkPost/".$customer_id, 'Друк квитанції для Укрпошти', 'target="_blank"' )?>
<?endif?>