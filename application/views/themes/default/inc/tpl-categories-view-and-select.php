<tr>
	<td class="vt">
		<?=language('category')?>: <span class="red">*</span>
		
		<?if(isset($post_categories)):?>
			<br /><a href="javascript:void(0)" class="cs-show-csb" model="<?=$categories_model?>"><?=language('change')?></a>
		<?endif?>
	</td>
	<td>
		<div id="cs-ccl">
			<?if(isset($post_categories)):?>
		    <ul>
			<?foreach ($post_categories as $key=>$category):?>
				<li><?=$category?></li>
			<?endforeach?>
			</ul>
			<?endif?>
		</div>
		<div id="cs-boxes" <?if(isset($post_categories)):?>class="hide"<?endif?>>
            
		</div>
	</td>
</tr>