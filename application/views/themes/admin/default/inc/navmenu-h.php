<?if($BC->_is_logged()):?>

<div id="menu-left">

  <ul id="navmenu-h">
  
    <li><?=anchor_base('dashboard',language('logged_as').": ".$BC->session->userdata('customer_name'))?>
    
        <ul>
        
            <!--<li><?=$BC->buildLeftMenuItem('dashboard','dashboard')?></li>-->
            
            <li><?=$BC->buildLeftMenuItem('managers/signout','logout')?></li>
        
        </ul>
    
    </li>
    
    <?if(userAccess('settings','edit')):?>
    <li><?=$BC->buildLeftMenuItem('settings','settings')?></li>
    <?endif?>
    
    <?if(userAccessSomeOf(array('pages','articles','news','links','faq','testimonials','videos','slideshow'),'view')):?>
    <li><a href="javascript:void(0)"><?=language('content')?></a>
    
      <ul>
      
        <?if(userAccess('pages','view')):?>
        <li><?=$BC->buildLeftMenuItem('pages','pages')?></li>
        <?endif?>
        
        <?if(userAccess('articles','view')):?>
        <li><?=$BC->buildLeftMenuItem('articles','articles')?></li>
        <?endif?>
        
         <?if(userAccess('articles_categories','view')):?>
        <li><?=$BC->buildLeftMenuItem('articles_categories','articles_categories')?></li>
        <?endif?>
        
        <?if(userAccess('news','view')):?>
        <li><?=$BC->buildLeftMenuItem('news','news')?></li>
        <?endif?>
        
        <?if(userAccess('links','view')):?>
        <li><?=$BC->buildLeftMenuItem('links','links')?></li>
        <?endif?>
        
        <?if(userAccess('faq','view')):?>
        <li><?=$BC->buildLeftMenuItem('faq','faq')?></li>
        <?endif?>
        
        <?if(userAccess('testimonials','view')):?>
        <li><?=$BC->buildLeftMenuItem('testimonials','testimonials')?></li>
        <?endif?>
        
        <?if(userAccess('videos','view')):?>
        <li><?=$BC->buildLeftMenuItem('videos','videos')?></li>
        <?endif?>
        
        <?if(userAccess('slideshow','view')):?>
        <li><?=$BC->buildLeftMenuItem('slideshow','slideshow')?></li>
        <?endif?>
      
      </ul>
      
    </li>
    <?endif?>
    
    <?if(userAccessSomeOf(array('auto_responders','subscribers'),'view') || userAccess('newsletters','send')):?>
    <li><a href="javascript:void(0)"><?=language('email')?></a>
    
      <ul>
      
        <?if(userAccess('auto_responders','view')):?>
        <li><?=$BC->buildLeftMenuItem('auto_responders','auto_responders')?></li>
        <?endif?>
      
        <?if(userAccess('newsletters','send')):?>
        <li><?=$BC->buildLeftMenuItem('newsletters/send','mass_mail')?>
        
            <ul>
            
                <li><?=$BC->buildLeftMenuItem('newsletters','queue')?></li>
            
            </ul>
        
        </li>
        <?endif?>
        
        <?if(userAccess('subscribers','view')):?>
        <li><?=$BC->buildLeftMenuItem('subscribers','subscribers')?></li>
        <?endif?>
        
        <li><?=$BC->buildLeftMenuItem('email_tpl_vars','vars_for_templates')?></li>
      
      </ul>
      
    </li>
    <?endif?>
    
    <?if(userAccess('customers','view')):?>
    <li><?=$BC->buildLeftMenuItem('customers','users')?>
    
        <ul>
        
            <?if(userAccess('groups','view')):?>
            <li><?=$BC->buildLeftMenuItem('groups','groups')?></li>
            <?endif?>
        
        </ul>
    
    </li>
    <?endif?>
    
    <?if(userAccessSomeOf(array('products','orders','shipping','currency','discounts','discount_coupons'),'view')):?>
    <li><a href="javascript:void(0)"><?=language('shop')?></a>
    
      <ul>
      
        <?if(userAccess('products','view')):?>
        <li><?=$BC->buildLeftMenuItem('products','products')?>
        
            <ul>
            
                <?if(userAccess('products_categories','view')):?>
                <li><?=$BC->buildLeftMenuItem('products_categories','products_categories')?></li>
                <?endif?>
                
                <?if(userAccess('products_manufacturers','view')):?>
                <li><?=$BC->buildLeftMenuItem('products_manufacturers','manufacturers')?></li>
                <?endif?>
                
                <?if(userAccess('products_attributes','view')):?>
                <li><?=$BC->buildLeftMenuItem('products_attributes','products_attributes')?></li>
                <?endif?>
            
            </ul>
        
        </li>
        <?endif?>
        
        <?if(userAccess('orders','view')):?>
        <li><?=$BC->buildLeftMenuItem('orders','orders')?></li>
        <?endif?>
        
        <?if(userAccess('shipping','view')):?>
        <li><?=$BC->buildLeftMenuItem('shipping','shipping')?></li>
        <?endif?>
        
        <?if(userAccess('currency','view')):?>
        <li><?=$BC->buildLeftMenuItem('currency','currency')?></li>
        <?endif?>
        
        <?if(userAccess('discounts','view')):?>
        <li><?=$BC->buildLeftMenuItem('discounts','discounts')?></li>
        <?endif?>
        
        <?if(userAccess('discount_coupons','view')):?>
        <li><?=$BC->buildLeftMenuItem('discount_coupons','discount_coupons')?></li>
        <?endif?>
        
      </ul>
      
    </li>
    <?endif?>
    
    <?if(userAccessSomeOf(array('companies','categories'),'view')):?>
    <li><a href="javascript:void(0)"><?=language('catalog')?></a>
    
      <ul>
      
        <?if(userAccess('companies','view')):?>
        <li><?=$BC->buildLeftMenuItem('companies','companies')?></li>
        <?endif?>
        
        <?if(userAccess('categories','view')):?>
        <li><?=$BC->buildLeftMenuItem('categories','categories')?></li>
        <?endif?>
      
      </ul>
      
    </li>
    <?endif?>
    
    <?if(userAccess('photos','view')):?>
    <li><?=$BC->buildLeftMenuItem('photos','photos')?>
    
        <ul>
        
            <?if(userAccess('photos_categories','view')):?>
            <li><?=$BC->buildLeftMenuItem('photos_categories','photo_categories')?></li>
            <?endif?>
        
        </ul>
    
    </li>
    <?endif?>
    
    <?if(userAccess('agenda','view')):?>
    <li><?=$BC->buildLeftMenuItem('agenda','agenda')?></li>
    <?endif?>
    
    <?if(userAccess('quiz','view')):?>
    <li><?=$BC->buildLeftMenuItem('quiz','quiz_list')?></li>
    <?endif?>
    
    <?if(userAccess('poll','view')):?>
    <li><?=$BC->buildLeftMenuItem('poll','poll_list')?></li>
    <?endif?>
    
    <?if(userAccess('tools','view')):?>
    <li><a href="javascript:void(0)"><?=language('tools')?></a>
    
      <ul>
      
        <li><?=anchor_base('tools/check_project_config','Check project configuration')?></li>
        
      </ul>
    
    </li>
    <?endif?>
    
    <?if(userAccessSomeOf(array('comments','lang_codes','filters','formbuilder','reports','spiderweb'),'view')):?>
    <li><a href="javascript:void(0)"><?=language('other1')?></a>
    
      <ul>
      
        <?if(userAccess('comments','view')):?>
        <li><?=$BC->buildLeftMenuItem('comments','comments')?></li>
        <?endif?>
        
        <?if(userAccess('lang','view')):?>
        <li><?=$BC->buildLeftMenuItem('lang','lang_codes')?></li>
        <?endif?>
        
        <?if(userAccess('filters','view')):?>
        <li><?=$BC->buildLeftMenuItem('filters','filters')?></li>
        <?endif?>
        
        <?if(userAccess('formbuilder','view')):?>
        <li><?=$BC->buildLeftMenuItem('formbuilder','formbuilder')?></li>
        <?endif?>
        
        <?if(userAccess('reports','view')):?>
        <li><?=$BC->buildLeftMenuItem('reports','reports')?></li>
        <?endif?>
        
        <?if(userAccess('spiderweb','view')):?>
        <li><?=$BC->buildLeftMenuItem('spiderweb','spiderweb')?></li>
        <?endif?>

      </ul>
      
    </li>
    <?endif?>
   
  </ul>
  
</div>
<?endif?>