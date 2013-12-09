<?$cart_contents = $this->cart->contents()?>

<?if($cart_contents):?>
    <?=form_open($BC->_getBaseURI().'/update',"id='cart-form'")?>
    
    <table width="100%">
    
    <thead>
        <tr class="rowH">
          <th><?=language('quantity')?></th>
          <th><?=language('thing_name')?></th>
          <th style="text-align:right"><?=language('price')?></th>
          <th style="text-align:right"><?=language('subtotal')?></th>
          <th style="text-align:right"><?=language('delete')?></th>
        </tr>
    </thead>
    
    <?$i = 1?>
    <tbody>
    <?foreach ($cart_contents as $item):?>
    
    	<?=form_hidden($i.'[rowid]', $item['rowid']); ?>
    
    	<tr <?if($i%2):?>class="rowB"<?else:?>class="rowA"<?endif?>>
    	  <td><?=form_input(array('name' => $i.'[qty]', 'value' => $item['qty'], 'maxlength' => '3', 'size' => '5'))?></td>
    	  <td>
    		<?=$item['name']?>
    		
    		<?=load_theme_view('inc/tpl-products-attributes-display',array('item'=>$item))?>
    	  </td>
    	  <td style="text-align:right"><?=exchange($item['price'])?></td>
    	  <td style="text-align:right"><?=exchange($item['subtotal'])?></td>
    	  <td style="text-align:right"><a href="javascript:void(0)" class="delete-item" rel="<?=($i.'[qty]')?>"><?=language('delete')?></a></td>
    	</tr>
    
    <?$i++?>
    
    <?endforeach?>
    </tbody>
    
    <tfoot>
        <tr <?if($i%2):?>class="rowB"<?else:?>class="rowA"<?endif?>>
       	  <td>
       	    <?=form_submit('update', language('update_cart')); ?>
       	    					   	  	
            <?$discount_coupon = $this->discount_coupons_model->getActiveDiscountCoupon()?>
        	&nbsp;<?=language('discount_coupon')?> <?=form_input('discount_coupon_code',$discount_coupon['code'],"size='10' maxlength='10'")?> <?=$this->discount_coupons_model->getError()?>
       	  </td>
       	  <td><?=form_submit('order', language('make_order')); ?></td>
       	  <td style="text-align:right;"><strong><?=language('subtotal')?></strong></td>
          <td style="text-align:right;"><?=exchange($this->cart->total())?></td>
          <td></td>
        </tr>
        <?$i++?>
        
        <?if( $discount_coupon ):?>
        <tr <?if($i%2):?>class="rowB"<?else:?>class="rowA"<?endif?>>
          <td colspan="2"></td>
       	  <td style="text-align:right;"><strong><?=language('discount_coupon')?></strong> <?if($discount_coupon['percents'])?>(<?=$discount_coupon['percents']?>%)</td>
          <td style="text-align:right;"><?=exchange($discount_coupon['amount'])?></td>
          <td></td>
        </tr>
        <?$i++?>
        <?elseif( ($discount_amount = $this->discounts_model->getDiscountAmount())>0 ):?>
        <tr <?if($i%2):?>class="rowB"<?else:?>class="rowA"<?endif?>>
          <td colspan="2"></td>
       	  <td style="text-align:right;"><strong><?=language('discount')?></strong> (<?=$this->discounts_model->getDiscountPercent()?>%)</td>
          <td style="text-align:right;"><?=exchange($discount_amount)?></td>
          <td></td>
        </tr>
        <?$i++?>
        <?endif?>
        
        <tr <?if($i%2):?>class="rowB"<?else:?>class="rowA"<?endif?>>
          <td colspan="2"></td>
          <td style="text-align:right"><strong><?=language('total')?></strong></td>
          <td style="text-align:right"><?=exchange($BC->orders_model->calcOrderTotal())?></td>
          <td></td>
        </tr>
    </tfoot>
    
    </table>
    
    </form>
<?else:?>
    <h2><?=language('your_cart_is_empty')?></h2>
    <?=anchor_base('products',language('back_to_catalog'))?>
<?endif?>

<?=include_js($BC->_getFolder('js').'custom/cart/cart.js')?>