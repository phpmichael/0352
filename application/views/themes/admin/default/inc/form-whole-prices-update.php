<?if(userAccess($BC->_getController(),'edit')):?>
	<div id="whole_prices_update">
    	<?=language('update_prices')?>:
    	<?=form_dropdown('sign',array('+'=>'+','-'=>'-'))?>
    	<?=form_input('value')?>
    	<?=form_dropdown('type',array('percents'=>'%','money'=>'money'))?>
    	<?=form_button('',language('change'))?>
    </div>

    <script>
        $j('#whole_prices_update button').click(function(){
            $j('form[name=form]').attr('action','<?=aurl('whole_prices_update')?>').submit();
        });
    </script>
<?endif?>