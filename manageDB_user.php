<?php 
    require_once 'bookValley_server_config.php';
    /*
        获取传输来的用户名与金币，积分之
    */
    $gold = 0;
    $score = 0;


    $userName = $_POST['userName'];
    $gold = $_POST['gold'];
    $score = $_POST['score'];

   
    $manageUserType = $_POST['manageUserType'];
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

    /*
       准备要执行的操作
    */
    if($manageUserType  == "changeGold")//更新金币操作
    {   
        $sql_update = "UPDATE user SET gold = '$gold' WHERE user.userName = '$userName'";
        mysql_query("set names utf8");
        $result_update = mysql_query($sql_update,$conn);
        if(!$result_update)
        {
            die("update failed:". mysql_error());
        }
        else
        {
            echo "update success!";
        }
    }
    else if($manageUserType == "changeScore")//更新积分操作
    {
        $sql_update = "UPDATE user SET score = '$score' WHERE user.userName = '$userName'";
        mysql_query("set names utf8");
        $result_update = mysql_query($sql_update,$conn);
        if(!$result_update)
        {
            die("update failed:". mysql_error());
        }
        else
        {
            echo "update success!";
        }
    }
    /*
       关闭连接
    */
    mysql_close($conn);
?>