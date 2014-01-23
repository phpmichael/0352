<script>
    $j(document).ready(
        function()
        {
            //turn on all rights
            $j(".all-rights").click(function(){
                $j(":checkbox",$j(this).parents('.list')).check('on');
            });

            //turn off all rights
            $j(".none-rights").click(function(){
                $j(":checkbox",$j(this).parents('.list')).check('off');
            });

            //toogle all section rights
            $j(".section-rights").click(function(){
                $j(":checkbox[name='"+$j(this).attr('rel')+"[]']",$j(this).parents('.list')).check('toggle');
            });

            //toogle the same right for all sections
            $j(".right-type").click(function(){
                $j(":checkbox[value='"+$j(this).text()+"']",$j(this).parents('.list')).check('toggle');
            });

            $j(".section-right").click(function(){
                var name = $j(this).attr('name');
                var value = $j(this).val();
                var checked = $j(this).attr('checked');

                //if right "view" turn off then all other rights turn off
                if(value=='view' && checked!='checked')
                {
                    $j(":checkbox[name='"+name+"']").check('off');
                }
                //if any right turn on then "view" right turn on too
                else if(value!='view' && checked=='checked')
                {
                    $j(":checkbox[name='"+name+"']").filter("[value=view]").check('on');
                }
            });
        }
    );
</script>