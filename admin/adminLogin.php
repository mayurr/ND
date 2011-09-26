<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
if (isset($_SESSION['adminId'])) {
	header("Location:admin.php");
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
<title>Nayadaur - Admin Login</title>
<script type="text/javascript" src="../lib/jquery.js"></script>
<script type="text/javascript" src="../js/login.js"></script>
<style type="text/css">
#adminLoginTable{
	margin-left:auto;
	margin-right:auto;
	margin-top:260px;
}
#invalidText{
	text-align:center;
}
</style>
</head>

<body>
<div id="wrapper">
    <div id="adminLoginForm">
        <table border="0" id="adminLoginTable">
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
                <td><button id="loginBtn" onclick="submitAdminLogin();">Enter</button></td>
            </tr>
        </table>       
    </div>
     <p id="invalidText"><?php echo $invalidText; ?></p>
</div>
</body>
</html>
<script type="text/javascript">
function submitAdminLogin() {
	var userName = document.getElementById("userName").value;
	var password = document.getElementById("password").value;
	var loginFlag = 0;
	$.ajax({
		url:'chkLogin.php',
		data:{userName:userName,password:password},
		type:'post',
		success:function(data){
			if (data == "") {
				window.location = "adminLogin.php?flag=1";
			}
			else{
				window.location = "admin.php";
			}
		}
	});
}
</script>