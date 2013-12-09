<div class="ad-gallery">
  <div class="ad-image-wrapper"></div>
  <div class="ad-controls"></div>
  <div class="ad-nav">
    <div class="ad-thumbs">
      <ul class="ad-thumb-list">
        <?foreach ($list as $key=>$record):?>
        <li>
          <a href="<?=base_url().'images/data/b/photos/'.$record['file_name']?>">
            <?=img(array('src'=>base_url().'images/data/s/photos/'.$record['file_name'],'width'=>90,'height'=>'60'))?>
          </a>
        </li>
        <?endforeach?>
      </ul>
    </div>
  </div>
</div>

<!-- AD Gallery -->
<?=include_minified($BC->_getTheme().'js/ad-gallery/jquery.ad-gallery.css','css')?>
<?=include_js($BC->_getTheme().'js/ad-gallery/jquery.ad-gallery.min.js')?>

<script type="text/javascript">
<!--//--><![CDATA[//><!--
var galleries = $j('.ad-gallery').adGallery({
    loader_image: '<?=base_url().$BC->_getTheme()?>js/ad-gallery/loader.gif',
    animation_speed: 600
});
//--><!]]>
</script>