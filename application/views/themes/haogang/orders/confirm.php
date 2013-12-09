<div class="main-block">
    <div class="top-corners"><div><div>&nbsp;</div></div></div>

    <div class="corner">
        <div class="full-width">
            <div class="page-title">
                <h1><?=$BC->_getPageTitle()?></h1>
            </div>

			<?=form_open($BC->_getBaseURI().'/place')?>
			
			<table class="data-table">
			<thead>
				<tr>
				  <th><?=language('thing_name')?></th>
				  <th style="width:60px;" class="a-right"><?=language('price')?></th>
				  <th style="width:60px;" class="a-right"><?=language('quantity')?></th>
				  <th style="width:100px;" class="a-right"><?=language('subtotal')?></th>
				</tr>
			</thead>
			
			<tbody>
			<?$i = 1?>
			<?foreach ($this->cart->contents() as $item):?>
				<tr>
				  <td>
					<?=$item['name']?>
			
					<?=load_theme_view('inc/tpl-products-attributes-display',array('item'=>$item))?>
				  </td>
				  <td class="a-right"><?=exchange($item['price'])?></td>
				  <td class="a-right"><?=$item['qty']?></td>
				  <td class="a-right"><?=exchange($item['subtotal'])?></td>
				</tr>
			<?$i++?>
			<?endforeach?>
			</tbody>
			
			<tfoot>
			    <tr>
			   	  <td></td>
			   	  <td colspan="2" class="a-right"><strong><?=language('subtotal')?></strong></td>
			      <td class="a-right"><?=exchange($this->cart->total())?></td>
			    </tr>
			    
			    <?if( $discount_coupon = $this->discount_coupons_model->getActiveDiscountCoupon() ):?>
			    <tr>
			      <td></td>
			   	  <td colspan="2" class="a-right"><strong><?=language('discount_coupon')?></strong></td>
			      <td class="a-right"><?=exchange($discount_coupon['amount'])?></td>
			    </tr>
			    <?elseif( ($discount_amount = $this->discounts_model->getDiscountAmount())>0 ):?>
			    <tr>
			      <td></td>
			   	  <td colspan="2" class="a-right"><strong><?=language('discount')?></strong> (<?=$this->discounts_model->getDiscountPercent()?>%)</td>
			      <td class="a-right"><?=exchange($discount_amount)?></td>
			    </tr>
			    <?endif?>
			    
				<tr>
				  <td>
				  	<button type="submit" name="order" title="<?=language('confirm_order')?>" class="button"><span><span><?=language('confirm_order')?></span></span></button>
				  </td>
				  <td colspan="2" class="a-right"><strong><?=language('grand_total')?></strong></td>
				  <td class="a-right"><strong><?=exchange($BC->orders_model->calcOrderTotal())?></strong></td>
				</tr>
			</tfoot>
			</table>
			
			</form>
			
		</div>
    </div>

    <div class="bot-corners"><div><div>&nbsp;</div></div></div>
</div>