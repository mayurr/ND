<?php
session_start();
$userId = $_SESSION['userId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Naya Daur</title>
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
	<!--[if IE 7]>
	        <link rel="stylesheet" type="text/css" href="css/ie7.css">
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="css/styles.css" />
	<link rel="stylesheet" type="text/css" href="css/basic.css"/>
	<link rel="stylesheet" type="text/css" href="css/view.css"/>
	<script type="text/javascript" src="lib/jquery.js"></script>
	<script type="text/javascript">var userId = "<?php echo $userId; ?>";</script>
	<script type="text/javascript" src="js/notifications.js"></script>
</head>
<body>
	<div id="wrapper">
		<div id="headName">Naya Daur</div>
		<p id="name"><?php echo $_SESSION['user1']['firstName']." ".$_SESSION['user1']['lastName'];?></p>
		<a id="logout" href="feedback.php?id=<?php echo $_SESSION['user1']['userId'];?>">Logout</a>
		<div id="notifications" ></div>
	</div>
</body>
</html>