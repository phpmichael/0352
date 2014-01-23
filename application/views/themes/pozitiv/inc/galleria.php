<style>
#galleria{
    width:820px;
    height:600px;
}
</style>

<div id="galleria">
    <?foreach ($list as $key=>$record):?>
      <a href="<?=base_url().'images/data/b/photos/'.$record['file_name']?>">
        <?=img(array('src'=>base_url().'images/data/s/photos/'.$record['file_name'],'width'=>90,'height'=>60))?>
      </a>
    <?endforeach?>
</div>

<?=include_js($BC->_getTheme().'js/galleria/galleria-1.2.7.min.js')?>

<script>
    Galleria.loadTheme('<?=base_url().$BC->_getTheme()?>js/galleria/themes/classic/galleria.classic.min.js');
    Galleria.configure({
        /*transition:'flash',
        transition:'fadeslide',*/
    });
    Galleria.run('#galleria');
</script>