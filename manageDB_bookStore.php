<?php
    require_once 'bookValley_server_config.php';
    /*
        获取传输来的书名与编号
    */
    $bookName = $_POST['bookName'];
    $id = $_POST['id'];
    $catagory = $_POST['catagory'];
    $price = $_POST['price'];

    $manageBookStoreType = $_POST['manageBookStoreType'];
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
    if ($manageBookStoreType == "addBookIntoBookStore")//插入操作
    {
        $sql_insert = "INSERT INTO bookStore (id, bookName, bookCatagory, bookPrice) VALUES ('$id', '$bookName', '$catagory', '$price')";
        /*
          执行插入操作
        */
        mysql_query("set names utf8");
        //mysql_query("set names gb2312");
        $result_insert = mysql_query($sql_insert,$conn);
        /*
            检查操作结果
        */
        if(!$result_insert)
        {
            die("insert failed:". mysql_error());
        }
        else
        {
            echo "insert success!";
        }
    }
    else if($manageBookStoreType == "updateBookIntoBookStore")//更新操作
    {
        $sql_update = "UPDATE bookStore SET id = '$id' WHERE bookStore.bookName = '$bookName'";
        mysql_query("set names utf8");
        $result_insert = mysql_query($sql_update,$conn);
        if(!$result_insert)
        {
            die("update failed:". mysql_error());
        }
        else
        {
            echo "update success!";
        }
    }
    else if($manageBookStoreType == "deleteBookFromBookStore")//删除操作
    {
        $sql_delete = "DELETE FROM bookStore WHERE bookStore.bookName = '$bookName'";
        mysql_query("set names utf8");
        $result_insert = mysql_query($sql_delete,$conn);
        if(!$result_insert)
        {
            die("delete failed:". mysql_error());
        }
        else
        {
            echo "delete success!";
        }
    }
    /*
       关闭连接
    */
    mysql_close($conn);

?>