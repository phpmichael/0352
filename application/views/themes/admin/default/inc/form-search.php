<div class="fr">
    <?=form_open($BC->_getBaseURI())?>
        <table>
            <tbody>
                <tr>
                	<td><?=language('search_by')?>: </td>
                	<td><?=form_dropdown("search_by",$BC->_buildTableFieldsArray($fields_names),$this->session->userdata($BC->_getCurrentTable().'_search_by'),"class='select'")?></td>
                	<td><?=language('text')?>:</td>
                	<td><?=form_input("keyword",$this->session->userdata($BC->_getCurrentTable().'_keyword'),"class='input'");?></td>
                	<td><?=form_submit("submit",language('search'));?></td>
                	<td><input type="reset" value="<?=language('reset')?>" onclick="location.href='<?=site_url($BC->_getBaseURI()."/index/reset")?>'"></td>
                </tr>
            </tbody>
        </table>
    </form>
</div>