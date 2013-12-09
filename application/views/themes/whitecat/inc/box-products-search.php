<div id="search">
    <div class="moduletable">
        <h3><?=language('search')?></h3>

       <?=form_open($BC->_getBaseURL()."products/search")?>
            <div class="search">
                <?=form_input("keywords",trim(urldecode(@$keywords)),"id='mod_search_searchword' class='inputbox'")?>
                <input type="submit" value="Search" class="button" onclick="this.form.searchword.focus();" />
            </div>
        </form>
    </div>
</div>