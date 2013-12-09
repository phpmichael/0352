<table width='100%' class='table-order-deatils' border="1">
	<thead>
		<tr>
		    <th style='text-align:left' width='60%'><?=language('thing_name')?></th>
		    <th style='text-align:right' width='10%'><?=language('quantity')?></th>
		    <th style='text-align:right' width='15%'><?=language('price')?></th>
		    <th style='text-align:right' width='15%'><?=language('subtotal')?></th>
		</tr>
	</thead>
	
	<tfoot>
		<tr class="sectiontableentry1">
	   	  <td></td>
	   	  <td colspan="2" style="text-align:right;"><strong><?=language('subtotal')?></strong></td>
	      <td style="text-align:right;"><?=exchange($order['subtotal'])?></td>
	    </tr>
		<?if($order['discount_amount']>0):?>
	    <tr class="sectiontableentry1">
	      <td></td>
	   	  <td colspan="2" style="text-align:right;">
	   	  	<?if($order['discount_coupon']):?>
	   	  		<strong><?=language('discount_coupon')?></strong> <?=$order['discount_coupon']?>
	   	  	<?else:?>
	   	  		<strong><?=language('discount')?></strong>
	   	  	<?endif?>
	   	  	
	   	  	<?if($order['discount_percent']):?>(<?=$order['discount_percent']?>%)<?endif?>
	   	  </td>
	      <td style="text-align:right;"><?=exchange($order['discount_amount'])?></td>
	    </tr>
	    <?endif?>
	    <?if($order['shipping_id']):?>
	    <tr class="sectiontableentry1">
	   	  <td colspan="3" style="text-align:right;">
	   	  	<strong><?=language('shipping')?></strong> <?=anchor_base("shipping/edit/pub_date/asc/0/".$order['shipping_id'],$order['shipping_title'])?>
	   	  </td>
	      <td style="text-align:right;"><?=exchange($order['shipping_amount'])?></td>
	    </tr>
	    <?endif?>
		<tr class="sectiontableentry1">
		  <td></td>
		  <td colspan="2" style="text-align:right"><strong><?=language('grand_total')?></strong></td>
		  <td style="text-align:right"><strong><?=exchange($order['total'])?></strong></td>
		</tr>
	</tfoot>
	
	<tbody>
		<?foreach ($orders_cart as $item): $product_name = utf8_wordwrap($item['product_name'],40," ");?> 
		<tr>
		    <td style='text-align:left'> 
		    	<?=((userAccess('books','view'))?anchor_base("books/view/pub_date/asc/0/".$item['product_id'],$product_name):$product_name)?>
		    	<?=load_theme_view('inc/tpl-products-attributes-display',array('item'=>$item))?>
		    </td>
		    <td style='text-align:right'><?=$item['qty']?></td>
		    <td style='text-align:right'><?=exchange($item['price'])?></td>
		    <td style='text-align:right'><?=exchange($item['qty']*$item['price'])?></td>
		</tr>
		<?endforeach?>
	</tbody>
</table>