<?php
session_start();
unset($_SESSION['userId']);
unset($_SESSION['userGives']);
unset($_SESSION['userGets']);
unset($_SESSION['gives']);
unset($_SESSION['gets']);
unset($_SESSION['users']);
unset($_SESSION['user1']);
unset($_SESSION['applicants']);
session_destroy();

if(!isset($_SESSION['userId'])){
	header("Location:index.php");
}
?>