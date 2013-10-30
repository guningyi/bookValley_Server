<?php
    require_once 'bookValley_server_config.php';
    /*响应用户查询书籍*/

    $dbName = $_POST['dbName'];



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
    $sql_delete_database = "drop  database '$dbName'";
    $delete_result = mysql_query($sql_delete_database,$conn);
    if(!$delete_result)
    {
        die ("delete database failed : " . mysql_error());
    }
    else
    {   
        echo "删除成功";
    }
     /*
       关闭连接
    */
    mysql_close($conn);
?>