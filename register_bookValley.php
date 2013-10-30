<?php 
   require_once 'bookValley_server_config.php';
   /*响应新用户注册*/
   $userName = $_POST['userName'];
   $passWord = $_POST['passWord'];
   $gold = 0;
   $score = 0;


   /*对新用户提交的信息进行检测*/
   //注册信息判断
   if(!preg_match('/^[\w\x80-\xff]{3,15}$/', $userName))
   {
       exit('错误：用户名不符合规定。<a href="javascript:history.back(-1);">返回</a>');
   }
   if(strlen($passWord) < 6)
   {
       exit('错误：密码长度不符合规定。<a href="javascript:history.back(-1);">返回</a>');
   }

    /*manageDB_bookValley*/
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
    if (!mysql_select_db("bookValley", $conn))//判断数据库是否存在
    {
	    die('database not exist: ' . mysql_error());
    }

    /*
        设置活动数据库,输入参数，数据库名，连接
        如果设置成功，返回true
                失败，返回false
    */
    $db_selected = mysql_select_db("bookValley", $conn);
    if(!$db_selected)
    {
        die ("database exist, but it could not be used : " . mysql_error());
    }

    $sql_check = "SELECT user.userName FROM user WHERE user.userName = '$userName'";
    $result_query = mysql_query($sql_check,$conn);
    if(mysql_fetch_array($result_query))
    {
        echo $userName."已存在";
        return;
    }
    /*明文密码加密*/
    $passWord = md5($passWord);


    /*
       准备要执行的插入操作
    */
    $sql_insert = "INSERT INTO user (id,userName, passWord,gold, score) VALUES (NULL,'$userName', '$passWord', '$gold', '$score')";
    /*
       执行插入操作
    */
    $result_insert = mysql_query($sql_insert,$conn);
    /*
        检查操作结果
    */
    if(!$result_insert)
    {
        echo "抱歉！注册失败";
   	    die("failed". mysql_error());
    }
    else
    {
        echo "用户注册成功！";
    }
    /*
       关闭连接
    */
    mysql_close($conn);

?>