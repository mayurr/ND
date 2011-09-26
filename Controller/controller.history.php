<?php
session_start();
include_once ("../Model/class.history.php");

switch ($_POST['action']) {
	case "Insert":
		$history = new History();
		
		$lastId = $history->getLastTransactionId();
		if ($lastId != null) {
			$newTransactionId = $history->getNewId($lastId);			
		}
		else {
			$newTransactionId = "tran00001";
		}
		
		if($_POST['type'] == "give") {			
			for ($i=0;$i<sizeof($_SESSION['gives']);$i++) {
				if($_SESSION['gives'][$i]['giveId'] == $_POST['givegetId']) {
					$givegetIndex = $i;
					break;
				}
			}
			for ($i=0;$i<sizeof($_SESSION['userGives']);$i++) {
				if($_SESSION['userGives'][$i]['giveId'] == $_POST['givegetId']) {
					$givegetIndex1 = $i;
					break;
				}
			}
			$type = "gives";
		}
		else {
			for ($i=0;$i<sizeof($_SESSION['gets']);$i++) {
				if($_SESSION['gets'][$i]['getId'] == $_POST['givegetId']) {
					$givegetIndex = $i;
					break;
				}
			}
			for ($i=0;$i<sizeof($_SESSION['userGets']);$i++) {
				if($_SESSION['userGets'][$i]['giveId'] == $_POST['givegetId']) {
					$givegetIndex1 = $i;
					break;
				}
			}
			$type = "gets";
		}
		
		for ($i=0;$i<sizeof($_SESSION['users']);$i++) {
			if($_SESSION['users'][$i]['userId'] == $_POST['giverId']){
				$giverIdIndex = $i;
				break;
			}
		}
		
		$applicantIds = "{";
		$applicantTimestamps = "{";
		for ($i=0;$i<sizeof($_SESSION['applicants']);$i++) {
			if($_SESSION['applicants'][$i]['givegetId'] == $_POST['givegetId']) {
				$applicantIds .= $_SESSION['applicants'][$i]['applicantId'].",";
				$applicantTimestamps .= $_SESSION['applicants'][$i]['timestamps'].",";
			}
		}
		$applicantIds .= "}";
		$applicantTimestamps .= "}";
		str_replace(",}", "}", $applicantIds);
		str_replace(",}", "}", $applicantTimestamps);
		
		if($type == "gives") {
			$history->setTransactionId($newTransactionId);
			$history->setTransactionType($_POST['type']);
			$history->setStartDate($_SESSION["gives"][$givegetIndex]['startDate']);
			$history->setEndDate($_SESSION["gives"][$givegetIndex]['endDate']);
			$history->setComments($_SESSION["gives"][$givegetIndex]['comments']);
			$history->setStatus($_SESSION["gives"][$givegetIndex]['status']);
			$history->setOpeningTimestamp($_SESSION["gives"][$givegetIndex]['timestamp']);
			$history->setClosingTimestamp(date('Y-m-d H:i:s'));
			$history->setObjectId($_SESSION["gives"][$givegetIndex]['objectId']);
			$history->setObjectType($_SESSION["gives"][$givegetIndex]['objectType']);
			$history->setObjectName($_SESSION["gives"][$givegetIndex]['objectName']);
			$history->setObjectImage($_SESSION["gives"][$givegetIndex]['objectImage']);
			$history->setObjectDescription($_SESSION["gives"][$givegetIndex]['objectDescription']);
			$history->setGiverId($_POST['giverId']);
			$history->setGiverX($_SESSION["users"][$giverIdIndex]['oldX']);
			$history->setGiverY($_SESSION["users"][$giverIdIndex]['oldY']);
			$history->setGetterId($_SESSION['user1']['userId']);
			$history->setGetterX($_SESSION['user1']['oldX']);
			$history->setGetterY($_SESSION['user1']['oldY']);
			$history->setApplicantIds($applicantIds);
			$history->setApplicantTimestamps($applicantTimestamps);
			
			array_splice($_SESSION["gives"],$givegetIndex,1);
			array_splice($_SESSION["userGives"],$givegetIndex,1);
		}
		else {
			$history->setTransactionId($newTransactionId);
			$history->setTransactionType($_POST['type']);
			$history->setStartDate($_SESSION["gets"][$givegetIndex]['startDate']);
			$history->setEndDate($_SESSION["gets"][$givegetIndex]['endDate']);
			$history->setComments($_SESSION["gets"][$givegetIndex]['comments']);
			$history->setStatus($_SESSION["gets"][$givegetIndex]['status']);
			$history->setOpeningTimestamp($_SESSION["gets"][$givegetIndex]['timestamp']);
			$history->setClosingTimestamp(date('Y-m-d H:i:s'));
			$history->setObjectId($_SESSION["gets"][$givegetIndex]['objectId']);
			$history->setObjectType($_SESSION["gets"][$givegetIndex]['objectType']);
			$history->setObjectName($_SESSION["gets"][$givegetIndex]['objectName']);
			$history->setObjectImage($_SESSION["gets"][$givegetIndex]['objectImage']);
			$history->setObjectDescription($_SESSION["gets"][$givegetIndex]['objectDescription']);
			$history->setGiverId($_POST['giverId']);
			$history->setGiverX($_SESSION["users"][$giverIdIndex]['oldX']);
			$history->setGiverY($_SESSION["users"][$giverIdIndex]['oldY']);
			$history->setGetterId($_SESSION['user1']['userId']);
			$history->setGetterX($_SESSION['user1']['oldX']);
			$history->setGetterY($_SESSION['user1']['oldY']);
			$history->setApplicantIds($applicantIds);
			$history->setApplicantTimestamps($applicantTimestamps);
			
			array_splice($_SESSION["gets"],$givegetIndex,1);
			array_splice($_SESSION["userGets"],$givegetIndex,1);
		}
		
		$result = $history->insertTransaction();
		
		break;
		
}
?>