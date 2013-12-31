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
    	echo MSG_NO_BOOK_IN_DB;
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
        	echo SEARCH_ERROR;
        	die ("search failed : " . mysql_error());
        }
        else
        {
        	$priceInfo = mysql_fetch_array($sql_bookPrice_result);
	        if ($priceInfo == null)
	        {
                header('HTTP/1.1 201 NOK'); 
	            echo SEARCH_ERROR;
                exit();
	        }
	        else
	        {
	            $bookPrice = $priceInfo;
	        } 
	        //查询用户的金币数 	
            $condition_query = "user.userName = '$userName'";
            $sql_userGold_result = $db->query("gold", "user", $condition_query);
            if (!$sql_userGold_result)
	        {
                header('HTTP/1.1 201 NOK'); 
	        	echo SEARCH_ERROR;
	        	die ("search failed : " . mysql_error());
	        }
	        else
	        {
	        	$goldInfo = mysql_fetch_array($sql_userGold_result);
	            if ($goldInfo == null)
		        {
                    header('HTTP/1.1 201 NOK'); 
		            echo SEARCH_ERROR;
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
	        	echo LEAK_GOLD;
                exit();
	        }
        }	


        $result_readfile = readfiles($bookName);
        if ($result_readfile ==FILE_NOT_EXISTS)
        {
            header('HTTP/1.1 201 NOK'); 
            echo MSG_NO_BOOK_IN_FILE;
        }
        else if($result_readfile == FILE_READ_SUCCESS)
        {
            
            list($a) = $bookPrice;
            list($b) = $userGold;
            $gold = $b-$a;
            $return = $db->update("user", "gold", $gold, "userName", $userName);//update the gold
            $condition_query = "bookStore.bookName = '$bookName'";
            $result = $db->query("bookDownloadTimes", "bookStore", $condition_query);
            $downloadTimesInfo = mysql_fetch_array($result);
            list($c) = $downloadTimesInfo;
            $db->update("bookStore", "bookDownloadTimes", $c+1, "bookName", "$bookName");  //update the book download times
            echo $return;
        }
    }
    //mysql_close($conn);
?>