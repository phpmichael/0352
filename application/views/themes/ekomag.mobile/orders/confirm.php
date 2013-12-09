<h2><?=$BC->_getPageTitle()?></h2>

<div>
    <?=form_open($BC->_getBaseURI().'/place')?>

	<table class="box-table-a">
	<thead>
		<tr>
		  <th><?=language('thing_name')?></th>
		  <th style="width:60px;text-align:right"><?=language('price')?></th>
		  <th style="width:60px;text-align:right"><?=language('quantity')?></th>
		  <th style="width:100px;text-align:right"><?=language('subtotal')?></th>
		</tr>
	</thead>
	
	<tfoot>
		<tr>
	   	  <td></td>
	   	  <td colspan="2" style="text-align:right;"><strong><?=language('subtotal')?></strong></td>
	      <td style="text-align:right;"><?=exchange($this->cart->total())?></td>
	    </tr>
		
	    <?if( $discount_coupon = $this->discount_coupons_model->getActiveDiscountCoupon() ):?>
	    <tr>
	      <td></td>
	   	  <td colspan="2" style="text-align:right;"><strong><?=language('discount_coupon')?></strong> <?if($discount_coupon['percents'])?>(<?=$discount_coupon['percents']?>%)</td>
	      <td style="text-align:right;"><?=exchange($discount_coupon['amount'])?></td>
	    </tr>
	    <?elseif( ($discount_amount = $this->discounts_model->getDiscountAmount())>0 ):?>
	    <tr>
	      <td></td>
	   	  <td colspan="2" style="text-align:right;"><strong><?=language('discount')?></strong></td>
	      <td style="text-align:right;"><?=exchange($discount_amount)?> (<?=$this->discounts_model->getDiscountPercent()?>%)</td>
	    </tr>
	    <?endif?>
	    
	    <?if( $shipping_title = $BC->shipping_model->getSelectedShipping('title') ):?>
	    <tr>
	   	  <td colspan="3" style="text-align:right;"><strong><?=language('shipping')?></strong> <?=$shipping_title?></td>
	      <td style="text-align:right;"><?$cost = $BC->shipping_model->getSelectedShipping('cost')?><?=(($cost>0)?exchange($cost):'')?></td>
	    </tr>
	    <?endif?>
	    
		<tr>
		  <td>
		  	<button type="submit" name="order" title="<?=language('confirm_order')?>" class="button"><span><span><?=language('confirm_order')?></span></span></button>
		  </td>
		  <td colspan="2" style="text-align:right"><strong><?=language('grand_total')?></strong></td>
		  <td style="text-align:right"><strong><?=exchange($BC->orders_model->calcOrderTotal())?></strong></td>
		</tr>
	</tfoot>
	
	<tbody>
		<?$i = 1?>
		<?foreach ($this->cart->contents() as $item):?>
		<tr>
		  <td>
			<?=utf8_wordwrap($item['name'],50,' ')?>
	
			<?=load_theme_view('inc/tpl-products-attributes-display',array('item'=>$item))?>
		  </td>
		  <td style="text-align:right"><?=exchange($item['price'])?></td>
		  <td style="text-align:right"><?=$item['qty']?></td>
		  <td style="text-align:right"><?=exchange($item['subtotal'])?></td>
		</tr>
		<?$i++?>
		<?endforeach?>
	</tbody>

	</table>
	
	</form>
</div>