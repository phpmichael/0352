<?
load_model('products_model');
$featured = $BC->zen->expires(30)->products_model->getFeatured(3);
?>

<?if($featured['total_rows']):?>

<h3><?=language('featured')?></h3>

<div class="well" style="text-align:center">
    <?foreach ($featured['posts_list'] as $row):?>
	    <form action="<?=relative_url($BC->_getBaseURL()."/cart/add")?>" class="add-product">
	        <?=form_hidden('id',$row->data_key)?>
	        <?=form_hidden('qty',1)?>

	            <div class="product_image_container">
	                <a title="<?=htmlspecialchars($row->name)?>" href="<?=site_url($BC->_getBaseURL().'books/name/'.$row->slug.url_category_addition())?>">
	        			<?if(@$row->photo1) echo img(array('src'=>'images/data/m/books/'.$row->photo1))?>
	        		</a>
	            </div>

	            <div>

	                <div>
	                    <?=anchor_base('books/name/'.$row->slug.url_category_addition(),utf8_wordwrap($row->name,17,' '),"class='product_name'")?>
	                </div>

	                <div class="product-price">
	                    <?=exchange($row->price)?>
	                </div>

	                <div>
	                    <?if($row->in_stock):?>
	                         <?=form_submit('',language('buy'),"class='btn btn-primary'")?>
	                    <?else:?>
	                         <?=language('not_in_stock')?>
	                    <?endif?>
	                </div>

	            </div>
	     </form>
    <?endforeach;?>
</div>

<?endif?>