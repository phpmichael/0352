<?=form_open($BC->_getBaseURL()."products/search")?>
    <div class="form-search">
        <label for="search"><?=language('search')?>:</label> 
        <?=form_input("keywords",trim(urldecode(@$keywords)),"class='input-text'")?>
        <button type="submit" title="Search" class="button"><span><span>Search</span></span></button>
    </div>
</form>