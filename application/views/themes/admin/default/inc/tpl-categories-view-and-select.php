<tr>
	<td class="vt">
		<label class="desc"><?=language('category')?> <span class="red">*</span></label>
		
		<?if(isset($post_categories)):?>
			<br /><a href="javascript:;" class="cs-show-csb" model="<?=$categories_model?>"><?=language('change')?></a>
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
            <?if(@$BC->settings_model[$categories_model.'_csb_number']>1):?>
            <a href="javascript:;" class="cs-show-csb" model="<?=$categories_model?>"><?=language('add')?></a>
            <?endif?>
		</div>
	</td>
</tr>