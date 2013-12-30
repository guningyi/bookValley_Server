<?php 
	function readfiles($filename)
	{
		$bookName = $filename;
        //从文件夹中查找书籍
        if(!file_exists(DEFAULT_BOOK_STORE_PATH . $bookName))//判断文件是否存在
        {
            return FILE_NOT_EXISTS;
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
            return FILE_READ_SUCCESS;
        }
	}

?>