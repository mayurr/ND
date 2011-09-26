<?php
session_start();
if(!isset($_SESSION['userId'])) {
	header("Location:index.php");
}
if (!isset($_SESSION['pageNumber'])) {
	$_SESSION['pageNumber'] = "1";
}
if(isset($_GET['flag'])) {
	$flag = "set";
	$getterId = $_GET['getterId'];
	$giverId = $_GET['giverId'];
}
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
	<script type="text/javascript">var flag = "<?php echo $flag; ?>";var getterId = "<?php echo $getterId; ?>";var giverId = "<?php echo $getterId; ?>";</script>
	<script type="text/javascript" src="lib/raphael.js"></script>
	<script type="text/javascript" src="lib/jquery.js"></script>
	<script type="text/javascript" src="js/view.js"></script>
	<script type="text/javascript">
	
	</script>
</head>
<body onload="setPage(<?php echo $_SESSION['pageNumber']; ?>);">
	<div id="wrapper">
		<div id="headName">Naya Daur</div>
		<p id="name"><?php echo $_SESSION['user1']['firstName']." ".$_SESSION['user1']['lastName'];?><br /><a href="notifications.php">Notifications</a></a></p>
		<a id="logout" href="feedback.php?id=<?php echo $_SESSION['user1']['userId'];?>">Logout</a>
		<div id="rightLine"></div>
		<div id="tabContainer">
			<ul id="tabs">
				<li id="tab1" class="tab">Neighbourhood</li>
				<li id="tab2" class="tab">Give</li>
				<li id="tab3" class="tab">Get</li>
				<li id="tab4" class="tab">List</li>
				<li id="tab5" class="tab">Story</li>
			</ul>
		</div>
        <img src="images/ajax-loader.gif" id="loaderImg" />
		<div id="pageContainer">
		</div>
	</div>
</body>
</html>