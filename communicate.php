<?php
// array for JSON response
var_dump(json_decode($json));
$response = array();
include("conn.php");
// check for required fields
if (isset($_POST['name'])) {
    
    $name = $_POST['name'];
   
    $result = mysql_query("INSERT INTO text VALUES('$name')");
//    $result= mysql_query("select * from device_info where date='$name'");
    echo $result;

    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Product successfully created.";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
        
        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>