<?php
     $conn=mysql_connect("localhost","root","") or die("数据库服务器连接错误".mysql_error());
     mysql_select_db("my_db",$conn) or die("数据库访问错误".mysql_error());
     mysql_query("set names gb2312");
?>