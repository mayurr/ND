<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE); 
if($_GET['flag']==1){
	echo "Invalid User";
	session_destroy();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Naya Daur Login</title>
</head>

<body>
	<form id="loginForm" method="post" action="chkLogin.php">
    	User Id: <input id="userId" type="text" name="userId"/>
        Password: <input id="password" type="password" name="password" />
        <input id="loginBtn" type="submit" value="Login"/>
    </form>
</body>
</html>
