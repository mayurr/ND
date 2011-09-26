<?php
session_start();
include_once '../Model/class.notification.php';

switch ($_POST['action']) {
	case "CheckNotifications":
		$notification = new Notification();
		$notification->setUserId($_SESSION['userId']); 
		$result1 = $notification->fetchGiveNotifications();
		$result2 = $notification->fetchGetNotifications();
		if($result1 == FALSE && $result2 == FALSE) {
			$flag = 0;
		}
		else{
			$flag = 1;
		}
		echo $flag;
		
		break;
		
	case "FetchNotifications":
		$notification = new Notification();
		$notification->setUserId($_SESSION['userId']); 
		$result1 = $notification->fetchGiveNotifications();
		$result2 = $notification->fetchGetNotifications();
		if($result1 == FALSE && $result2 == FALSE) {
			echo "empty";
			break;
		}
		else{
			if ($result1 != FALSE) {
				$count = 0;
				$json1 = "{\"result1\": [";
				for($i=0;$i<sizeof($result1);$i++) {
					if($count > 0) {
						$json1 .= ",";
					}
					$json1 .= "{\"objectId\":\"".$result1[$i]['object_id']."\",";
					$json1 .= "\"objectImage\" :\"".$result1[$i]['object_image']."\",";
					$json1 .= "\"objectName\" :\"".$result1[$i]['object_name']."\",";
					$json1 .= "\"giveId\" :\"".$result1[$i]['give_id']."\",";
					$json1 .= "\"applicantId\" :\"".$result1[$i]['applicant_id']."\",";
					$json1 .= "\"getterId\" :\"".$result1[$i]['applicant_user_id']."\",";
					$json1 .= "\"giverId\" :\"".$result1[$i]['user_id']."\",";
					$json1 .= "\"giverImage\" :\"".$result1[$i]['user_image']."\",";
					$json1 .= "\"giverName\" :\"".$result1[$i]['first_name']." ".$result1[$i]['last_name']."\"}";
				}
				$json1 .= "]}";
				str_replace("},]", "}]}", $json1);
			}
			else {
				$json1 = "{\"result1\": [{\"empty\":\"empty\"}]}";
			}
			if ($result2 != FALSE) {
				$count = 0;
				$json2 = "{\"result2\": [";
				for($i=0;$i<sizeof($result2);$i++) {
					if($count > 0) {
						$json2 .= ",";
					}
					$json2 .= "{\"objectId\":\"".$result2[$i]['object_id']."\",";
					$json2 .= "\"objectImage\" :\"".$result2[$i]['object_image']."\",";
					$json2 .= "\"objectName\" :\"".$result2[$i]['object_name']."\",";
					$json2 .= "\"getId\" :\"".$result2[$i]['get_id']."\",";
					$json2 .= "\"applicantId\" :\"".$result2[$i]['applicant_id']."\",";
					$json2 .= "\"getterId\" :\"".$result2[$i]['user_id']."\",";
					$json2 .= "\"giverId\" :\"".$result2[$i]['applicant_user_id']."\",";
					$json2 .= "\"giverImage\" :\"".$result2[$i]['user_image']."\",";
					$json2 .= "\"giverName\" :\"".$result2[$i]['first_name']." ".$result2[$i]['last_name']."\"}";
				}
				$json2 .= "]}";
				str_replace("},]", "}]}", $json2);
			}
			else {
				$json2 = "{\"result2\": [{\"empty\":\"empty\"}]}";
			}
		}
		
		echo $json1.":::".$json2;
		
		break;
}
?>