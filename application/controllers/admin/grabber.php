<?php
require_once(APPPATH.'controllers/abstract/admin.php');

/** 
 * This is admin controller for parsing.
 * 
 * @package grabber  
 * @author Michael Kovalskiy
 * @version 2012
 * @access public
 */
class Grabber extends Admin 
{
	
    /**
	 * Init models, set pages' titles, fields' titles, set languages' sections.
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		// === Check is logged manager === //
		$this->_CheckLogged();
		
		// === Load Models === //
		$this->load->model(array('articles_model','tags_model'));
		
		// === Init Language Section === //
		$this->lang_model->init(array('label','admin'));
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	/**
	 * Build rigth top admin menu.
	 * Overrides parent method.
	 * 
	 * @return string
	 */
	public function _built_right_menu()
	{
		return "";
	}

	// +++++++++++++ INNER METHODS +++++++++++++++ //
	
	// +++++++++++++ ACTION METHODS +++++++++++++++ //
	
	/**
	 * Main action.
	 *
	 */
	public function Index()
	{
		
	}
	
	public function about_com_articles()
	{
	    /*
	    select *, count(id) as amount from articles group by source having amount>1 order by amount desc
	    */
		
		$domain = "http://cancer.about.com";
	    $url = "http://cancer.about.com/od/vulvarcancer/Vulvar_CancerAbout_Cancer_of_the_Vulva.htm";
	    $category = array(7,65);
	    
	    $ch = curl_init($url);
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	    $result = $ch = curl_exec($ch);
	    
	    preg_match_all("[<h2><a\s[^>]*href=[\"']([^\"]+)[\"'][^>]*>(.*)</a></h2>]isU",$result,$matches);
	    //dump($matches);
	    
	    foreach ($matches[1] as $link)
	    {
	        if(stristr($link,"http://")) continue;
	        $this->about_com_article($domain.$link,$category);
	        //dump($domain.$link);
	    }
	}
	
	public function about_com_article($url,$category)
	{
	    //$url = "http://cancer.about.com/od/cancerfactsandstatistics/a/deathdecline.htm";
	    //$url = "http://cancer.about.com/od/cancerfactsandstatistics/a/baby_products.htm";
	    $ch = curl_init($url);
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	    $result = $ch = curl_exec($ch);
	    
	    $post['source'] = $url;
	    
	    //head
	    preg_match("[<h1[^>]*>(.*)</h1>]isU",$result,$matches);
	    $post['head']['EN'] = strip_tags(@$matches[1]);
	    
	    if(!$post['head']['EN']) return false;
	    
	    //meta_keywords
	    preg_match("[<div class=[\"']h4[\"']>See More About:</div><ul>(.+)</ul>]isU",$result,$matches);
	    if(!@$matches[1]) $post['meta_keywords']['EN'] = '';
	    else 
	    {
	        preg_match_all("[<li><a\s[^>]*rel=[\"']nofollow[\"']>(.*)</a></li>]isU",$matches[1],$submatches);
	        $post['meta_keywords']['EN'] = join(",",@$submatches[1]);
	    }
	    
	    //meta_description
	    preg_match("[<h2>(.*)</h2>]isU",$result,$matches);
	    $post['meta_description']['EN'] = (string)@$matches[1];
	    
	    preg_match("[<a\s[^>]*rel=[\"']author[\"']>(.*)</a>]isU",$result,$matches);
	    $post['author']['EN'] = (string)@$matches[1];
	    
	    preg_match("[<(p|div) id=[\"']date[\"']>(.*)</\\1>]isU",$result,$matches);
	    $post['source_date'] = (string)@$matches[2];
	    
	    preg_match("[<div id=[\"']articlebody[\"']>(.*)</div>\s*<div id=[\"']coda[\"']]is",$result,$matches);
	    $post['body']['EN'] = $matches[1];
	    $post['body']['EN'] = preg_replace("[<(p|div) id=[\"']date[\"']>(.*)</\\1>]","",$post['body']['EN']);
	    
	    $post['slug']['EN'] = $this->articles_model->doSlug($post['head']['EN']);
	    
	    $post['category'] = $category;
	    
	    $post['date'] = date("Y-m-d H:i:s");
	    
	    //add article
	    $article_id = $this->articles_model->insertOrUpdate($post,$post['category']);
	    
	    //add tags
	    $this->tags_model->Insert("articles",$article_id,$post['meta_keywords']['EN']);
	    
	    dump($post);
	}
	
