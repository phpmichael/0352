<tr>
	<td class="vt">
		<?=language('category')?>: <span class="red">*</span>
		
		<?if(isset($search_category_id)):?>
			<br /><a href="javascript:void(0)" class="cs-show-csb" model="<?=$categories_model?>"><?=language('change')?></a>
		<?endif?>
	</td>
	<td>
		<div id="cs-ccl">
		    <?if(isset($search_category_id)):?>
    			<?=form_hidden('category[]',$search_category_id)?>
    		    <?=$search_category_title?>
		    <?endif?>
		</div>
		<div id="cs-boxes" <?if(isset($search_category_id)):?>class="hide"<?endif?>>
            
		</div>
	</td>
</tr>