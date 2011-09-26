<?php
session_start();
include_once ("../Model/class.user.php");
if ($_POST['userId'] == "") {
	$userId = $_SESSION['userId'];
}
else {
	$userId = $_POST['userId'];
}

switch ($_POST['action']) {
	case "GetDetails":
		$user = new User();
		$columnArray = array("first_name","last_name");
		$user->setId($userId);
		$user->setTableName("users");
		$user->setColumnArray($columnArray);
		$user->setWhereColumn("user_id");
		$user->setWhereColumnValue($userId);
		$result = $user->getUserDetails();
		//$fName = $user->getFName();
		//$lName = $user->getLName();
		$json = "{\"result\": [";
		$json .= "{\"fName\":\"".$result[0]["first_name"]."\",";
		$json .= "\"lName\" :\"".$result[0]["last_name"]."\"}";
		$json .= "]}";
		echo $json;
		unset($columnArray);
		break;
		
	case "GetAllUsers":
		$userss = new User();	
		$_SESSION['users'] = array();
		$_SESSION['user'] = array();
		$result = $userss->getAllUsers();
		if (sizeof($result) != 0) {
			for ($i=0 ; $i<sizeof($result) ; $i++) {
				$_SESSION['users'][$i]['userId'] = $result[$i]['user_id'];
				$_SESSION['users'][$i]['firstName'] = $result[$i]['first_name'];
				$_SESSION['users'][$i]['lastName'] = $result[$i]['last_name'];
				$_SESSION['users'][$i]['email'] = $result[$i]['email'];
				$_SESSION['users'][$i]['image'] = $result[$i]['image'];
				$_SESSION['users'][$i]['x'] = $result[$i]['x'];
				$_SESSION['users'][$i]['y'] = $result[$i]['y'];
				$_SESSION['users'][$i]['oldX'] = $result[$i]['old_x'];
				$_SESSION['users'][$i]['oldY'] = $result[$i]['old_y'];
				
				if ($result[$i]['user_id'] == $_SESSION['userId']) {
					$_SESSION['user1']['userId'] = $result[$i]['user_id'];
					$_SESSION['user1']['firstName'] = $result[$i]['first_name'];
					$_SESSION['user1']['lastName'] = $result[$i]['last_name'];
					$_SESSION['user1']['email'] = $result[$i]['email'];
					$_SESSION['user1']['image'] = $result[$i]['image'];
					$_SESSION['user1']['x'] = $result[$i]['x'];
					$_SESSION['user1']['y'] = $result[$i]['y'];
					$_SESSION['user1']['oldX'] = $result[$i]['old_x'];
					$_SESSION['user1']['oldY'] = $result[$i]['old_y']; 
				}
			}
		}
		else {
			$_SESSION['users'][0]['userId'] = "empty";
		}
		echo sizeof($_SESSION['users']);
		break;
}
?>