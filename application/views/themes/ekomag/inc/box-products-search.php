<div id="search">
   <?=form_open($BC->_getBaseURL()."products/search")?>
        <?=form_input("keywords",trim(urldecode(@$keywords)))?>
        <input type="submit" value="<?=language('search')?>" />
    </form>
</div>