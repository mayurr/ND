<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="css/page4.css" />
<script type="text/javascript" src="js/page4.js"></script>
</head>

<body>
<div id="mainContainer">
	<!-- <div id="sortByTypeContainer">
 	Sort By Type
	<select id="sort" onchange="sortByItem()">
		<option value="All">All</option>
        <option value="Items">Items</option>
        <option value="Time">Time</option>
        <option value="Space">Space</option>
        <option value="Information">Information</option>
        <option value="Health">Health</option>
        <option value="startdate">startdate</option>
        <option value="enddate">enddate</option>
    </select>
    </div>
    <div id="sortByDateContainer">
    Sort By Date
    <select id="sortByDate" onchange="sortByDate()">
     	<option>Asc</option>
        <option>Desc</option>
    </select>
    </div>
    <div>Give</div> -->
    <div id="leftContainer">
    	<img src="images/give.png" alt="Give" id="giveHeading" />
    <?php
    	if ($_SESSION['gives'][0]['giveId'] != 'empty') {
    		echo "<div id=giveTable>";
	    	echo "<table>";
				for($i=0;$i<sizeof($_SESSION['gives']);$i++){
					$className = "giveList";
					if($_SESSION['gives'][$i]['status'] == "Failure"){
						$className .= "Fail";
					}
					echo "<tr>";
					echo "<td class='".$className."' id='".$_SESSION['gives'][$i]['userId']."-".$_SESSION['gives'][$i]['giveId']."-".$_SESSION['gives'][$i]['objectId']."' onmouseover='addGiveBorder(this.id);' onmouseout='removeGiveBorder(this.id);' onclick=showGive(this.id);>";
					echo "<table><tr>";
					echo "<td align=center width=80><img width=55 height=55 src='images/".$_SESSION['gives'][$i]['objectType'].".png' /><br />".$_SESSION['gives'][$i]['objectType']."</td>";
					echo "<td align=center width=140><img width=55 height=55 src=uploads/".$_SESSION['gives'][$i]['objectImage']." /><br />".$_SESSION['gives'][$i]['objectName']."</td>";
					echo "<td align=center width=140><img width=55 height=55 src=images/".$_SESSION['gives'][$i]['userImage']." /><br />".$_SESSION['gives'][$i]['firstName']." ".$_SESSION['gives'][$i]['lastName']."</td>";
					echo "<td>".$_SESSION['gives'][$i]['startDate']."<br /><br />".$_SESSION['gives'][$i]['endDate']."</td>";
					echo "</tr></table>";
					echo "</td>";
					echo "</tr>";
				}
			echo "</table>";
			echo "</div>";
    	}
	?>  
    </div>
   <!--  <div id="sortByTypeContainerGet">
 	Sort By Type
	<select id="sortGet" onchange="sortByItemGet()">
		<option value="All">All</option>
        <option value="Items">Items</option>
        <option value="Time">Time</option>
        <option value="Space">Space</option>
        <option value="Information">Information</option>
        <option value="Health">Health</option>
        <option value="startdate">startdate</option>
        <option value="enddate">enddate</option>
    </select>
    </div>
    <div id="sortByDateContainerGet">
    Sort By Date
    <select id="sortByDateGet" onchange="sortByDateGet()">
     	<option>Asc</option>
        <option>Desc</option>
    </select>
    </div>
    <div id="get">Get</div> -->
    <div id="rightContainer">
    	<img src="images/get.png" alt="Get" id="getHeading" />
    <?php
    	if ($_SESSION['gets'][0]['getId'] != 'empty') {
	    	echo "<table id=getTable>";
				for($i=0;$i<sizeof($_SESSION['gets']);$i++){
					$className = "getList";
					if($_SESSION['gets'][$i]['status'] == "Failure"){
						$className .= "Fail";
					}
					echo "<tr>";
					echo "<td class='".$className."' id='".$_SESSION['gets'][$i]['userId']."-".$_SESSION['gets'][$i]['getId']."-".$_SESSION['gets'][$i]['objectId']."' onmouseover='addGiveBorder(this.id);' onmouseout='removeGiveBorder(this.id);' onclick=showGet(this.id);>";
					echo "<table><tr>";
					echo "<td align=center width=80><img width=55 height=55 src='images/".$_SESSION['gets'][$i]['objectType'].".png' /><br />".$_SESSION['gets'][$i]['objectType']."</td>";
					echo "<td align=center width=140><img width=55 height=55 src=uploads/".$_SESSION['gets'][$i]['objectImage']." /><br />".$_SESSION['gets'][$i]['objectName']."</td>";
					echo "<td align=center width=140><img width=55 height=55 src=images/".$_SESSION['gets'][$i]['userImage']." /><br />".$_SESSION['gets'][$i]['firstName']." ".$_SESSION['gets'][$i]['lastName']."</td>";
					echo "<td>".$_SESSION['gets'][$i]['startDate']."<br /><br />".$_SESSION['gets'][$i]['endDate']."</td>";
					echo "</tr></table>";
					echo "</td>";
					echo "</tr>";
				}
			echo "</table>";
    	}
	?>  
    </div>
</div>
</body>
</html>