<?php 
    require_once 'bookValley_server_config.php';
    /*响应用户查询书籍*/

   $userName = $_POST['userName'];


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

    /*
       准备要执行的插入操作
    */
    $sql_search = "SELECT readList.bookName FROM readList WHERE readList.userName = '$userName'";
    /*    
        执行查找操作
    */
    $sql_result = mysql_query($sql_search,$conn);
    if(!$sql_result)
    {
        die ("search failed : " . mysql_error());
    }
    else
    {         
        while ($info = mysql_fetch_array($sql_result, MYSQL_NUM))
        {
            echo $info[0] . " ";
        }
    }
     /*
       关闭连接
    */
    mysql_close($conn);
 

?>