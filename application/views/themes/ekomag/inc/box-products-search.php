<div id="search">
   <?=form_open($BC->_getBaseURL()."products/search")?>
        <?=form_input("keywords",trim(urldecode_compat(@$keywords)))?>
        <input type="submit" value="<?=language('search')?>" />
    </form>
</div>