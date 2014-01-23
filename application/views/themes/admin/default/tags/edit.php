<div class="red"><?=validation_errors()?></div>

<form action="" method="post">

<table class="list">
<tr>
	<td colspan="2"><span class="red">*</span> <?=language('required_fields')?></td>
</tr>
<tr>
	<td><?=language('tags')?>:</td>
	<td>
    	<?if(!empty($tags_list)):?>
        	<?foreach ($tags_list as $tag):?>
        	   <span id="tag-<?=$tag['tag_id']?>"><?=$tag['tag']?></span> 
        	   <?if(userAccess('tags','delete')):?>
        	   <a class="del_tag" href="javascript:void(0)" tag_id="<?=$tag['tag_id']?>">
        	       <?=img($BC->_getTheme().'images/delete.gif')?>
        	   </a>
        	   <?endif?>
        	<?endforeach;?>
    	<?endif?>
	</td>
</tr>
<tr>
	<td><?=language('add')?>: <span class="red">*</span></td>
	<td><?=form_input("tags",set_value('tags'),"class='largeinput'");?></td>
</tr>
</table>

<p><?=form_submit("submit",language('save'));?></p>

</form>

<?=load_inline_js('inc/js-delete-tags')?>