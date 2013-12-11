<div id="content">
	<div class="gallery-big-photo">
    	<?=(isset($list[0])?img('images/data/b/photos/'.$list[0]['file_name']):'')?>
	</div>
</div>

<div id="sidebar">
    <div class="gallery-photos-preview-pagination"><?=$paginate?></div>
    <a href="javascript:void(0)" class="gallery-photos-preview-scroll-down"><?=language('scroll_down')?></a>
    <div class="gallery-photos-preview">
    	<?
    	foreach ($list as $record)
    	{
    	   echo "<a href='javascript:void(0)' class='gallery-photo-preview' id='gallery-photo-preview-{$record['id']}'>".img('images/data/s/photos/'.$record['file_name']).'</a>';
        }
        ?>
    </div>
    <a href="javascript:void(0)" class="gallery-photos-preview-scroll-up"><?=language('scroll_up')?></a>
    <div class="gallery-photos-preview-pagination"><?=$paginate?></div>
    
    <?load_theme_view('inc/box-tags-cloud')?>
</div>

<div id="albums">
	<div class="clear"></div>
	<div id="album">
		<span><!--Albums-->
			
		</span>
	</div>	
</div>

<script type="text/javascript">
$j(document).ready(function(){
    
    //hover on preview
    $j("a.gallery-photo-preview").hover(function(){
       $j(this).css('z-index',1);
       cssSandpaper.setTransform(document.getElementById($j(this).attr('id')), "scale(1.15, 1.15)");
    },
    function(){
       $j(this).css('z-index',0);
        cssSandpaper.setTransform(document.getElementById($j(this).attr('id')), "scale(1.15, 1.15)");
    });
    
    //selected photo preview - show large photo
    $j("a.gallery-photo-preview").click(function(){
        var src = $j(this).find('img').attr('src');
        src = src.replace('/s/','/b/');
        $j(".gallery-big-photo img").attr('src',src);
    });
    
    //scroll up click
    $j(".gallery-photos-preview-scroll-up").click(function(){
        $j(".gallery-photos-preview").animate({scrollTop:'+=100'});
    });
    
    //scroll down click
    $j(".gallery-photos-preview-scroll-down").click(function(){
        $j(".gallery-photos-preview").animate({scrollTop:'-=100'});
    });
    
    //load photo categories
    loadPhotoCategories(0);
    
    //click on category image
    $j("#albums span a").live('click',function(){
        var has_children = $j(this).attr('has_children');
        var category_id = $j(this).attr('category_id');
        if(has_children == 0) 
        {
            document.location.href = "<?=base_url().$BC->_getBaseURI()?>/show/"+category_id+"<?=$BC->config->item('url_suffix')?>";
        }
        else
        {
            loadPhotoCategories(category_id)
        }
    });

	function loadPhotoCategories(parent_id)
	{
	    $j("#albums span").html("<?=language('loading')?>...");
	    
	    var URL_getCategoriesJSON = "<?=base_url().$BC->_getBaseURI()?>/getCategoriesJSON/"+parent_id;
        
	    $j.getJSON( URL_getCategoriesJSON ,
            
        	function(data)
        	{
        		$j("#albums span").html('');
        		
                if( data.length != 0 )
                {
        			for(i in data)
    	        	{
    	        		$j("#albums span").append("<a href='javascript:void(0)' category_id='"+data[i].id+"' has_children='"+data[i].has_children+"'><img src='<?=base_url()?>images/data/s/photos_categories_list/"+data[i].file_name+"' alt='' /></a>");
    	        	}
                }
            }
        
        );
	}
});
</script>