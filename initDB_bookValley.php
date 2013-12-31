<?php
    
    require_once 'bookValley_server_config.php';
    /*
      连接mysql服务器器
      要求输入服务器的地址,用户名，密码
    */
    $conn = mysql_connect(DEFAULT_HOST,DEFAULT_USER,DEFAULT_PASS);
    if (!$conn) //假如连接失败
    {
        die('Could not connect: ' . mysql_error());
    }
    /*
        如果连接上了mysql服务器，先创建数据库。
        mysql服务器 > 数据库 > 表
    */
    if (!mysql_select_db("bookValley", $conn))//判断表是否存在
    {
	    if (mysql_query("CREATE DATABASE bookValley",$conn))
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
    $db_selected = mysql_select_db("bookValley", $conn);
    if(!$db_selected)
    {
        die ("Can't use bookValley : " . mysql_error());
    }
   /*
       在bookValley下创建 user 表
   */
   $sql_user = "CREATE TABLE user(
      id   INTEGER(50) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   	  userName VARCHAR(100) NOT NULL,
      passWord CHAR(100) NOT NULL,
   	  gold INTEGER(50) NOT NULL DEFAULT 0,
   	  score INTEGER(50) NOT NULL DEFAULT 0) ";
   /*
       执行创建表的操作
   */

   $result_user = mysql_query($sql_user,$conn);
   if (!$result_user)
   {
   	 die("Can't create tabel:". mysql_error());
   }
   else
   {
   	 echo "create table success!";
   }

   /*
      创建bookStore表
   */
    $sql_bookStore = "CREATE TABLE bookStore(
    id   INTEGER(50) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   	bookName VARCHAR(100) NOT NULL,
    bookCatagory INTEGER(20) DEFAULT 0,
    bookPrice INTEGER(50) DEFAULT 0,
    bookGrade INTEGER(50) DEFAULT 0,  
    bookDownloadTimes INTEGER(50) DEFAULT 0)";
   /*
       执行创建表的操作
   */

   $result_bookStore = mysql_query($sql_bookStore,$conn);
   if (!$result_bookStore)
   {
   	 die("Can't create tabel:". mysql_error());
   }
   else
   {
   	 echo "create table success!";
   }

    /*
      创建readList表
   */
    $sql_readList = "CREATE TABLE readList(
    userId   INTEGER(50) NOT NULL PRIMARY KEY,
    userName VARCHAR(100) NOT NULL,
   	bookName VARCHAR(100) NOT NULL,
    bookCatagory INTEGER(20) NOT NULL DEFAULT 0,
    bookPrice INTEGER(50) NOT NULL DEFAULT 0)";
    
   /*
       执行创建表的操作
   */
   $result_readList = mysql_query($sql_readList,$conn);
   if (!$result_readList)
   {
   	 die("Can't create tabel:". mysql_error());
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