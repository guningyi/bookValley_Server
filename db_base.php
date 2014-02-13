<?php 
    require_once 'bookValley_server_config.php';
    require_once 'sqlDB_util.php';
    require_once 'db_base.php';
    
    class db_base
    {
    	private $host;
    	private $port;
    	private $user;
    	private $password;
        private $db_name;
        private $table_name;
    	private $conn;

    	function __construct($host,$port, $user,$password, $db_name)
    	{
        	$this->host = $host;
        	$this->port = $port;
        	$this->user = $user;
        	$this->password = $password;
        	$this->db_name = $db_name;
        	$this->connect();
    	}

    	function connect()
	    {
	        $this->conn=mysql_connect($this->host,$this->user,$this->password); 
	        if(!$this->conn) 
	        	die(mysql_error()); 
	        mysql_select_db($this->db_name,$this->conn) or die(mysql_error());
	    }

	    function __destruct()
        {
        	mysql_close($this->conn);
        }


        /*
            $cond is single or combination condition
            this method divided the sql sentence into two parts. 
        */
        function query($name,$table,$cond)
	    {
	        if(($name=="")&&($cond==""))
	        $sql="select * from $table";
	        else 
	        {
	            if($name=="")
	            $sql="select * from $table where $cond";
	            else
	            {
	                if($cond=="")
	                    $sql="select $name from $table";
	                else
	                $sql="select $name from $table where $cond";
	            }
	        }
	        $result=mysql_query($sql,$this->conn);
	        if(!$result)
	        {
	            die (mysql_error());
	        }
	        else
	        return $result;
	    }

	    
	    function update($table_name, $update_raw, $update_data, $where_raw, $where_data)
	    {
	     	$sql_update = "UPDATE $table_name SET $update_raw = '$update_data' WHERE $table_name.$where_raw = '$where_data'";    

	     	$sql_result = mysql_query($sql_update,$this->conn);

	     	if(!$sql_result)
	        {
		        die ("update failed : " . mysql_error());
	        }
	        else
	        {
	            echo DB_UPDATE_SUCCESS;
	        }
	    }

	    
    }


?>