    private function generate_keywords($string)
    {
          $stopWords = array('i','a','about','an','and','are','as','at','be','by','com','de','en','for','from','how','in','is','it','la','of','on','or','that','the','this','to','was','what','when','where','who','will','with','und','the','www');
       
          
          $string = trim($string); // trim the string
          $string = strip_tags($string); // remove html tags
          $string = preg_replace('/[^a-zA-Z_йцукенгшщзхїфівапролджєячсмитьбюъыэЙЦУКЕНГШЩЗХЇФІВАПРОЛДЖЄЯЧСМИТЬБЮЪЫЭ\'-]/', ' ', $string); // only take alphanumerical characters, but keep the spaces and dashes too…
          //dump($string);//exit;
          $string = preg_replace('/\s{2,}/i', ' ', $string); // replace whitespace
          //dump($string);exit;
          //$string = strtolower($string); // make it lowercase
       
          //preg_match_all('/\b.*?\b/i', $string, $matchWords);
          //preg_match_all('/(\S+\s){2}/i', $string, $matchWords);
          $matchWords = explode(' ',$string);
          //dump($matchWords);exit;
          //$matchWords = $matchWords[0];
          
          foreach ( $matchWords as $key=>$item ) {
              if ( $item == '' || in_array(strtolower($item), $stopWords) || strlen($item) <= 3 ) {
                  unset($matchWords[$key]);
              }
          }   
          $wordCountArr = array();
          if ( is_array($matchWords) ) {
              foreach ( $matchWords as $key => $val ) {
                  //$val = strtolower($val);
                  if ( isset($wordCountArr[$val]) ) {
                      $wordCountArr[$val]++;
                  } else {
                      $wordCountArr[$val] = 1;
                  }
              }
          }
          arsort($wordCountArr);
          $wordCountArr = array_slice($wordCountArr, 0, 20);
          return $wordCountArr;
    }
    
    public function keywords()
    {
        if(@$_POST['keywords'])
        {
            //dump(mb_strlen('за'));exit;
            //dump($this->generate_keywords($_POST['keywords']));
            $this->load->library('keywords_lib');
            dump($this->keywords_lib->generate($_POST['keywords'],4));
        }
        
        {
            echo "
            <form action='' method='post'>
            <textarea name='keywords' cols='100' rows='20'>".@$_POST['keywords']."</textarea>
            <input type='submit' />
            </form>
            ";
        }
    }
    
    public function spiderweb()
    {
    	$this->load->model('spiderweb_model');
    	$this->spiderweb_model->parse('articles');
    	
    	//$sp = $this->spiderweb_model->get("link like 'http://cancer.about.com%'",'pub_date','asc',1000);
    	
    	/*$this->load->model('articles_model');
    	foreach ($sp as $s)
    	{
    	    $article = $this->articles_model->getOneByUnique('source',$s['link']);
    	    
    	    dump("---------------------------------------------------------------------------------");
    	    dump($s['link']);
    	    if($article) 
    	    {
    	        $s['link'] = 'articles/name/'.$article['slug'];
    	        $this->spiderweb_model->update($s);
    	        
    	        dump('articles/name/'.$article['slug']);
    	    }
    	    else 
    	    {
    	        dump('NO');
    	    }
    	}
    	exit;*/
    	
    	/*$this->load->model('articles_categories_model');
    	
    	foreach ($sp as $s)
    	{
    	    //if(stristr($s['link'],'.htm')) continue;
    	    if(!stristr($s['link'],'index.htm')) continue;
    	    if(stristr($s['link'],'Skin-Cancer-Photo-Gallery')) continue;
    	    
    	    //$category = $this->articles_categories_model->getOneByUnique('lang_gen_category.EN',$s['title']);
    	    $res = $this->articles_categories_model->get('lang_gen_category.EN like "%'.mysql_escape_string($s['title']).'%"');
    	    $category = @$res[0];
    	    
    	    if($category) 
    	    {
    	        //$s['link'] = 'articles/index/category/'.$category['id'];
    	        //$this->spiderweb_model->update($s);
    	        
    	        dump("---------------------------------------------------------------------------------");
    	        dump($s['link']);
    	        dump($category['category']);
    	        dump('articles/index/category/'.$category['id']);
    	    }
    	    else 
    	    {
    	        //dump('NO');
    	    }
    	}*/
    	
    	
    	/*$sp = $this->spiderweb_model->get("link like 'articles/%160%'",'pub_date','asc',1000);
    	
    	foreach ($sp as $s)
    	{
    	    $s['link'] = str_replace("160","-",$s['link']);
    	    $this->spiderweb_model->update($s);
    	}*/
    }

}