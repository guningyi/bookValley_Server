<?php 
    $lifeTime = 1; 
    session_set_cookie_params($lifeTime); 
    session_start();
    
    require_once 'bookValley_server_config.php';
    /*处理用户登录*/
	
    /*对传来的参数做基本的检查*/
    $userName = (isset($_POST['userNameLogin'])) ? trim($_POST['userNameLogin']) : '';
    $passWord = (isset($_POST['passWordLogin'])) ? $_POST['passWordLogin'] : '';

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

    $passWord = md5($passWord);
    
    
    $sql_query = "SELECT user.userName ,  user.passWord FROM user
                  WHERE user.userName = '$userName' 
                  AND user.passWord = '$passWord' ";
    

    
    /*
    $sql_query  = 'SELECT * FROM user WHERE ' .
         'userName = "' . mysql_real_escape_string($userNameLogin, $conn) . '" AND ' .
         'passWord = "' . mysql_real_escape_string($passWordLogin, $conn) . '" ';
    */

    /*
       执行查找操作
    */
    $result_query = mysql_query($sql_query,$conn);
    /*
        检查操作结果
    */

    if (mysql_num_rows($result_query ) > 0)
    {
        $row = mysql_fetch_assoc($result_query);
        $_SESSION['userNameLogin'] = $userName;
        $_SESSION['logged'] = 1;
        echo "登录成功";
        mysql_free_result($result_query);
    }
    else
    {
        // set these explicitly just to make sure
        $_SESSION['userNameLogin'] = '';
        $_SESSION['logged'] = 0;
        echo "登录失败";
        mysql_free_result($result_query);
    }
    mysql_close($conn);
    die();
 

?>