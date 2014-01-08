<?
$products_manufacturers_model = load_model('products_manufacturers_model');
$manufacturers = $products_manufacturers_model->getManufacturersList();
?>

<?if(!empty($manufacturers)):?>
<h3><?=language('manufacturers')?></h3>

<div class="well">

    
	<ul class="unstyled">
		<?foreach ($manufacturers as $manufacturer_id=>$manufacturer_name):?>
		<?if($manufacturer_id):?>
		<li>
			<?=anchor_base('books/search/manufacturer_id/'.$manufacturer_id,$manufacturer_name)?>
		</li>
		<?endif?>
		<?endforeach?>
	</ul>
   
</div>
<?endif?>
