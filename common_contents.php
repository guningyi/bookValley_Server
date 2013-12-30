<?php 

    //common start from 0
    define('SUCCESS', '00000000');

    //db start from 1 
    define('DB_UPDATE_SUCCESS', '10000001');
    define('DB_INSERT_SUCCESS', '10000002');
    define('DB_SEARCH_SUCCESS', '10000003');
    define('DB_UPDATE_FAILE',   '10000004');
    define('DB_INSERT_FAILE',   '10000005');
    define('DB_SEARCH_FAILE',   '10000006');


     //file start from 2: 
    define('FILE_EXISTS',       '20000000');
    define('FILE_NOT_EXISTS',   '20000001');
    define('FILE_READ_SUCCESS', '20000002');
    define('FILE_READ_FAILED',  '20000003');

?>