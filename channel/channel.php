<?php
include_once("rss.php");//引入rss.php
if(isset($_GET['channel']) and $_GET['channel']!="")
{
	$cpagesize="20";
	$rss_title="Acfun的RSS";
	$rss_description=" ";
	if(isset($_GET['pagesize']) and $_GET['pagesize']!="")
	{
		$cpagesize=$_GET['pagesize'];
	}
	if(isset($_GET['title']) and $_GET['title']!="")
	{
		$rss_title=$_GET['title'];
	}
	if(isset($_GET['description']) and $_GET['description']!="")
	{
		$rss_description=$_GET['description'];
	}
	$cid=$_GET['channel'];
	$url="http://api.aixifan.com/searches/channel?pageNo=1&recommendSize=6&sort=4&pageSize=".$cpagesize."&channelIds=".$cid; 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, Array("deviceType: 2")); 
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$channelinfo=json_decode(curl_exec($ch),true);
	curl_close($ch);
	if($channelinfo['code']!=200)
	{
		die("Api错误(".$channelinfo['message'].")");
	}
	$rss_link="http://www.acfun.tv/v/list".$cid."/index.htm";
	$rss_language="zh-cn";
	$rss_pubdate="";
	$rss_lastbuilddate=date('r', substr($channelinfo['data']['list'][0]['releaseDate'],0,10));
	$lists=array();	
	for($item_aa=0;$item_aa<$cpagesize;$item_aa++)
	{
		$item_title=$channelinfo['data']['list'][$item_aa]['title'];
		$item_description=$channelinfo['data']['list'][$item_aa]['description'];
		$item_pubdate=date('r', substr($channelinfo['data']['list'][$item_aa]['releaseDate'],0,10));
		if($channelinfo['data']['list'][$item_aa]['isArticle']==1)
		{
			$item_url="http://www.acfun.tv/a/ac".$channelinfo['data']['list'][$item_aa]['contentId'];
		}
		else
		{
			$item_url="http://www.acfun.tv/v/ac".$channelinfo['data']['list'][$item_aa]['contentId'];
		}
		$list=array("title"=>$item_title,"link"=>$item_url,"pubdate"=>$item_pubdate,"description"=>$item_description);
		array_push($lists,json_encode($list));
	}
	
	print_r(RssCreate($lists));
}
else
{
	die("缺少参数channel");
}

?>
