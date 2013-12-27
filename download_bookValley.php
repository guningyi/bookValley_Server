<?php 
    require_once 'bookValley_server_config.php';
    /*用于响应客户端发来的下载书籍请求*/

    $bookName = $_POST['downloadBookName'];
    $userName = $_POST['downloadUserName'];


    $bookPrice = 0;
    $userGold = 0;
    $gold = 0;

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
    $sql_search = "SELECT bookStore.bookName FROM bookStore WHERE bookStore.bookName = '$bookName'";
    /*    
        执行查找操作
    */
    $sql_result = mysql_query($sql_search,$conn);
    
    if(!$sql_result)//这里是检查数据库中是否有登记此书
    {
    	echo "数据库查询:没有你要下载的书籍";
        die ("search failed : " . mysql_error());
    }
    else
    {
        //根据用户名去判断用户的金币数是否大于下载的书的价格
        $sql_bookPrice = "SELECT bookStore.bookPrice FROM bookStore WHERE bookStore.bookName = '$bookName'";
        $sql_bookPrice_result = mysql_query($sql_bookPrice,$conn);
        if (!$sql_bookPrice_result)
        {
            header('HTTP/1.1 201 NOK'); 
        	echo "价格查询失败";
        	die ("search failed : " . mysql_error());
        }
        else
        {
        	$priceInfo = mysql_fetch_array($sql_bookPrice_result);
	        if ($priceInfo == null)
	        {
                header('HTTP/1.1 201 NOK'); 
	            echo "价格错误";
                mysql_close($conn);
                exit();
	        }
	        else
	        {
	            $bookPrice = $priceInfo;
	        } 
	        //查询用户的金币数 	
        	$sql_userGold = "SELECT user.gold FROM user WHERE user.userName = '$userName'";
            $sql_userGold_result = mysql_query($sql_userGold,$conn);
            if (!$sql_userGold_result)
	        {
                header('HTTP/1.1 201 NOK'); 
	        	echo "用户金币查询失败";
	        	die ("search failed : " . mysql_error());
	        }
	        else
	        {
	        	$goldInfo = mysql_fetch_array($sql_userGold_result);
	            if ($goldInfo == null)
		        {
                    header('HTTP/1.1 201 NOK'); 
		            echo "金币错误";
                    mysql_close($conn);
                    exit();
		        }
		        else
		        {
		            $userGold = $goldInfo;
		        } 
	        }
	        if ($userGold < $bookPrice)
	        {
                header('HTTP/1.1 201 NOK'); 
	        	echo "你的金币不够，快速充值吧！";
	        	mysql_close($conn);
                exit();
	        }
        }	

        


        //从文件夹中查找书籍
        if(!file_exists(DEFAULT_BOOK_STORE_PATH . $bookName))//判断文件是否存在
        {
            header('HTTP/1.1 201 NOK'); 
            echo "文件查询:没有你要下载的书籍";
        } 
        else
        {
            $file = fopen(DEFAULT_BOOK_STORE_PATH. $bookName,"r"); //打开文件
            //输入文件标签
            Header("Content-type: application/octet-stream");
            Header("Accept-Ranges: bytes");
            Header("Accept-Length: ".filesize(DEFAULT_BOOK_STORE_PATH.$bookName));
            Header("Content-Disposition: attachment; filename=" . $bookName);
            //向客户端输出文件内容
            echo fread($file,filesize(DEFAULT_BOOK_STORE_PATH . $bookName));
            fclose($file);

            //加入判断文件时候全部传完的逻辑
            //TO-DO

            //更新数据库，先实现扣除用户的金币，后续要更新用户的购买记录表       
  
            list($a) = $bookPrice;
            list($b) = $userGold;
            $gold = $b-$a;

            $sql_update_gold = "UPDATE user SET gold = '$gold' WHERE user.userName = '$userName'";
            mysql_query("set names utf8");
            $result_update = mysql_query($sql_update_gold,$conn);
            if(!$result_update)
            {
                die("update failed:". mysql_error());
            }
            else
            {
                echo "下载成功！";
            }
            //
            
        }
    }
    mysql_close($conn);
?>