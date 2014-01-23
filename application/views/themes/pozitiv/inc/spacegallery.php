
<div id="myGallery" class="spacegallery">
    <?foreach ($list as $key=>$record):?>
        <?=img(array('src'=>base_url().'images/data/b/photos/'.$record['file_name']))?>
    <?endforeach?>
</div>

<?=include_css($BC->_getTheme().'js/spacegallery/css/layout.css')?>
<?=include_css($BC->_getTheme().'js/spacegallery/css/spacegallery.css')?>
<?=include_css($BC->_getTheme().'js/spacegallery/css/custom.css')?>
<?=include_js($BC->_getTheme().'js/spacegallery/js/eye.js')?>
<?=include_js($BC->_getTheme().'js/spacegallery/js/utils.js')?>
<?=include_js($BC->_getTheme().'js/spacegallery/js/spacegallery.js')?>

<script>$j('#myGallery').spacegallery({loadingClass: 'loading'});</script>