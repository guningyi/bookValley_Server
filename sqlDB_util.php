<?php 
    require_once 'bookValley_server_config.php';
    require_once 'common_contents.php';
    
    /*

    */
    function update($dataBase_name, $table_name, $update_raw, $update_data, $where_raw, $where_data)
    {
      
	    $conn_update = mysql_connect(DEFAULT_HOST,DEFAULT_USER,DEFAULT_PASS);
	    if (!$conn_update) //假如连接失败
	    {
	        die('Could not connect: ' . mysql_error());
	    }

	    /*
	        如果连接上了mysql服务器，先创建数据库。
	        mysql服务器 > 数据库 > 表
	    */
	    if (!mysql_select_db("bookValley", $conn_update))//判断数据库是否存在
	    {
		    die('database not exist: ' . mysql_error());
	    }

	    /*
	        设置活动数据库,输入参数，数据库名，连接
	        如果设置成功，返回true
	                失败，返回false
	    */
	    $db_selected = mysql_select_db("bookValley", $conn_update);
	    if(!$db_selected)
	    {
	        die ("database exist, but it could not be used : " . mysql_error());
	    }


     	$sql_update = "UPDATE $table_name SET $update_raw = '$update_data' WHERE $table_name.$where_raw = '$where_data'";    

     	$sql_result = mysql_query($sql_update,$conn_update);

     	if(!$sql_result)
        {
	        die ("update failed : " . mysql_error());
        }
        else
        {
            echo DB_UPDATE_SUCCESS;
        }
        //mysql_close($conn_update);
    }
    
?>