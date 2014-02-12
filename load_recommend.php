<?php
	require_once 'bookValley_server_config.php';
	echo "php读取XML文件 <br>";
	eader("content-type:text/html; charset=utf-8"); //设置编码
	lists = simplexml_load_file('bookStore/recommend/recommend.xml');  //载入xml文件 $lists和xml文件的根节点是一样的  
	foreach($lists->item as $item){     //有多个user，取得的是数组，循环输出
	echo $item->title $item->brief;
}


?>