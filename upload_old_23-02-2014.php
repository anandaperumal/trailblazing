<?php
header("Content-type: application/json");
$userid = $_SERVER['HTTP_X_USERID'];
$filename="uploaded";
$target_path = "upload/wine/";

$server = "localhost";
$db = "harlington";
$uname = "root";
$pass = "harlington123";

$con = mysql_connect($server, $uname, $pass);
$db = mysql_select_db($db, $con);

$user_id = $_SERVER['HTTP_X_USERID'];
$quote = (isset($_REQUEST['quote']) && $_REQUEST['quote']!='')?$_REQUEST['quote']:'';
$name = (isset($_REQUEST['name']) && $_REQUEST['name']!='')?$_REQUEST['name']:'';
$vintage = (isset($_REQUEST['vintage']) && $_REQUEST['vintage']!='')?$_REQUEST['vintage']:'';
$producer = (isset($_REQUEST['producer']) && $_REQUEST['producer']!='')?$_REQUEST['producer']:'';
$wine_photo =  (isset($_FILES["wine_photo"]["name"]))?time().$_FILES["wine_photo"]["name"]:'';
$lat =  (isset($_REQUEST["lat"]))?$_REQUEST["lat"]:'';
$lng =  (isset($_REQUEST["lng"]))?$_REQUEST["lng"]:'';
$is_archive =  (isset($_REQUEST["is_archive"]))?$_REQUEST["is_archive"]:0;

$today = date("Y-m-d H:m:s", time());
$query = "INSERT INTO `tbl_wine_search` (`wine_search_id`, `user_id`, `quote`, `name`, `vintage`, `producer`, `wine_photo`, `lat`, `lng`, `wine_id`, `is_viewed`,`is_archive`, `created_on`) VALUES (NULL, '{$userid}', '{$quote}', '{$name}', '{$vintage}', '{$producer}', '{$wine_photo}', '{$lat}', '{$lng}', '0', '0',{$is_archive}, '{$today}');";
$inserted = mysql_query($query);

if(isset($_FILES["wine_photo"]["name"])) {
    $target_path = $target_path . basename($wine_photo); 
    if(move_uploaded_file($_FILES['wine_photo']['tmp_name'], $target_path)) {
    }
}

if($inserted) {
    if(empty($is_archive)) {
        $sql = "UPDATE `tbl_users` SET `pending_searches` = `pending_searches` - 1 WHERE `user_id` = " . $userid;
        $res = mysql_query($sql);
    }
    $response = array("response" => array("httpCode" => 200,"Message" => "Wine Added Successfully"));
    echo json_encode($response);
    
} else {
     $response = array("response" => array( "httpCode" => 500,"Message" => "There is some problem in Saving wine in DB."));
   echo json_encode($response);
}
exit;
?>