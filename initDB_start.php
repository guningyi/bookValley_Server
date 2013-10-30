<?php 
    /*
        本例程给出一个标准的基本数据库初始化模板
    */
    /*
      连接mysql服务器器
      要求输入服务器的地址,用户名，密码
    */
    $conn = mysql_connect("localhost","root","");
    if (!$conn) //假如连接失败
    {
        die('Could not connect: ' . mysql_error());
    }
    /*
        如果连接上了mysql服务器，先创建数据库。
        mysql服务器 > 数据库 > 表
    */
    if (!mysql_select_db("study_db", $conn))//判断表是否存在
    {
	    if (mysql_query("CREATE DATABASE study_db",$conn))
	    {
	        echo "Database created";
	    }
	    else
	    {
	        echo "Error creating database: " . mysql_error();
	    }
    }

    /*
        设置活动数据库,输入参数，数据库名，连接
        如果设置成功，返回true
                失败，返回false
    */
    $db_selected = mysql_select_db("study_db", $conn);
    if(!$db_selected)
    {
        die ("Can\'t use study_db : " . mysql_error());
    }
   /*
    准备一个变量$sql,存储创建表的语句
    当然也可以像创建数据库时直接放进mysql_query()中。
    但创建表的操作一般比较长，所以独立出来，先构造字符串
    表名为 text， 表项为name
   */
   $sql = "CREATE TABLE text(name VARCHAR(100))";
   /*
       执行创建表的操作
   */
   $result = mysql_query($sql,$conn);
   if (!$result)
   {
   	 die("Can\'t create tabel:". mysql_error());
   }
   else
   {
   	 echo "create table success!";
   }
   /*
       关闭连接
   */
   mysql_close($conn);

?>