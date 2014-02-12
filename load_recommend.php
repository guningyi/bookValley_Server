<?php
	require_once 'bookValley_server_config.php';
	header("content-type:text/html; charset=utf-8"); //设置编码
	if (file_exists('bookStore/recommend/recommend.xml'))
	{
		$lists = simplexml_load_file("bookStore/recommend/recommend.xml");  
		foreach($lists->item as $item){     //有多个user，取得的是数组，循环输出
		echo $item->title;
		echo $item->brief;
    	}
	}


?>