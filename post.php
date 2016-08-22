<?php
include_once("rss.php");//引入rss.php
if(isset($_GET['uid']) and $_GET['uid']!="")
{
	$uppostpagesize="20";
	if(isset($_GET['pagesize']) and $_GET['pagesize']!="")
	{
		$uppostpagesize=$_GET['pagesize'];
	}
	$upid=$_GET['uid'];

	$uppost=json_decode(file_get_contents("http://www.aixifan.com/u/contributeList.aspx?pageNo=1&channelId=0&pageSize=".$uppostpagesize."&userId=".$upid),True);
	if($uppost['success']==False)
	{
		die("获取用户视频失败:".$uppost['result']);
	}
	if($uppost['totalcount']==0)
	{
		die("获取用户视频:没有视频");
	}
	$upname=$uppost['contents'][0]['username'];
	$upinfo=json_decode(file_get_contents("http://www.aixifan.com/usercard.aspx?username=".$upname),True);
	if($upinfo['success']==False)
	{
		die("获取用户信息失败:".$upinfo['result']);
	}
	$upregtime=$upinfo['userjson']['regTime'];
	$uppostlasttime=date('r',substr($uppost['contents'][0]['releaseDate'],0,10));
	$rss_title=$upname." 的视频";
	$rss_link="http://www.aixifan.com/u/".$upid.".aspx";
	$rss_description=$upinfo['userjson']['sign'];
	$rss_language="zh-cn";
	$rss_pubdate=$upregtime;
	$rss_lastbuilddate=$uppostlasttime;
	$posts=array();
	if($uppost['page']['totalCount']<$uppostpagesize)
	{
		$postnum=$uppost['page']['totalCount'];
	}
	else
	{
		$postnum=$uppostpagesize;
	}
	for($post_a=0;$post_a<$postnum;$post_a++)
	{
		$postlink="http://www.aixifan.com".$uppost['contents'][$post_a]['url'];
		$posttitle=$uppost['contents'][$post_a]['title'];
		$postdescription=$uppost['contents'][$post_a]['description'];
		$posttime=date('r',substr($uppost['contents'][$post_a]['releaseDate'],0,10));
		$post=array("title"=>$posttitle,"link"=>$postlink,"pubdate"=>$posttime,"description"=>$postdescription);
		array_push($posts,json_encode($post));
	}
	print_r (RssCreate($posts));
}
else
{
	die("缺少参数uid");
}

?>