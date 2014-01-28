<div class="fr">
    <?=form_open($BC->_getBaseURI())?>
        <?if(@$search_category_table):?>
            <div id="cs-boxes">
                <?=language('category')?>:

                <?if( $category_id = $BC->session->userdata($BC->_getCurrentTable().'_category')):?>
                    <?
                        $category_model = $search_category_table.'_model';
                        load_model($category_model);
                        $category = $BC->$category_model->getTitle($category_id);
                        echo $category;
                    ?>
                <?endif?>
            </div>
        <?endif?>
        <div>
            <?=language('search_by')?>:
            <?=form_dropdown("search_by",$BC->_buildTableFieldsArray($fields_names),$this->session->userdata($BC->_getCurrentTable().'_search_by'),"class='select'")?>
            <?=language('text')?>:
            <?=form_input("keyword",$this->session->userdata($BC->_getCurrentTable().'_keyword'),"class='input'");?>
            <?=form_submit("submit",language('search'));?>
            <input type="reset" value="<?=language('reset')?>" onclick="location.href='<?=site_url($BC->_getBaseURI()."/index/reset")?>'">
        </div>
    </form>
</div>

<?if(@$search_category_table && !$category_id):?>

    <?=load_inline_js('inc/js-load-category',array('parent_category'=>0))?>

    <script>
        $j(document).ready(function(){
            load_category(0,false,'<?=$search_category_table?>');
        });
    </script>

<?endif?>