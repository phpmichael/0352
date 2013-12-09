<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function youtube_box($url)
{
	$videodata = array('width'=>400,'height'=>300,'url'=>$url);
	
	//parse video urls of video (like url[width|height])
	$regexp = "/\[(\d+)\|(\d+)\]$/i";
	if(preg_match($regexp,$url,$matches))
	{
		$videodata['width'] = $matches[1];
		$videodata['height'] = $matches[2];
		$videodata['url'] = preg_replace($regexp,"",$url);
	}
	
	$videodata['url'] = str_replace('&','&amp;',$videodata['url']);
	            	
	//$video_url = str_replace("http://www.youtube.com/watch?v=","http://www.youtube.com/v/",$url);
	$video_url = preg_replace("#https?:\/\/(?:[a-zA_Z]{2,3}.)?(?:youtube\.com\/watch\?)((?:[\w\d\-\_\=]+&amp;(?:amp;)?)*v(?:&lt;[A-Z]+&gt;)?=([0-9a-zA-Z\-\_]+))#i","http://www.youtube.com/v/$2",$videodata['url']);
	
	//return '<object width="'.$videodata['width'].'" height="'.$videodata['height'].'"><param name="movie" value="' . $video_url . '"></param><param name="wmode" value="transparent"></param><embed src="' . $video_url . '" type="application/x-shockwave-flash" wmode="transparent" width="'.$videodata['width'].'" height="'.$videodata['height'].'"></embed></object>';
	return '<object type="application/x-shockwave-flash" style="width:'.$videodata['width'].'px; height:'.$videodata['height'].'px;" data="'.$video_url.'"><param name="movie" value="'.$video_url.'" /></object>';
}

function vimeo_box($url)
{
	$videodata = array('width'=>400,'height'=>300,'url'=>$url);
	
	//parse video urls of video (like url[width|height])
	$regexp = "/\[(\d+)\|(\d+)\]$/i";
	if(preg_match($regexp,$url,$matches))
	{
		$videodata['width'] = $matches[1];
		$videodata['height'] = $matches[2];
		$videodata['url'] = preg_replace($regexp,"",$url);
	}
	
	preg_match("[https?://(www\.)?vimeo\.com/(\d+)]i",$videodata['url'],$matches);
	$video_id = $matches[1];
	
	return '<iframe src="http://player.vimeo.com/video/'.$video_id.'?title=0&amp;byline=0&amp;portrait=0" width="'.$videodata['width'].'" height="'.$videodata['height'].'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
}

function show_embed_video(array $video)
{
	switch ($video['type_of_embed_video'])
	{
		case "youtube":
			return youtube_box($video['url']);
		break;
		
		case "vimeo":
			return vimeo_box($video['url']);
		break;
		
		default:
			return $video['embed_code'];
	}
}