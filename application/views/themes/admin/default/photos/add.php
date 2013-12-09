<form action="" method="post" enctype="multipart/form-data">

<?if( !empty($file_names) ):?>
	<div>Uploaded photos</div>
	
	<?for($i=1;$i<=5;$i++):?>
		<?if(isset($file_names[$i])):?>
	    	<div class="fl"><?=img('images/data/s/photos/'.$file_names[$i])?></div>
	    <?endif?>
	<?endfor?>
	
	<div class="clear"></div>
<?endif?>

<ul class="red"><?=$BC->upload->display_errors('<li>','</li>')?></ul>

<ul>
<?for($i=1;$i<=5;$i++):?>
    <li><?=language('file')?> <?=$i?>: <?=form_upload("image_{$i}");?></li>
<?endfor?>
</ul>

<p><?=form_submit("submit",language('upload'));?></p>

</form>