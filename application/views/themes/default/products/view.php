<?load_theme_view('inc/tpl-cur-location')?>

<h2><?=$BC->_getPageTitle()?></h2>

<table>
<tr>
    <td>
        <?if(@$image):?>
    	<a href="<?=base_url().'images/data/b/products/'.$image?>" class="product-image">
    		<?=img('images/data/s/products/'.$image)?>
    	</a>
    	<?endif?>
    </td>
    <td>
		<?load_theme_view('inc/tpl-add-to-cart')?>
	</td>
</tr>
<?if(!empty($additional_images)):?>
<tr>
    <td colspan="2">
        <?foreach ($additional_images as $additional_image):?>
    	   <a class="product-image" href="<?=base_url().'images/data/b/'.$BC->_getCurrentTable().'/'.$additional_image['image']?>"><?=img('images/data/s/'.$BC->_getCurrentTable().'/'.$additional_image['image'])?></a>
    	<?endforeach?>
    </td>
</tr>
<?endif?>
</table>

<?if(@($description)):?>
    <?=$description?>
<?endif?>

<?if(@($youtube_url)):?>
<p>
    <?=youtube_box($youtube_url)?>
</p>
<?endif?>

<?load_theme_view('inc/box-post-tags',array('post_id'=>$id));?>

<?if(isset($post_categories)):?>
<?load_theme_view('inc/box-post-categories',array('post_categories'=>$post_categories,'method'=>'search'));?>
<?endif?>

<div><?=language('views_count')?>: <?=$views?></div>

<?=load_inline_js('inc/js-add-to-cart'); ?>
<?=load_inline_js('inc/js-tooltip'); ?>

<?=load_inline_js('inc/js-lightbox'); ?>