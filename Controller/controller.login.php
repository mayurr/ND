<?php
session_start();
include_once ("../Model/class.login.php");
switch ($_POST['action']) {
	case "Insert":
		$login = new Login();
		$login->setUserId($_POST['id']);
		$login->setPassword($_POST['password']);
		$success = $login->insertLogin();
		echo $success;
		break;
	
	case "Update":
		$login = new Login();
		$login->setUserId($_POST['id']);
		$login->setPassword($_POST['password']);
		$success = $login->updateLogin();
		echo $success;
		break;

	case "Delete":
		$login = new Login();
		$login->setUserId($_POST['id']);
		$success = $login->deleteLogin();
		echo $success;
		break;
		
	case "Check":
		$login = new Login();
		$login->setUserName($_POST['userName']);
		$login->setPassword($_POST['password']);
		$success = $login->checkLogin();
		if(is_object($success)) {
			$_SESSION['userId'] = $login->getUserId();
		}
		echo $_SESSION['userId'];
		break;
}

?>