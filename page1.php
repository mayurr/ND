<?php
session_start();
if(isset($_GET['flag'])){
	$flag = 1;
	$getterId = $_GET['getterId'];
	$giverId = $_GET['giverId'];
}
else {
	$flag = 0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script language="text/javascript">
	var userDetailsArray=new Array;
    <?php
    	echo "var flag =".$flag.";";
    	echo "var getterId ='".$getterId."';";
    	echo "var giverId ='".$giverId."';";
    	echo "var sessionId='".$_SESSION['user1']['userId']."';";
        for($i=0;$i<count($_SESSION['users']); $i++) {
        	echo "userDetailsArray[$i] = new Object;";
            echo "userDetailsArray[$i].userId='".$_SESSION['users'][$i]['userId']."';";
            echo "userDetailsArray[$i].firstName='".$_SESSION['users'][$i]['firstName']."';";
            echo "userDetailsArray[$i].lastName='".$_SESSION['users'][$i]['lastName']."';";
            echo "userDetailsArray[$i].email='".$_SESSION['users'][$i]['email']."';";
            echo "userDetailsArray[$i].image='".$_SESSION['users'][$i]['image']."';";
            echo "userDetailsArray[$i].x='".$_SESSION['users'][$i]['x']."';";
            echo "userDetailsArray[$i].y='".$_SESSION['users'][$i]['y']."';";
            echo "userDetailsArray[$i].oldX='".$_SESSION['users'][$i]['oldX']."';";
            echo "userDetailsArray[$i].oldY='".$_SESSION['users'][$i]['oldY']."';";
        }
     ?>
</script>
<script type="text/javascript" src="js/page1.js"></script>
<link rel="stylesheet" type="text/css" href="css/page1.css" />
</head>

<body>
	<div id="zoomButtonsDiv">
 		<button id="zoomIn" onclick="zoomIn();">+</button>
 		<button id="zoomOut" onclick="zoomOut();">-</button>
 	</div>
    <p id="userIdText"></p>
</body>
</html>