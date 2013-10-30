<?php

if (isset($_POST['message'])) 
{
    $time = time();

    $text = $_POST['message'];
    echo $text.'当前时间是:'.$time;
   
}
else 
{
  
    echo "没有收到信息";
}


?>