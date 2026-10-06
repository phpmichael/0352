<?$page = $BC->pages_model->getByLink('orders/fill_customer_info');?>
<?if(isset($page['body']) && trim($page['body'])):?>
<div id="page">
    <h2 class="title"><span><span><?=$BC->_getPageTitle()?></span></span></h2>
    
    <div class="boxIndent">
        <div class="wrapper">
            <div class="content">
                <?=$page['body']?> 
            </div>
        </div>
     </div>
</div>

<br />
<?endif?>
 
<?fb_form("orders_customer_info",FALSE)?>