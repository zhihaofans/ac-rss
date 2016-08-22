<?php
$rss_title="";
$rss_link="";
$rss_description="";
$rss_language="zh-cn";
$rss_pubdate="";
$rss_lastbuilddate="";
function RssCreate($items)
{
	header("Content-type:text/xml");
	global $rss_title,$rss_link,$rss_description,$rss_language,$rss_pubdate,$rss_lastbuilddate;
	$rss="<?xml version=\"1.0\"?>\n";
	$rss.="<rss version=\"2.0\">\n";
	$rss.="   <channel>\n";
	$rss.="      <title>".$rss_title."</title>\n";
	$rss.="      <link>".$rss_link."</link>\n";
	$rss.="      <description>".$rss_description."</description>\n";
	$rss.="      <language>".$rss_language."</language>\n";
	$rss.="      <pubDate>".$rss_pubdate."</pubDate>\n";
	$rss.="      <lastBuildDate>".$rss_lastbuilddate."</lastBuildDate>\n";
	$rss.="      <docs>http://blogs.law.harvard.edu/tech/rss</docs>\n";
	$rss.="      <generator>http://zhihaofans.com</generator>\n";
	$item_num=count($items);
	for($item_a=0;$item_a<$item_num;$item_a++)
	{
		$item=array();
		$item=json_decode($items[$item_a],True);
		$rss.="      <item>\n";
		$rss.="         <title>".$item['title']."</title>\n";
		$rss.="         <link>".$item['link']."</link>\n";
		$rss.="         <description>".$item['description']."</description>\n";
		$rss.="         <pubDate>".$item['pubdate']."</pubDate>\n";
		$rss.="         <guid isPermaLink=\"true\">".$item['link']."</guid>\n";
		$rss.="      </item>\n";
	}
	$rss.="   </channel>\n";
	$rss.="</rss>\n";
	return $rss;
}


?>