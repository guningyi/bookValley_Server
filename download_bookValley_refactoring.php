<?php 
    require_once 'bookValley_server_config.php';
    require_once 'sqlDB_util.php';
    require_once 'db_base.php';
    require_once 'file_util.php';

    /*用于响应客户端发来的下载书籍请求*/

    $bookName = $_POST['downloadBookName'];
    $userName = $_POST['downloadUserName'];


    $bookPrice = 0;
    $userGold = 0;
    $gold = 0;

   
    //$host,$port, $user,$password, $db_name
    $db = new db_base(DEFAULT_HOST, DEFAULT_PORT, DEFAULT_USER, DEFAULT_PASS, "bookValley");
    $condition_query = " bookStore.bookName = '$bookName' ";
    $sql_result = $db->query("bookName", "bookStore", $condition_query);  
    if(!$sql_result)//这里是检查数据库中是否有登记此书
    {
    	echo "数据库查询:没有你要下载的书籍";
        die ("search failed : " . mysql_error());
    }
    else
    {
        //根据用户名去判断用户的金币数是否大于下载的书的价格
        $condition_query = "bookStore.bookName = '$bookName'";
        $sql_bookPrice_result = $db->query("bookPrice", "bookStore", $condition_query);
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
            $condition_query = "user.userName = '$userName'";
            $sql_userGold_result = $db->query("userName", "user", $condition_query);
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


        $result_readfile = readfiles($bookName);
        if ($result_readfile ==FILE_NOT_EXISTS)
        {
            header('HTTP/1.1 201 NOK'); 
            echo "文件查询:没有你要下载的书籍";
        }
        else if($result_readfile == FILE_READ_SUCCESS)
        {
            list($a) = $bookPrice;
            list($b) = $userGold;
            $gold = $b-$a;
            //function update($dataBase_name, $table_name, $update_raw, $update_data, $where_raw, $where_data)
            $return = update("bookValley", "user", "gold", $gold, "userName", $userName);
            echo $return;
        }
    }
    //mysql_close($conn);
?>