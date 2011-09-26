<?php
session_start();
include_once ("../Model/class.give.php");
include_once ("../Model/class.get.php");
include_once ("../Model/class.object.php");
include_once ("../Model/class.applicant.php");
include_once ("../Model/class.user.php");
include_once ("../Model/class.action.php");
include_once ("../Model/class.mail.php");

$columnArray = array();

switch ($_POST['action']) {
	/*
	 * Switch Case to insert a new Give
	 */
	case "Give":
		$give = new Give();
		$object = new Object();
		
		/*
		 * get the last id and generate new give id 
		 */
		$lastId = $give->getLastGiveId();
		if ($lastId != null) {
		$newGiveId = $give->getNewId($lastId);			
		}
		else {
			$newGiveId = "give00001";
		}
		
		/*
		 * get the last id and generate new object id 
		 */
		$lastId = $object->getLastObjectId();
		if ($lastId != null) {
			$newObjectId = $object->getNewId($lastId);			
		}
		else {
			$newObjectId = "obj00001";
		}
		
		/*
		 * set the values to be inserted to give table and insert
		 */
		$give->setGiveId($newGiveId);
		$give->setUserId($_SESSION['user1']['userId']);
		$give->setObjectId($newObjectId);
		$give->setStartDate($_POST['startDate']);
		$give->setEndDate($_POST['endDate']);
		$give->setComments($_POST['comments']);
		$give->setStatus("Active");
		$give->setLocation($_POST['location']);
		$result = $give->insertGive();
		
		/*
		 * set the values to be inserted to object table and insert
		 */
		$object->setObjectId($newObjectId);
		$object->setName($_POST['name']);
		$object->setDescription($_POST['description']);
		$object->setImage($_POST['image']);
		$object->setType($_POST['type']);
		$object->setCounter(1);
		$result2 = $object->insertObject();
		
		$newGive = array("giveId"=>$newGiveId,"userId"=>$_SESSION['user1']['userId'],"objectId"=>$newObjectId,"objectName"=>$_POST['name'],"objectDescription"=>$_POST['description'],"objectImage"=>$_POST['image'],"objectType"=>$_POST['type'],"startDate"=>$_POST['startDate'],"endDate"=>$_POST['endDate'],"comments"=>$_POST['comments'],"status"=>"Active","location"=>$_POST['location'],"firstName"=>$_SESSION['user1']['firstName'],"lastName"=>$_SESSION['user1']['lastName'],"userImage"=>$_SESSION['user1']['image']);
		if($_SESSION['gives'][0]['giveId'] == "empty") {
			$_SESSION['gives'] = array();
		}
		if($_SESSION['userGives'][0]['giveId'] == "empty") {
			$_SESSION['userGives'] = array();
		}
		array_unshift($_SESSION['gives'],$newGive);
		array_unshift($_SESSION['userGives'],$newGive);
		echo $newGiveId."::".$_SESSION['user1']['userId']."::".$newObjectId;
		break;
		
	/*
	 * Switch Case to insert a new Get
	 */
	case "Get":
		$get = new Get();
		$object = new Object();
		
		/*
		 * get the last id and generate new give id 
		 */
		$lastId = $get->getLastGetId();
		if ($lastId != null) {
			$newGetId = $get->getNewId($lastId);			
		}
		else {
			$newGetId = "get00001";
		}
		
		/*
		 * get the last id and generate new object id 
		 */
		$lastId = $object->getLastObjectId();
		if ($lastId != null) {
			$newObjectId = $object->getNewId($lastId);			
		}
		else {
			$newObjectId = "obj00001";
		}
		
		/*
		 * set the values to be inserted to give table and insert
		 */
		$get->setGetId($newGetId);
		$get->setUserId($_SESSION['user1']['userId']);
		$get->setObjectId($newObjectId);
		$get->setStartDate($_POST['startDate']);
		$get->setEndDate($_POST['endDate']);
		$get->setComments($_POST['comments']);
		$get->setStatus("Active");
		$get->setLocation($_POST['location']);
		$result1 = $get->insertGet();
		
		/*
		 * set the values to be inserted to object table and insert
		 */
		$object->setObjectId($newObjectId);
		$object->setName($_POST['name']);
		$object->setDescription($_POST['description']);
		$object->setImage($_POST['image']);
		$object->setType($_POST['type']);
		$object->setCounter(1);
		$result2 = $object->insertObject();
		
		$newGet = array("getId"=>$newGetId,"userId"=>$_SESSION['user1']['userId'],"objectId"=>$newObjectId,"objectName"=>$_POST['name'],"objectDescription"=>$_POST['description'],"objectImage"=>$_POST['image'],"objectType"=>$_POST['type'],"startDate"=>$_POST['startDate'],"endDate"=>$_POST['endDate'],"comments"=>$_POST['comments'],"status"=>"Active","location"=>$_POST['location'],"firstName"=>$_SESSION['user1']['firstName'],"lastName"=>$_SESSION['user1']['lastName'],"userImage"=>$_SESSION['user1']['image']);
		if($_SESSION['gets'][0]['getId'] == "empty") {
			$_SESSION['gets'] = array();
		}
		if($_SESSION['userGets'][0]['getId'] == "empty") {
			$_SESSION['userGets'] = array();
		}
		array_unshift($_SESSION['gets'],$newGet);
		array_unshift($_SESSION['userGets'],$newGet);
		
		echo $newGetId."::".$_SESSION['user1']['userId']."::".$newObjectId;
		break;

	/*
	 * Switch Case to show all gives on Give Page
	 */
	case "GetAllGives":
		$noUserGivesFlag = 0;
		$_SESSION['gives'] = array();
		$_SESSION['userGives'] = array();
		$action = new Action();
		$result = $action->getAllGives();
		if (sizeof($result) != 0) {
			$count = 0;
			for($i=0;$i<sizeof($result);$i++) {
				$_SESSION['gives'][$i]['giveId'] = $result[$i]['give_id'];
				$_SESSION['gives'][$i]['userId'] = $result[$i]['user_id'];
				$_SESSION['gives'][$i]['objectId'] = $result[$i]['object_id'];
				$_SESSION['gives'][$i]['objectName'] = $result[$i]['name'];
				$_SESSION['gives'][$i]['objectDescription'] = $result[$i]['description'];
				$_SESSION['gives'][$i]['objectImage'] = $result[$i]['object_image'];
				$_SESSION['gives'][$i]['objectType'] = $result[$i]['type'];
				$_SESSION['gives'][$i]['startDate'] = $result[$i]['start_date'];
				$_SESSION['gives'][$i]['endDate'] = $result[$i]['end_date'];
				$_SESSION['gives'][$i]['comments'] = $result[$i]['comments'];
				$_SESSION['gives'][$i]['status'] = $result[$i]['status'];
				$_SESSION['gives'][$i]['location'] = $result[$i]['location'];
				$_SESSION['gives'][$i]['firstName'] = $result[$i]['first_name'];
				$_SESSION['gives'][$i]['lastName'] = $result[$i]['last_name'];
				$_SESSION['gives'][$i]['userImage'] = $result[$i]['user_image'];
				$_SESSION['gives'][$i]['timestamp'] = $result[$i]['timestamp'];
				
				if ($result[$i]['user_id'] == $_SESSION['user1']['userId']) {
					$_SESSION['userGives'][$count]['giveId'] = $result[$i]['give_id'];
					$_SESSION['userGives'][$count]['userId'] = $result[$i]['user_id'];
					$_SESSION['userGives'][$count]['objectId'] = $result[$i]['object_id'];
					$_SESSION['userGives'][$count]['objectName'] = $result[$i]['name'];
					$_SESSION['userGives'][$count]['objectDescription'] = $result[$i]['description'];
					$_SESSION['userGives'][$count]['objectImage'] = $result[$i]['object_image'];
					$_SESSION['userGives'][$count]['objectType'] = $result[$i]['type'];
					$_SESSION['userGives'][$count]['startDate'] = $result[$i]['start_date'];
					$_SESSION['userGives'][$count]['endDate'] = $result[$i]['end_date'];
					$_SESSION['userGives'][$count]['comments'] = $result[$i]['comments'];
					$_SESSION['userGives'][$count]['status'] = $result[$i]['status'];
					$_SESSION['userGives'][$count]['location'] = $result[$i]['location'];
					$_SESSION['userGives'][$count]['firstName'] = $result[$i]['first_name'];
					$_SESSION['userGives'][$count]['lastName'] = $result[$i]['last_name'];
					$_SESSION['userGives'][$count]['userImage'] = $result[$i]['user_image'];
					$_SESSION['userGives'][$count]['timestamp'] = $result[$i]['timestamp'];
					$count += 1;
					$noUserGivesFlag = 1;
				}
			}
			if ($noUserGivesFlag == 0) {
				$_SESSION['userGives'][0]['giveId'] = "empty";
			}
		}
		else {
			$_SESSION['gives'][0]['giveId'] = "empty";
			$_SESSION['userGives'][0]['giveId'] = "empty";
		}
		break;
		
	case "GetAllGets":
		$noUserGetsflag = 0;
		$_SESSION['gets'] = array();
		$_SESSION['userGets'] = array();
		$action = new Action();
		$result = $action->getAllGets();
		if (sizeof($result) != 0) {
			$count = 0;
			for($i=0;$i<sizeof($result);$i++) {
				$_SESSION['gets'][$i]['getId'] = $result[$i]['get_id'];
				$_SESSION['gets'][$i]['userId'] = $result[$i]['user_id'];
				$_SESSION['gets'][$i]['objectId'] = $result[$i]['object_id'];
				$_SESSION['gets'][$i]['objectName'] = $result[$i]['name'];
				$_SESSION['gets'][$i]['objectDescription'] = $result[$i]['description'];
				$_SESSION['gets'][$i]['objectImage'] = $result[$i]['object_image'];
				$_SESSION['gets'][$i]['objectType'] = $result[$i]['type'];
				$_SESSION['gets'][$i]['startDate'] = $result[$i]['start_date'];
				$_SESSION['gets'][$i]['endDate'] = $result[$i]['end_date'];
				$_SESSION['gets'][$i]['comments'] = $result[$i]['comments'];
				$_SESSION['gets'][$i]['status'] = $result[$i]['status'];
				$_SESSION['gets'][$i]['location'] = $result[$i]['location'];
				$_SESSION['gets'][$i]['firstName'] = $result[$i]['first_name'];
				$_SESSION['gets'][$i]['lastName'] = $result[$i]['last_name'];
				$_SESSION['gets'][$i]['userImage'] = $result[$i]['user_image'];
				$_SESSION['gets'][$i]['timestamp'] = $result[$i]['timestamp'];
				
				if ($result[$i]['user_id'] == $_SESSION['user1']['userId']) {
					$_SESSION['userGets'][$count]['getId'] = $result[$i]['get_id'];
					$_SESSION['userGets'][$count]['userId'] = $result[$i]['user_id'];
					$_SESSION['userGets'][$count]['objectId'] = $result[$i]['object_id'];
					$_SESSION['userGets'][$count]['objectName'] = $result[$i]['name'];
					$_SESSION['userGets'][$count]['objectDescription'] = $result[$i]['description'];
					$_SESSION['userGets'][$count]['objectImage'] = $result[$i]['object_image'];
					$_SESSION['userGets'][$count]['objectType'] = $result[$i]['type'];
					$_SESSION['userGets'][$count]['startDate'] = $result[$i]['start_date'];
					$_SESSION['userGets'][$count]['endDate'] = $result[$i]['end_date'];
					$_SESSION['userGets'][$count]['comments'] = $result[$i]['comments'];
					$_SESSION['userGets'][$count]['status'] = $result[$i]['status'];
					$_SESSION['userGets'][$count]['location'] = $result[$i]['location'];
					$_SESSION['userGets'][$count]['firstName'] = $result[$i]['first_name'];
					$_SESSION['userGets'][$count]['lastName'] = $result[$i]['last_name'];
					$_SESSION['userGets'][$count]['userImage'] = $result[$i]['user_image'];
					$_SESSION['userGets'][$count]['timestamp'] = $result[$i]['timestamp'];
					$count += 1;
					$noUserGetsflag = 1;
				}
			}
			if($noUserGetsflag == 0) {
				$_SESSION['userGets'][0]['getId'] = "empty";
			}
		}
		else {
			$_SESSION['gets'][0]['getId'] = "empty";
			$_SESSION['userGets'][0]['getId'] = "empty";
		}
		break;

	/*
	 * Switch Case to add new applicant to Applicants Table
	 */
	case "AddApplicant":
		$applicant = new Applicant();
		
		/*
		 * get the last id and generate new applicant id 
		 */
		$lastId = $applicant->getLastApplicantId();
		if ($lastId != null) {
			$newApplicantId = $applicant->getNewId($lastId);			
		}
		else {
			$newApplicantId = "applicant00001";
		}
		
		/*
		 * set the values to be inserted to give table and insert
		 */
		$applicant->setApplicantId($newApplicantId);
		$applicant->setGivegetId($_POST['givegetId']);
		$applicant->setUserId($_SESSION['user1']['userId']);
		$applicant->setComments($_POST['comments']);
		$applicant->setStatus("Pending");
		$result1 = $applicant->insertApplicant();
		
		$newApplicant = array("applicantId"=>$newApplicantId,"givegetId"=>$_POST['givegetId'],"userId"=>$_SESSION['user1']['userId'],"comments"=>$_POST['comments'],"status"=>"Pending","firstName"=>$_SESSION['user1']['firstName'],"lastName"=>$_SESSION['user1']['lastName'],"image"=>$_SESSION['user1']['image']);
		array_unshift($_SESSION['applicants'],$newApplicant);
		
		break;
		
	/*
	 * Switch Case to show all applicants for specific Give or Get
	 */
	case "GetAllApplicants":
		$_SESSION['applicants'] = array();
		$applicant = new Applicant();				
		$result = $applicant->getAllApplicants();
		if (sizeof($result) != 0) {
			for($i=0;$i<sizeof($result);$i++) {
				$_SESSION['applicants'][$i]['applicantId'] = $result[$i]['applicant_id'];
				$_SESSION['applicants'][$i]['givegetId'] = $result[$i]['giveget_id'];
				$_SESSION['applicants'][$i]['userId'] = $result[$i]['user_id'];
				$_SESSION['applicants'][$i]['comments'] = $result[$i]['comments'];
				$_SESSION['applicants'][$i]['status'] = $result[$i]['status'];		
				$_SESSION['applicants'][$i]['firstName'] = $result[$i]['first_name'];		
				$_SESSION['applicants'][$i]['lastName'] = $result[$i]['last_name'];		
				$_SESSION['applicants'][$i]['image'] = $result[$i]['image'];
				$_SESSION['applicants'][$i]['timestamp'] = $result[$i]['timestamp'];		
			}
		}
		else {
			$_SESSION['applicants'][0]['applicantId'] = "empty";
		}
		break;
		
	case "ShowApplicants":
		$count = 0;
		$flag = 0;
		$json = "{\"result\": [";
		if (sizeof($_SESSION['applicants']) != 0) {
			for($i=0;$i<sizeof($_SESSION['applicants']);$i++) {
				if($_SESSION['applicants'][$i]['givegetId'] == $_POST['givegetId']) {
					if($count > 0) {
						$json .= ",";
					}						
					$json .= "{\"applicantId\":\"".$_SESSION['applicants'][$i]['applicantId']."\",";
					$json .= "\"givegetId\" :\"".$_SESSION['applicants'][$i]['givegetId']."\",";
					$json .= "\"userId\" :\"".$_SESSION['applicants'][$i]['userId']."\",";
					$json .= "\"comments\" :\"".$_SESSION['applicants'][$i]['comments']."\",";
					$json .= "\"status\" :\"".$_SESSION['applicants'][$i]['status']."\",";
					$json .= "\"firstName\" :\"".$_SESSION['applicants'][$i]['firstName']."\",";
					$json .= "\"lastName\" :\"".$_SESSION['applicants'][$i]['lastName']."\",";
					$json .= "\"userImage\" :\"".$_SESSION['applicants'][$i]['image']."\"}";
					$count += 1;
					$flag = 1;				
				}	
			}
			if($flag == 0) {
				$json .= "{\"empty\":\"empty\"}";				
			}
		}
		else {
			$json .= "{\"empty\":\"empty\"}";
		}
		$json .= "]";
		str_replace("},]", "}]", $json);
		
		$count = 0;
		$flag = 0;
		$json1 = "\"result1\": [";
		if(strpos($_POST['givegetId'], "give") !== false) {
			if (sizeof($_SESSION['gives']) != 0) {
				for($i=0;$i<sizeof($_SESSION['gives']);$i++) {
					if($_SESSION['gives'][$i]['giveId'] == $_POST['givegetId']) {
						if($count > 0) {
							$json1 .= ",";
						}						
						$json1 .= "{\"objectType\":\"".$_SESSION['gives'][$i]['objectType']."\",";
						$json1 .= "\"objectName\" :\"".$_SESSION['gives'][$i]['objectName']."\",";
						$json1 .= "\"objectImage\" :\"".$_SESSION['gives'][$i]['objectImage']."\",";
						$json1 .= "\"objectDescription\" :\"".$_SESSION['gives'][$i]['objectDescription']."\",";
						$json1 .= "\"comments\" :\"".$_SESSION['gives'][$i]['comments']."\",";
						$json1 .= "\"location\" :\"".$_SESSION['gives'][$i]['location']."\",";
						$json1 .= "\"startDate\" :\"".$_SESSION['gives'][$i]['startDate']."\",";
						$json1 .= "\"endDate\" :\"".$_SESSION['gives'][$i]['endDate']."\"}";
						$count += 1;
						$flag = 1;
						break;			
					}	
				}
				if($flag == 0) {
					$json1 .= "{\"empty\":\"empty\"}";				
				}
			}
			else {
				$json1 .= "{\"empty\":\"empty\"}";
			}
		}
		else {
			if (sizeof($_SESSION['gets']) != 0) {
				for($i=0;$i<sizeof($_SESSION['gets']);$i++) {
					if($_SESSION['gets'][$i]['getId'] == $_POST['givegetId']) {
						if($count > 0) {
							$json1 .= ",";
						}						
						$json1 .= "{\"objectType\":\"".$_SESSION['gets'][$i]['objectType']."\",";
						$json1 .= "\"objectName\" :\"".$_SESSION['gets'][$i]['objectName']."\",";
						$json1 .= "\"objectImage\" :\"".$_SESSION['gets'][$i]['objectImage']."\",";
						$json1 .= "\"objectDescription\" :\"".$_SESSION['gets'][$i]['objectDescription']."\",";
						$json1 .= "\"comments\" :\"".$_SESSION['gets'][$i]['comments']."\",";
						$json1 .= "\"location\" :\"".$_SESSION['gets'][$i]['location']."\",";
						$json1 .= "\"startDate\" :\"".$_SESSION['gets'][$i]['startDate']."\",";
						$json1 .= "\"endDate\" :\"".$_SESSION['gets'][$i]['endDate']."\"}";
						$count += 1;
						$flag = 1;
						break;			
					}	
				}
				if($flag == 0) {
					$json1 .= "{\"empty\":\"empty\"}";				
				}
			}
			else {
				$json1 .= "{\"empty\":\"empty\"}";
			}
		}
		$json1 .= "]}";
		str_replace("},]}", "}]}", $json1);
		
		echo $json.",".$json1;
		
		break;
		
	case "ChooseUser":
		$applicant = new Applicant();
		
		$applicant->setApplicantId($_POST['applicantId']);
		$applicant->setStatus("Chosen");
		$result = $applicant->updateApplicant();
		
		for($i=0;$i<sizeof($_SESSION['applicants']);$i++) {
			if($_SESSION['applicants'][$i]['applicantId'] == $_POST['applicantId']) {
				$_SESSION['applicants'][$i]['status'] = "Chosen";
				break;
			}
		}
		
		if ($_POST['type'] == "give") {
			$give = new Give();
			$give->setGiveId($_POST['givegetId']);
			$give->setStatus("Chosen");
			$result = $give->updateGive();
			
			for($i=0;$i<sizeof($_SESSION['gives']);$i++) {
				if($_SESSION['gives'][$i]['giveId'] == $_POST['givegetId']) {
					$_SESSION['gives'][$i]['status'] = "Chosen";
					break;
				}
			}
			for($i=0;$i<sizeof($_SESSION['userGives']);$i++) {
				if($_SESSION['userGives'][$i]['giveId'] == $_POST['givegetId']) {
					$_SESSION['userGives'][$i]['status'] = "Chosen";
					$objectName = $_SESSION['userGives'][$i]['objectName'];
					$objectImage = $_SESSION['userGives'][$i]['objectImage'];
					$objectType = $_SESSION['userGives'][$i]['objectType'];
					break;
				}
			}
		}
		else {
			$get = new Get();
			$get->setGetId($_POST['givegetId']);
			$get->setStatus("Chosen");
			$result = $get->updateGet();
			
			for($i=0;$i<sizeof($_SESSION['gets']);$i++) {
				if($_SESSION['gets'][$i]['getId'] == $_POST['givegetId']) {
					$_SESSION['gets'][$i]['status'] = "Chosen";
					break;
				}
			}
			for($i=0;$i<sizeof($_SESSION['userGets']);$i++) {
				if($_SESSION['userGets'][$i]['getId'] == $_POST['givegetId']) {
					$_SESSION['userGets'][$i]['status'] = "Chosen";
					$objectName = $_SESSION['userGets'][$i]['objectName'];
					$objectImage = $_SESSION['userGets'][$i]['objectImage'];
					$objectType = $_SESSION['userGets'][$i]['objectType'];
					break;
				}
			}
		}
		if($_POST['type'] == "give") {
			for($i=0;$i<sizeof($_SESSION['applicants']);$i++) {
				if ($_SESSION['applicants'][$i]['applicantId'] == $_POST['applicantId']) {
					$getterId = $_SESSION['applicants'][$i]['userId'];
					break;
				}
			}
			$flag1 = 0;
			$flag2 = 0;
			for($i=0;$i<sizeof($_SESSION['users']);$i++) {
				if ($_SESSION['users'][$i]['userId'] == $getterId) {
					$getterName = $_SESSION['users'][$i]['firstName']." ".$_SESSION['users'][$i]['lastName'];
					$getterEmail = $_SESSION['users'][$i]['email'];
					$flag1 = 1;
				}
				if ($_SESSION['users'][$i]['userId'] == $_POST['giverId']) {
					$giverName = $_SESSION['users'][$i]['firstName']." ".$_SESSION['users'][$i]['lastName'];
					$giverEmail = $_SESSION['users'][$i]['email'];
					$flag2 = 1;
				}
				if ($flag1 == 1 && $flag2 == 1) {
					break;
				}
			}
		}
		
		if($_POST['type'] == "get") {
			for($i=0;$i<sizeof($_SESSION['applicants']);$i++) {
				if ($_SESSION['applicants'][$i]['applicantId'] == $_POST['applicantId']) {
					$giverId= $_SESSION['applicants'][$i]['userId'];
					break;
				}
			}
			$flag1 = 0;
			$flag2 = 0;
			for($i=0;$i<sizeof($_SESSION['users']);$i++) {
				if ($_SESSION['users'][$i]['userId'] == $_POST['getterId']) {
					$getterName = $_SESSION['users'][$i]['firstName']." ".$_SESSION['users'][$i]['lastName'];
					$getterEmail = $_SESSION['users'][$i]['email'];
					$flag1 = 1;
				}
				if ($_SESSION['users'][$i]['userId'] == $giverId) {
					$giverName = $_SESSION['users'][$i]['firstName']." ".$_SESSION['users'][$i]['lastName'];
					$giverEmail = $_SESSION['users'][$i]['email'];
					$flag2 = 1;
				}
				if ($flag1 == 1 && $flag2 == 1) {
					break;
				}
			}
		}
		
		if($_POST['type'] == "give") {
			$message = "<html><head></head><body>";
			$message .= "<p>Hi ".$getterName."</p><br/>";
			$message .= "<p>I have chosen to gift you:</p><br/>";
			$message .= "<img src='http://nayadaur.org/images/".$objectType.".png' width=50 height=50 /><br/>";
			$message .= "<img src='http://nayadaur.org/uploads/".$objectImage."' width=50 height=50 /><p> ".$objectName."</p><br/>";
			$message .= "<p>How do we do this!?</p><br />";
			$message .= "<p>Thank You!</p><br/>";
			$message .= "<p>".$giverName."</p><br/>";
			$message .= "</body></html>";
			
			$mail = new Mail();
			$mail->setFrom($giverEmail);
			$mail->setSubject("Hi!");
			$mail->setMessage($message);
			$mail->setTo($getterEmail);
		}
		else {
			$message = "<html><head></head><body>";
			$message .= "<p>Hi ".$giverName."</p><br/>";
			$message .= "<p>I have chosen to be gifted by you:</p><br/>";
			$message .= "<img src='http://nayadaur.org/images/".$objectType.".png' width=50 height=50 /><p> ".$objectType."</p><br/>";
			$message .= "<img src='http://nayadaur.org/uploads/".$objectImage."' width=50 height=50 /><p> ".$objectName."</p><br/>";
			$message .= "<p>How do we do this!?</p><br />";
			$message .= "<p>Thank You!</p><br/>";
			$message .= "<p>".$getterName."</p><br/>";
			$message .= "</body></html>";
			
			$mail->setFrom($getterEmail);
			$mail->setSubject("Hi!");
			$mail->setMessage($message);
			$mail->setTo($giverEmail);
		}
		
		$mail->sendMail();
		
		break;
		
	case "ConfirmReceipt":
		$applicant = new Applicant();
		$give = new Give();
		$get = new Get();
		
		/*
		 * Delete entry/entries from applicant table and update status in Session Array
		 */
		$applicant->setGivegetId($_POST['givegetId']);
		
		$applicant->deleteApplicant();
		for ($i=0;$i<sizeof($_SESSION['applicants']);$i++) {
			if($_SESSION['applicants'][$i]['applicantId'] == $_POST['applicantId']){
				$_SESSION['applicants'][$i]['status'] = "Complete";
				break;
			}
		}
		
		/*
		 * Delete entry from give/get table and update status in Session Array
		 */
		if($_POST['tableName'] == "give") {
			$give->setGiveId($_POST['givegetId']);
			$result = $give->deleteGive();
			for ($i=0;$i<sizeof($_SESSION['gives']);$i++) {
				if($_SESSION['gives'][$i]['giveId'] == $_POST['givegetId']){
					$_SESSION['gives'][$i]['status'] = "Complete";
					$objectImage = $_SESSION['gives'][$i]['objectImage'];
					$objectName = $_SESSION['gives'][$i]['objectName'];
					break;
				}
			}
		}
		else{
			$get->setGetId($_POST['givegetId']);
			$result = $get->deleteGet();
			for ($i=0;$i<sizeof($_SESSION['gets']);$i++) {
				if($_SESSION['gets'][$i]['getId'] == $_POST['givegetId']){
					$_SESSION['gets'][$i]['status'] = "Complete";
					$objectImage = $_SESSION['gets'][$i]['objectImage'];
					$objectName = $_SESSION['gets'][$i]['objectName'];
					break;
				}
			}
		}
		$mail = new Mail();
		$flagGetter = 0;
		$flagGiver = 0;
		for ($i=0;$i<sizeof($_SESSION['users']);$i++) {
			if($_SESSION['users'][$i]['userId'] == $_POST['getterId']) {
				$getterEmail = $_SESSION['users'][$i]['email'];
				$getterName = $_SESSION['users'][$i]['firstName']." ".$_SESSION['users'][$i]['lastName'];
				$flagGetter = 1;
			}
			if($_SESSION['users'][$i]['userId'] == $_POST['giverId']) {
				$giverEmail = $_SESSION['users'][$i]['email'];
				$giverName = $_SESSION['users'][$i]['firstName']." ".$_SESSION['users'][$i]['lastName'];
				$flagGiver = 1;
			}
			if($flagGetter == 1 && $flagGiver == 1) {
				break;
			}
		}
		if($_POST['type']) {
			$mail->setSubject(strtoupper($_POST['type'])." Complete!");
		}
		
		$mail->setFrom("admin@nayadaur.org");

		$message = "<html><head></head><body>";
		$message .= "<p>Hi ".$getterName."</p><br/>";
		$message .= "<p>Congratulations!</p><br/>";
		$message .= "<p>You have just been Gifted:</p><br/>";
		$message .= "<img src='http://nayadaur.org/uploads/".$objectImage."' width=50 height=50 /><p> ".$objectName."</p><br/>";
		$message .= "<p>by ".$giverName." - ".$giverEmail."</p><br/>";
		$message .= "<p>This has been added to your Story and your position in the neighbourhood has been updated.</p><br/><br/>";
		$message .= "<p>Thank You!</p><br/>";
		$message .= "<p>contact@nayadaur.org for any questions or comments.</p>";
		$message .= "</body></html>";
		
		
		$mail->setMessage($message);
		$mail->setTo($getterEmail);
		
		$mail->sendMail();
		
		$message = "<html><head></head><body>";
		$message .= "<p>Hi ".$giverName."</p><br/>";
		$message .= "<p>Congratulations!</p><br/>";
		$message .= "<p>You have just Gifted:</p><br/>";
		$message .= "<img src='http://nayadaur.org/uploads/".$objectImage."' width=50 height=50 /><p> ".$objectName."</p><br/>";
		$message .= "<p>to ".$getterName." - ".$getterEmail."</p><br/>";
		$message .= "<p>This has been added to your Story and your position in the neighbourhood has been updated.</p><br/><br/>";
		$message .= "<p>Thank You!</p><br/>";
		$message .= "<p>contact@nayadaur.org for any questions or comments.</p>";
		$message .= "</body></html>";
		
		$mail->setMessage($message);
		$mail->setTo($giverEmail);
		$mail->sendMail();
		
		break;
		
	case "ConfirmNonReceipt":
		$applicant = new Applicant();
		$give = new Give();
		$get = new Get();
		
		/*
		 * Delete entry/entries from applicant table and update status in Session Array
		 */
		$applicant->setGivegetId($_POST['givegetId']);
		$applicant->deleteApplicant();
		for ($i=0;$i<sizeof($_SESSION['applicants']);$i++) {
			if($_SESSION['applicants'][$i]['applicantId'] == $_POST['applicantId']){
				$_SESSION['applicants'][$i]['status'] = "Failure";
				break;
			}
		}
		
		/*
		 * Delete entry from give table and update status in Session Array
		 */
		if($_POST['tableName'] == "give") {
			$give->setGiveId($_POST['givegetId']);
			$result = $give->deleteGive();
			for ($i=0;$i<sizeof($_SESSION['gives']);$i++) {
				if($_SESSION['gives'][$i]['giveId'] == $_POST['givegetId']){
					$_SESSION['gives'][$i]['status'] = "Failure";
					$objectImage = $_SESSION['gives'][$i]['objectImage'];
					$objectName = $_SESSION['gives'][$i]['objectName'];
					break;
				}
			}
		}
		/*
		 * Delete entry from get table and update status in Session Array
		 */
		else{
			$get->setGetId($_POST['givegetId']);
			$result = $get->deleteGet();
			for ($i=0;$i<sizeof($_SESSION['gets']);$i++) {
				if($_SESSION['gets'][$i]['getId'] == $_POST['givegetId']){
					$_SESSION['gets'][$i]['status'] = "Failure";
					$objectImage = $_SESSION['gets'][$i]['objectImage'];
					$objectName = $_SESSION['gets'][$i]['objectName'];
					break;
				}
			}
		}
		
		$mail = new Mail();
		$flagGetter = 0;
		$flagGiver = 0;
		for ($i=0;$i<sizeof($_SESSION['users']);$i++) {
			if($_SESSION['users'][$i]['userId'] == $_POST['getterId']) {
				$getterEmail = $_SESSION['users'][$i]['email'];
				$getterName = $_SESSION['users'][$i]['firstName']." ".$_SESSION['users'][$i]['lastName'];
				$flagGetter = 1;
			}
			if($_SESSION['users'][$i]['userId'] == $_POST['giverId']) {
				$giverEmail = $_SESSION['users'][$i]['email'];
				$giverName = $_SESSION['users'][$i]['firstName']." ".$_SESSION['users'][$i]['lastName'];
				$flagGiver = 1;
			}
			if($flagGetter == 1 && $flagGiver == 1) {
				break;
			}
		}
		if($_POST['type']) {
			$mail->setSubject(strtoupper($_POST['type'])." Failure!");
		}
		$mail->setFrom("admin@nayadaur.org");
		
		$message = "<html><head></head><body>";
		$message .= "<p>Hi ".$getterName."</p><br/>";
		$message .= "<p>Your gift:</p><br/>";
		$message .= "<img src='http://nayadaur.org/uploads/".$objectImage."' width=50 height=50 /><p> ".$objectName."</p><br/>";
		$message .= "<p>by ".$giverName." has been Cancelled</p><br/>";
		$message .= "<p>This has been added to your Story and your position in the neighbourhood has been updated.</p><br/><br/>";
		$message .= "<p>Thank You!</p><br/>";
		$message .= "<p>contact@nayadaur.org for any questions or comments.</p>";
		$message .= "</body></html>";
		
		$mail->setMessage($message);
		$mail->setTo($getterEmail);
		$mail->sendMail();
		
		$message = "<html><head></head><body>";
		$message .= "<p>Hi ".$giverName."</p><br/>";
		$message .= "<p>Your gift:</p><br/>";
		$message .= "<img src='http://nayadaur.org/uploads/".$objectImage."' width=50 height=50 /><p> ".$objectName."</p><br/>";
		$message .= "<p>to ".$giverName." has been Cancelled</p><br/>";
		$message .= "<p>This has been added to your Story and your position in the neighbourhood has been updated.</p><br/><br/>";
		$message .= "<p>Thank You!</p><br/>";
		$message .= "<p>contact@nayadaur.org for any questions or comments.</p>";
		$message .= "</body></html>";
		
		$mail->setMessage($message);
		$mail->setTo($giverEmail);
		$mail->sendMail();

		break;
		
	case "WithdrawApplication":
		$applicant = new Applicant();
		
		$applicant->setApplicantId($_POST['applicantId']);
		$applicant->setStatus("Withdrawn");
		$result = $applicant->updateApplicant();
		
		for($i=0;$i<sizeof($_SESSION['applicants']);$i++) {
			if($_SESSION['applicants'][$i]['applicantId'] == $_POST['applicantId']) {
				$_SESSION['applicants'][$i]['status'] = "Withdrawn";
				break;
			}
		}
		
		break;
		
	case "SendFeedback":
		$email = $_SESSION['user1']['email'];
		$feedback=$_POST["feedback"];
		$to = "admin@nayadaur.org,contact@simplybetter.in";
		$subject = "Feedback";
		//$message = "Hello! This is a simple email message.";
		$headers = "From:" . $email;
		mail($to,$subject,$feedback,$headers);
		break;
}
?>