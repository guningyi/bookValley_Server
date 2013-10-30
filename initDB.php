<?php
$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

if (mysql_query("CREATE DATABASE my_db",$con))
  {
  echo "Database created";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }

mysql_select_db("my_db", $con);
$sql = "CREATE TABLE text
(
 name VARCHAR( 100 ) NOT NULL PRIMARY KEY
)";
mysql_query($sql,$con);
mysql_close($con);

?>

