<?=form_open($BC->_getBaseURI().'/place')?>

<table width="100%">

<tr>
  <th><?=language('quantity')?></th>
  <th><?=language('thing_name')?></th>
  <th style="text-align:right"><?=language('price')?></th>
  <th style="text-align:right"><?=language('subtotal')?></th>
</tr>

<?$i = 1?>

<?foreach ($this->cart->contents() as $item):?>

	<tr>
	  <td><?=$item['qty']?></td>
	  <td>
		<?=$item['name']?>

		<?=load_theme_view('inc/tpl-products-attributes-display',array('item'=>$item))?>
	  </td>
	  <td style="text-align:right"><?=exchange($item['price'])?></td>
	  <td style="text-align:right"><?=exchange($item['subtotal'])?></td>
	</tr>

<?$i++?>

<?endforeach?>

<tr>
  <td colspan="2"></td>
  <td style="text-align:right;"><strong><?=language('subtotal')?></strong></td>
  <td style="text-align:right;"><?=exchange($this->cart->total())?></td>
  <td></td>
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

<tr>
  <td><?=form_submit('order', language('confirm_order')); ?></td>
  <td></td>
  <td style="text-align:right"><strong><?=language('total')?></strong></td>
  <td style="text-align:right"><?=exchange($BC->orders_model->calcOrderTotal())?></td>
</tr>

</table>

</form>