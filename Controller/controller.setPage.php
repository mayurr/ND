<?php
session_start();
switch ($_POST['tabId']) {
	case "tab1":
		$_SESSION['pageNumber'] = "1";
		break;
	case "tab2":
		$_SESSION['pageNumber'] = "2";
		break;
	case "tab3":
		$_SESSION['pageNumber'] = "3";
		break;
	case "tab4":
		$_SESSION['pageNumber'] = "4";
		break;
	case "tab5":
		$_SESSION['pageNumber'] = "5";
		break;
}
?>
