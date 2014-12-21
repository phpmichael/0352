<div class="search-box clearfix">
    <?=form_open($BC->_getBaseURL()."books/search")?>
    <?=form_input("keywords",trim(urldecode(@$keywords)),"placeholder='Яку книгу ви шукаєте?'")?>
    <input type="submit" value="<?=language('search')?>" />
    </form>
</div>