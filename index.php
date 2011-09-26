<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
if (isset($_SESSION['userId'])) {
	header("Location:view.php");
}
if($_GET['flag']==1){
	$invalidText = "User Name or Password Invalid";
	session_destroy();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Naya Daur</title>
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
	<link href="css/nd.css" rel="stylesheet"/>
	<script type="text/javascript" src="lib/jquery.js"></script>
	<script type="text/javascript" src="js/login.js"></script>
	<meta name="description" content="An experiment in creating a practical Gift Economy" />
</head>

<body>
	<div id="wrapper">
		<h1 id="nd">Naya Daur</h1>
		<h2 id="anw">a new way</h2>
	    <p id="about">Naya Daur is an experiment in creating a practical Gift Economy. In a Gift Economy, all transactions are in the form of gifts. Not barters, swaps, IOUs or even non-transferable kudos; just one-way gifts. Is it possible for such an economy to function, survive, or even thrive? Naya Daur aims to find out. While the idea of an economy based entirely on gift-giving is certainly not new, Naya Daur attempts to formulate a working, practical and most importantly, fun system which may one day act as a major resource for many of the 'things' you need in life, if not the only one. <i id="enter">Enter here</i></p>
	    <div id="loginForm">
	    	<table border="0" id="loginTable">
	        	<tr>
		            <td>User Id:</td>
		            <td> <input id="userName" type="text" name="userName"/></td>
	          	</tr>
	           	<tr>
		            <td>Password: </td>
		            <td><input id="password" type="password" name="password" /></td>
	          	</tr>
	           	<tr>
		            <td></td>
		            <td><input type="submit" id="loginBtn" value="Enter" onclick="submitLogin();" /></td>
	          	</tr>
			</table>       
	    </div>
	    <p id="invalidText"><?php echo $invalidText; ?></p>
	</div>
</body>
</html>