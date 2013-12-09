<h2><?=$BC->_getPageTitle()?></h2>

<div>
    <?$cart_contents = $this->cart->contents();?>

	<?if($cart_contents):?>
	<div>
	    <?=form_open($BC->_getBaseURI().'/update',"id='cart-form'")?>
	    
		    <table class="box-table-a">
            <thead>
                <tr>
			      <th style="width:65px;"></th>
			      <th><?=language('thing_name')?></th>
			      <th style="width:70px;text-align:right"><?=language('price')?></th>
			      <th style="width:50px;"><?=language('quantity')?></th>
			      <th style="width:30px;"></th>
			      <th style="width:100px;text-align:right"><?=language('subtotal')?></th>
			    </tr>
		    </thead>
		    
		    <tfoot>
			    <tr>
			   	  <td colspan="2" style="vertical-align:middle;"></td>
			   	  <td colspan="3" style="text-align:right;"><strong><?=language('subtotal')?></strong></td>
			      <td style="text-align:right;"><?=exchange($this->cart->total())?></td>
			    </tr>
			    <tr>
			   	  <td colspan="5" style="text-align:right;vertical-align:middle;">
			   	  	<?$discount_coupon = $this->discount_coupons_model->getActiveDiscountCoupon()?>
			   	  	<?=language('discount_coupon')?>
			   	  	<?=form_input('discount_coupon_code',$discount_coupon['code'],"size='10' maxlength='10'")?> <?=$this->discount_coupons_model->getError()?></td>
			   	  	<td></td>
			    </tr>
			    
			    <?if( $discount_coupon ):?>
			    <tr>
			      <td colspan="2"></td>
			   	  <td colspan="3" style="text-align:right;"><strong><?=language('discount_coupon')?></strong> <?if($discount_coupon['percents'])?>(<?=$discount_coupon['percents']?>%)</td>
			      <td style="text-align:right;"><?=exchange($discount_coupon['amount'])?></td>
			    </tr>
			    <?elseif( ($discount_amount = $this->discounts_model->getDiscountAmount())>0 ):?>
			    <tr>
			      <td colspan="2"></td>
			   	  <td colspan="3" style="text-align:right;"><strong><?=language('discount')?></strong> (<?=$this->discounts_model->getDiscountPercent()?>%)</td>
			      <td style="text-align:right;"><?=exchange($discount_amount)?></td>
			    </tr>
			    <?endif?>
			    
			    <?if( $shipping_list = $BC->shipping_model->getShippingList() ):?>
			    <tr>
			      <td colspan="5" style="text-align:right;">
			      	<?=language('shipping')?>
			      	<?=form_dropdown('shipping_id',$shipping_list,$BC->shipping_model->getSelectedShipping('data_key'),"onchange='\$j(\"#cart-form\").submit();'")?>
			      </td>
			      <td style="text-align:right;"><?$cost = $BC->shipping_model->getSelectedShipping('cost')?><?=(($cost>0)?exchange($cost):'')?></td>
			    </tr>
			    <?endif?>
			    
			    <tr>
			      <td colspan="2"><button type="submit" title="<?=language('update_cart')?>" class="button btn-update"><span><span><?=language('update_cart')?></span></span></button></td>
			   	  <td colspan="3" style="text-align:right;"><strong><?=language('grand_total')?></strong></td>
			      <td style="text-align:right;"><strong><?=exchange($BC->orders_model->calcOrderTotal())?></strong></td>
			    </tr>
		    </tfoot>
		    
		    <tbody>
		    	<?$i = 1?>
		    	<?foreach ($cart_contents as $item): 
		    		$old_price = $BC->products_model->getOldPrice($item['id']); 
		    	?>
		    	<tr>
		    	  <td>
		    	  	<?=form_hidden($i.'[rowid]', $item['rowid']); ?>
		    	  	<?$product = $BC->products_model->getOneById($item['id'])?>
            		<?=(($product['image'])?anchor_base('products/name/'.$product['slug'],img('images/data/s/products/'.$product['image']),"title='".htmlspecialchars($product['name'])."'"):'')?>
		    	  </td>
		    	  <td style="vertical-align:middle">
                    <a title="<?=htmlspecialchars($product['name'])?>" href="<?=site_url($BC->_getBaseURL().'products/name/'.$product['slug'])?>">
                        <?=utf8_wordwrap($item['name'],50,' ')?>
                    </a>
                    
                    <?load_theme_view('inc/tpl-products-attributes-display',array('item'=>$item))?>
		    	  </td>
		    	  <td style="vertical-align:middle;text-align:right">
		    	  	<div><?=exchange($item['price'])?></div>
		    	  	<?if($old_price>0.00):?>
		    	  		<div><small style="color:#999;"><?=language('old_price')?>: <?=exchange($old_price)?></small></div>
		    	  	<?endif?>
		    	  </td>
		    	  <td style="vertical-align:middle;text-align:right"><?=form_input(array('name' => $i.'[qty]', 'value' => $item['qty'], 'maxlength' => '3', 'size' => '2', 'style' => 'width:20px;'))?></td>
		    	  <td style="vertical-align:middle;text-align:right">
		    	  	<a href="javascript:void(0)" title="<?=language('delete')?>" class="delete-item btn-remove" rel="<?=($i.'[qty]')?>"><?=img(base_url().$BC->_getTheme().'images/remove_from_cart.png')?></a>
		    	  </td>
		    	  <td style="vertical-align:middle;text-align:right">
		    	  	<div><?=exchange($item['subtotal'])?></div>
		    	  	<?if($discount_coupon['percents'] && $old_price==0.00):?>
		    	  		<div><small><?=language('discount')?>: <?=exchange($item['subtotal']*($discount_coupon['percents']/100))?></small></div>
		    	  	<?endif?>
		    	  </td>
		    	</tr>
		    	<?$i++?>
		    	<?endforeach?>
		    </tbody>

		    </table>
		    
	    </form>
    
		<div style="padding:20px 0 0 0;">
            <div style="text-align:center">
                <a href="<?=site_url($BC->_getBaseURL().'products')?>" class="continue_link">&lt; <?=language('continue_shopping')?></a> 
                |
                <a href="<?=site_url($BC->_getBaseURL().'orders/confirm')?>" class="checkout_link"><?=language('proceed_to_checkout')?> &gt;</a>
            </div>
        </div>
		    
	</div>
	<?else:?>
	    <h2><?=language('your_cart_is_empty')?></h2>
	    <?=anchor_base('products',language('back_to_catalog'))?>
	<?endif?>
</div>

<?=include_js($BC->_getFolder('js').'custom/cart/cart.js')?>