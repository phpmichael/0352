<script>
    $j(document).ready(function()
    {
        var update_url = '<?=site_url($BC->_getBaseURI()."/update")?>';
        var delete_url = '<?=site_url($BC->_getBaseURI()."/delete")?>';

        $j("#add_tdata").click(function(){
            link = $j('a[code=NEW]');

            if(link.length==0)
            {
                $j('<tr><td id="new_checkbox"></td><td class="tdata" id="NEW__id"></td><td class="tdata" id="NEW__sections"></td><td class="tdata" id="NEW__code"></td><?foreach (get_multilang_codes() as $lang_code):?><td class="tdata" id="NEW__<?=$lang_code?>"></td><?endforeach?><td width="100"><span class="css3-icon css3-icon-edit"><a href="javascript:void(0);" class="edit_tdata" code="NEW">Add</a></span></td></tr>').insertAfter("#tdata_caption");

                link = $j('a[code=NEW]');

                activate_tdata(link,update_url);

                $j(link).click(function(){
                    activate_tdata(this,update_url);
                });
            }
        });

        $j(".edit_tdata").click(function(){
            activate_tdata(this,update_url);
        });

        $j(".delete_tdata").click(function(){
            delete_tdata(this,delete_url);
        });

    });
</script>