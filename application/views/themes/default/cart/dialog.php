<?$cart_contents = $this->cart->contents()?>

<?if($cart_contents):?>
    <?=form_open($BC->_getBaseURI().'/update',"id='dialog-cart-form'")?>
    
    <table width="100%">
    
    <thead>
        <tr>
          <th class="item-image-col"></th>
          <th class="item-name-col"><?=language('thing_name')?></th>
          <th class="item-price-col"><?=language('price')?></th>
          <th class="item-qty-col"><?=language('quantity')?></th>
          <th class="item-subtotal-col"><?=language('subtotal')?></th>
          <th class="item-delete-col"><?=language('delete')?></th>
        </tr>
    </thead>
    
    <?$i = 1?>
    <tbody>
    <?foreach ($cart_contents as $item):?>
    
    	<?=form_hidden($i.'[rowid]', $item['rowid']); ?>
    
    	<tr <?if($i%2):?>class="row-odd"<?else:?>class="row-even"<?endif?>>
    	  <td class="item-image-col">
    	  	<?$product = $BC->products_model->getOneById($item['id'])?>
        	<?=(($product['image'])?anchor_base('products/name/'.$product['slug'],img('images/data/s/products/'.$product['image']),"title='".htmlspecialchars($product['name'])."'"):'')?>
          </td>
    	  <td class="item-name-col">
    		<?=$item['name']?>
    		<?=load_theme_view('inc/tpl-products-attributes-display',array('item'=>$item))?>
    	  </td>
    	  <td class="item-price-col"><?=exchange($item['price'])?></td>
    	  <td class="item-qty-col"><?=form_input(array('name' => $i.'[qty]', 'value' => $item['qty'], 'maxlength' => '3', 'size' => '2'))?></td>
    	  <td class="item-subtotal-col"><?=exchange($item['subtotal'])?></td>
    	  <td class="item-delete-col"><a href="javascript:void(0)" class="delete-item" rel="<?=($i.'[qty]')?>"><?=language('delete')?></a></td>
    	</tr>
    
    <?$i++?>
    
    <?endforeach?>
    </tbody>
    
    <tfoot>
        <tr <?if($i%2):?>class="row-odd"<?else:?>class="row-even"<?endif?>>
       	  <td colspan="3"></td>
       	  <td style="text-align:right;"><strong><?=language('subtotal')?></strong></td>
          <td style="text-align:right;"><?=exchange($this->cart->total())?></td>
          <td></td>
        </tr>
        <?$i++?>
        
        <tr <?if($i%2):?>class="row-odd"<?else:?>class="row-even"<?endif?>>
       	  <td colspan="6">
       	  	<div style="float:left">
       	  		<?=form_button('close', language('continue_shopping'),"class='close-facebox'"); ?>
       	  	</div>
       	  	<div style="float:right">
	       	    <?=form_submit('update', language('update_cart')); ?>
	       	    <?=form_button('go_to_cart', language('proceed_to_checkout'),"class='go-to-cart'"); ?>
	       	</div>
       	  </td>
        </tr>
    </tfoot>
    
    </table>
    
    </form>
<?else:?>
    <h2><?=language('your_cart_is_empty')?></h2>
    <?=anchor_base('products',language('back_to_catalog'))?>
<?endif?>

<?=include_js($BC->_getFolder('js').'custom/cart/cart.js')?>