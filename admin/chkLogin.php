<?php
session_start();
include_once ("../Model/class.login.php");
$login = new Login();
$login->setUserName($_POST['userName']);
$login->setPassword($_POST['password']);
$success = $login->checkAdminLogin();
if(is_object($success)) {
	$_SESSION['adminId'] = $login->getUserId();
	$_SESSION['dbObject'] = $success;
}
echo $_SESSION['adminId'];
?>
