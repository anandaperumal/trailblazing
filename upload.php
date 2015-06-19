<?php
header("Content-type: application/json");
$userid = $_SERVER['HTTP_X_USERID'];
$filename="uploaded";
$target_path_wine = "admin/upload/wine/";
$target_path_profile = "admin/upload/profile/";
$server = "localhost";
$db = "trailblazing";
$uname = "root";
$pass = "trailblazing123";

$con = mysql_connect($server, $uname, $pass);
$db = mysql_select_db($db, $con);

if($_REQUEST['type']=='wine_search'){
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

	if(isset($_FILES["wine_photo"]["name"])){
        $photoSearch = 1;
        $target_path = $target_path_wine . basename($wine_photo); 
	if(move_uploaded_file($_FILES['wine_photo']['tmp_name'], $target_path)) {
            include('image.class.php');
            $img = new Zubrag_image;
            // initialize
            $img->cut_x        = 0;
            $img->cut_y        = 0;
            $img->quality      = 100;
            $img->save_to_file = true;
            $img->image_type   = -1;
            $images_folder = $target_path_wine;
            $from_name = $imageName;
            $to_name = $imageName;
            $dimentions = array(1 => 100, 2 => 200, 3 => 400);
            $folders = array(1 => '100x100/', 2 => '200x200/', 3 => '400x400/');
            foreach($dimentions as $key => $value) {
                $img->max_x        = $value;
                $img->max_y        = $value;
                $thumbs_folder = $target_path_wine . $folders[$key];
                $img->GenerateThumbFile($images_folder . $from_name, $thumbs_folder . $to_name);
            }
		}
	}

	if($inserted) {
        $msg = "Your wine search is now underway";
		if(empty($is_archive)) {
			$sql = "UPDATE `tbl_users` SET `pending_searches` = `pending_searches` - 1 WHERE `user_id` = " . $userid;
			$res = mysql_query($sql);
		} else {
            $msg = "Your wine text has been saved for later use";
            if(!empty($photoSearch)) {
                $msg = "Your photo has been saved for later use";                
            }            
        }
		$response = array("response" => array("httpCode" => 200,"Message" => $msg));
		echo json_encode($response);
	}else{
		$response = array("response" => array( "httpCode" => 500,"Message" => "There is some problem in Saving wine in DB."));
		echo json_encode($response);
	}
}elseif($_REQUEST['type']=='edit_profile'){
	$user_id = $_SERVER['HTTP_X_USERID'];
	$email =  (isset($_REQUEST["email"]))?$_REQUEST["email"]:'';
	$profile_image =  (isset($_FILES["profile_image"]["name"]))?time().$_FILES["profile_image"]["name"]:'';

	if(isset($_FILES["profile_image"]["name"])){
        $imageName = time() . basename($profile_image);
		$target_path = $target_path_profile . $imageName; 
		if(move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_path)) {
            include('image.class.php');
            $img = new Zubrag_image;
            // initialize
            $img->cut_x        = 0;
            $img->cut_y        = 0;
            $img->quality      = 100;
            $img->save_to_file = true;
            $img->image_type   = -1;
            $images_folder = $target_path_profile;
            $from_name = $imageName;
            $to_name = $imageName;
            $dimentions = array(1 => 100, 2 => 200, 3 => 400);
            $folders = array(1 => '100x100/', 2 => '200x200/', 3 => '400x400/');
            foreach($dimentions as $key => $value) {
                $img->max_x        = $value;
                $img->max_y        = $value;
                $thumbs_folder = $target_path_profile . $folders[$key];
                $img->GenerateThumbFile($images_folder . $from_name, $thumbs_folder . $to_name);
            }
		}
	}

	$first_name =  (isset($_REQUEST["first_name"]))?$_REQUEST["first_name"]:'';
	$last_name =  (isset($_REQUEST["last_name"]))?$_REQUEST["last_name"]:'';
	$date_of_birth =  (isset($_REQUEST["date_of_birth"]))?$_REQUEST["date_of_birth"]:'';
	$address =  (isset($_REQUEST["address"]))?$_REQUEST["address"]:'';
	$coutry =  (isset($_REQUEST["coutry"]))?$_REQUEST["coutry"]:'';
	$postcode =  (isset($_REQUEST["postcode"]))?$_REQUEST["postcode"]:'';
	$udid =  (isset($_REQUEST["udid"]))?$_REQUEST["udid"]:'';
	$device_version =  (isset($_REQUEST["device_version"]))?$_REQUEST["device_version"]:'';
	$device_type =  (isset($_REQUEST["device_type"]))?$_REQUEST["device_type"]:'';
	$pending_searches =  (isset($_REQUEST["pending_searches"]))?$_REQUEST["pending_searches"]:'';
	$global_partnership_number=  (isset($_REQUEST["global_partnership_number"]))?$_REQUEST["global_partnership_number"]:'';
	$subscription_type=  (isset($_REQUEST["subscription_type"]))?$_REQUEST["subscription_type"]:'';
	$userType=  (isset($_REQUEST["userType"]))?$_REQUEST["userType"]:'';
	$title =  (isset($_REQUEST["title"]))?$_REQUEST["title"]:'';
	$contact_number=  (isset($_REQUEST["contact_number"]))?$_REQUEST["contact_number"]:'';
	$mobile_number=  (isset($_REQUEST["mobile_number"]))?$_REQUEST["mobile_number"]:'';
	$palates=  (isset($_REQUEST["palates"]))?$_REQUEST["palates"]:'';
	
	$sql = "UPDATE `tbl_users` SET 
			`email` = '".$email."',
			`profile_image` = '".$profile_image."',
			`first_name` = '".$first_name."',
			`last_name` = '".$last_name."',
			`date_of_birth` = '".$date_of_birth."',
			`address` = '".$address."',
			`coutry` = '".$coutry."',
			`postcode` = '".$postcode."',
			`udid` = '".$udid."',
			`device_version` = '".$device_version."',
			`device_type` = '".$device_type."',
			`pending_searches` = '".$pending_searches."',
			`global_partnership_number` = '".$global_partnership_number."',
			`subscription_type` = '".$subscription_type."',
			`userType` = '".$userType."',
			`title` = '".$title."',
			`contact_number` = '".$contact_number."',
			`mobile_number` = '".$mobile_number."',
			`palates` = '".$palates."'
			WHERE `user_id` = " . $user_id;
	$userUpdate = mysql_query($sql);
	
	$billing_address = (isset($_REQUEST["billing_address"]))?$_REQUEST["billing_address"]:'';
	$billing_city = (isset($_REQUEST["billing_city"]))?$_REQUEST["billing_city"]:'';
	$billing_state = (isset($_REQUEST["billing_state"]))?$_REQUEST["billing_state"]:'';
	$billing_country = (isset($_REQUEST["billing_country"]))?$_REQUEST["billing_country"]:'';
	$billing_postcode = (isset($_REQUEST["billing_postcode"]))?$_REQUEST["billing_postcode"]:'';
	$billing_phone = (isset($_REQUEST["billing_phone"]))?$_REQUEST["billing_phone"]:'';
	$p_shipping_address = (isset($_REQUEST["p_shipping_address"]))?$_REQUEST["p_shipping_address"]:'';
	$p_shipping_city = (isset($_REQUEST["p_shipping_city"]))?$_REQUEST["p_shipping_city"]:'';
	$p_shipping_state = (isset($_REQUEST["p_shipping_state"]))?$_REQUEST["p_shipping_state"]:'';
	$p_shipping_country =  (isset($_REQUEST["p_shipping_country"]))?$_REQUEST["p_shipping_country"]:'';
	$p_shipping_postcode =  (isset($_REQUEST["p_shipping_postcode"]))?$_REQUEST["p_shipping_postcode"]:'';
	$p_shipping_phone = (isset($_REQUEST["p_shipping_phone"]))?$_REQUEST["p_shipping_phone"]:'';
	$s_shipping_address =  (isset($_REQUEST["s_shipping_address"]))?$_REQUEST["s_shipping_address"]:'';
	$s_shipping_city =  (isset($_REQUEST["s_shipping_city"]))?$_REQUEST["s_shipping_city"]:'';
	$s_shipping_state =  (isset($_REQUEST["s_shipping_state"]))?$_REQUEST["s_shipping_state"]:'';
	$s_shipping_country =  (isset($_REQUEST["s_shipping_country"]))?$_REQUEST["s_shipping_country"]:'';
	$s_shipping_postcode =  (isset($_REQUEST["s_shipping_postcode"]))?$_REQUEST["s_shipping_postcode"]:'';
	$s_shipping_phone =  (isset($_REQUEST["s_shipping_phone"]))?$_REQUEST["s_shipping_phone"]:'';
	$is_primary =  (isset($_REQUEST["is_primary"]))?$_REQUEST["is_primary"]:'';
	
	$Address = "UPDATE `tbl_address` SET 
				`billing_address` = '".$billing_address."',
				`billing_city` = '".$billing_city."',
				`billing_state` = '".$billing_state."',
				`billing_country` = '".$billing_country."',
				`billing_postcode` = '".$billing_postcode."',
				`billing_phone` = '".$billing_phone."',
				`p_shipping_address` = '".$p_shipping_address."',
				`p_shipping_city` = '".$p_shipping_city."',
				`p_shipping_state` = '".$p_shipping_state."',
				`p_shipping_country` = '".$p_shipping_country."',
				`p_shipping_postcode` = '".$p_shipping_postcode."',
				`p_shipping_phone` = '".$p_shipping_phone."',
				`s_shipping_address` = '".$s_shipping_address."',
				`s_shipping_city` = '".$s_shipping_city."',
				`s_shipping_state` = '".$s_shipping_state."',
				`s_shipping_country` = '".$s_shipping_country."',
				`s_shipping_postcode` = '".$s_shipping_postcode."',
				`s_shipping_phone` = '".$s_shipping_phone."',
				`is_primary` = '".$is_primary."'
				WHERE `user_id` = " . $user_id ."";

	$AddressUpdate = mysql_query($Address);
	if(!empty($AddressUpdate) && !empty($userUpdate)){
		$response = array("response" => array("httpCode" => 200,"Message" => "Your Profile has been updated successfully"));
		echo json_encode($response);
		exit;
	}else{
		$response = array("response" => array("httpCode" => 500,"Message" => "OOPS !! DB Error."));
		echo json_encode($response);
		exit;
	}
}
?>