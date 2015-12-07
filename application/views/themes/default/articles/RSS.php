<?
// ==== Content-Type for all browsers - application/rss+xml, IE6 - text/xml === //
if(strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 6")) header("Content-type: text/xml; charset=UTF-8");
else header("Content-type: application/rss+xml; charset=UTF-8");
// ==== Content-Type for all browsers - application/rss+xml, IE6 - text/xml === //
$site_url = base_url();
?>
<?echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n"?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	>

<channel>

	<title><?=htmlspecialchars($head['page_title'])?></title>
	<description><?=htmlspecialchars($head['meta_description'])?></description>
	<link><?=htmlspecialchars(site_url($BC->_getBaseURI()))?></link>
	<atom:link href="<?=htmlspecialchars(site_url($BC->_getBaseURI().'/RSS'))?>" rel="self" type="application/rss+xml" />
	
	<?foreach ($posts_list as $key=>$record):?>
	
	<item>
		<title><?=htmlspecialchars($record->head)?></title>
		<description><![CDATA[<?=character_limiter(strip_tags($record->body,260))?>]]></description>
        <content:encoded><![CDATA[<?=$record->body?>]]></content:encoded>
		<link><?=htmlspecialchars(site_url($BC->_getBaseURI().'/details/'.$record->id))?></link>
		<guid isPermaLink="true"><?=htmlspecialchars(site_url($BC->_getBaseURI().'/details/'.$record->id))?></guid>
		<pubDate><?=date('D, d M Y H:i:s',strtotime($record->pub_date)).' GMT'?></pubDate>
	</item>
	
	<?endforeach?>

</channel>
</rss>