<div class="main-block">
    <div class="top-corners"><div><div>&nbsp;</div></div></div>

    <div class="corner">
        <div class="full-width">
            <div class="page-title">
                <h1><?=$BC->_getPageTitle()?></h1>
            </div>

			<?$cart_contents = $this->cart->contents()?>
			
			<?if($cart_contents):?>
			<div class="cart">
			    <?=form_open($BC->_getBaseURI().'/update',"id='cart-form'")?>
			    
				    <table id="shopping-cart-table" class="data-table cart-table">
				    <thead>
					    <tr>
					      <th style="width:65px;"></th>
					      <th><?=language('thing_name')?></th>
					      <th style="width:50px;text-align:right"><?=language('price')?></th>
					      <th style="width:50px;"><?=language('quantity')?></th>
					      <th style="width:100px;text-align:right"><?=language('subtotal')?></th>
					      <th style="width:20px;"></th>
					    </tr>
				    </thead>
				    
				    <tbody>
				    <?$i = 1?>
				    
				    <?foreach ($cart_contents as $item):?>
				    
				    	<?=form_hidden($i.'[rowid]', $item['rowid']); ?>
				    
				    	<tr <?if($i%2):?>class="rowB"<?else:?>class="rowA"<?endif?>>
				    	  <td>
				    	  	<?$product = $BC->products_model->getOneById($item['id'])?>
				    	  	<a title="<?=htmlspecialchars($product['name'])?>" href="<?=site_url($BC->_getBaseURL().'products/name/'.$product['slug'])?>" class="product-image" data-lightbox="product-image">
	                			<?if(@$product['image']) echo img('images/data/s/products/'.$product['image'])?>
	                		</a>
				    	  </td>
				    	  <td>
				    			<?=$item['name']?>
				    
				    			<?=load_theme_view('inc/tpl-products-attributes-display',array('item'=>$item))?>
				    	  </td>
				    	  <td style="text-align:right"><?=exchange($item['price'])?></td>
				    	  <td><?=form_input(array('name' => $i.'[qty]', 'value' => $item['qty'], 'maxlength' => '3', 'size' => '5'))?></td>
				    	  <td style="text-align:right"><?=exchange($item['subtotal'])?></td>
				    	  <td style="text-align:right">
				    	  	<a href="javascript:void(0)" title="<?=language('delete')?>" class="delete-item btn-remove" rel="<?=($i.'[qty]')?>"><?=language('delete')?></a>
				    	  </td>
				    	</tr>
				    
				    	<?$i++?>
				    
				    <?endforeach?>
				    </tbody>
				    
				    <tfoot>
					    <tr <?if($i%2):?>class="rowB"<?else:?>class="rowA"<?endif?>>
					   	  <td colspan="2" class="a-left">
					   	  	<button type="submit" title="<?=language('update_cart')?>" class="button btn-update"><span><span><?=language('update_cart')?></span></span></button>
					   	  	
					   	  	<?$discount_coupon = $this->discount_coupons_model->getActiveDiscountCoupon()?>
    					   	&nbsp;<?=language('discount_coupon')?> <?=form_input('discount_coupon_code',$discount_coupon['code'],"size='10' maxlength='10'")?> <?=$this->discount_coupons_model->getError()?>
					   	  </td>
					   	  <td colspan="2" class="a-right"><strong><?=language('subtotal')?></strong></td>
					      <td class="a-right"><?=exchange($this->cart->total())?></td>
					      <td></td>
					    </tr>
					    
					    <?if( $discount_coupon ):?>
					    <tr>
					      <td colspan="2"></td>
					   	  <td colspan="2" class="a-right"><strong><?=language('discount_coupon')?></strong> <?if($discount_coupon['percents'])?>(<?=$discount_coupon['percents']?>%)</td>
					      <td class="a-right"><?=exchange($discount_coupon['amount'])?></td>
					    </tr>
					    <?elseif( ($discount_amount = $this->discounts_model->getDiscountAmount())>0 ):?>
					    <tr>
					      <td colspan="2"></td>
					   	  <td colspan="2" class="a-right"><strong><?=language('discount')?></strong> (<?=$this->discounts_model->getDiscountPercent()?>%)</td>
					      <td class="a-right"><?=exchange($discount_amount)?></td>
					    </tr>
					    <?endif?>
					    
				    </tfoot>
				    </table>
			    
				    <!-- Totals -->
				    <div class="totals">
					    <table id="shopping-cart-totals-table">
					      <tfoot>
					        <tr>
					          <td class="a-right" colspan="1"><strong><?=language('grand_total')?></strong></td>
					          <td class="a-right"><strong><?=exchange($BC->orders_model->calcOrderTotal())?></strong></td>
					        </tr>
					      </tfoot>
					    </table>
					
					    <ul class="checkout-types">
					      <li>
						      <button type="submit" name="order" title="<?=language('proceed_to_checkout')?>" class="button btn-proceed-checkout btn-checkout"><span><span><?=language('proceed_to_checkout')?></span></span></button>
					      </li>
					    </ul>
					</div>
				    <!-- Totals -->
			    </form>
			</div>
			<?else:?>
			    <h2><?=language('your_cart_is_empty')?></h2>
			    <?=anchor_base('products',language('back_to_catalog'))?>
			<?endif?>
			
		</div>
    </div>

    <div class="bot-corners"><div><div>&nbsp;</div></div></div>
</div>

<?=include_js($BC->_getFolder('js').'custom/cart/cart.js')?>