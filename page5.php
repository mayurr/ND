<?php
include_once ("SqlWrapper/Class.DatabaseAlt.php");
session_start();
$db = new DatabaseAlt();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="css/page5.css" />
</head>
<body >
<?php
$profileID=$_SESSION['user1']['userId'];
if(isset($_POST['profileID'])){
$profileID=$_POST['profileID'];
}
$db->setQuery("SELECT * FROM history where getter_id='".$profileID."' OR giver_id='".$profileID."'");
$result=$db->executeQuery();
echo '<table width="200" cellspacing="0" id="profileTable">
	  <tr>
		<td align="center"><img src="images/'.$_SESSION['user1']["image"].'" /></td>
	  </tr>
	  <tr>
		<td align="center">'.$_SESSION['user1']["firstName"].' '.$_SESSION['user1']["lastName"].'</td>
	  </tr>
</table>';

$flagGetter = 0;
$flagGiver = 0;
$row = "<table id=storyTable>";
if ($result != FALSE) {
	for ($i=0;$i<sizeof($result);$i++) {
		for ($j=0;$j<sizeof($_SESSION['users']);$j++) {
			if($_SESSION['users'][$j]['userId'] == $result[$i]['getter_id']) {
				$getterName = $_SESSION['users'][$j]['firstName']." ".$_SESSION['users'][$j]['lastName'];
				$getterImage = $_SESSION['users'][$j]['image'];
				break;
			}
		}
		for ($j=0;$j<sizeof($_SESSION['users']);$j++) {
			if($_SESSION['users'][$j]['userId'] == $result[$i]['giver_id']) {
				$giverName = $_SESSION['users'][$j]['firstName']." ".$_SESSION['users'][$j]['lastName'];
				$giverImage = $_SESSION['users'][$j]['image'];
				break;
			}
		}
		$row .= "<tr>";
		if($result[$i]['transaction_type'] == "give"){
			$row .=		"<td align=center><img src='images/".$giverImage."' width=50 height=50 /><br/><br/>".$giverName."</td>";
			$row .= 	"<td align=center class='bigFont' width=100>".Gave."</td>";
			$row .=		"<td align=center><img src='images/".$result[$i]['object_type'].".png' width=50 height=50 /><br/><br/>".$result[$i]['object_type']."</td>";
			$row .=		"<td align=center><img src='uploads/".$result[$i]['object_image']."' width=50 height=50 /><br/><br/>".$result[$i]['object_name']."</td>";
			$row .= 	"<td align=center class='bigFont' width=100>".To."</td>";
			$row .=		"<td align=center><img src='images/".$getterImage."' width=50 height=50 /><br/><br/>".$getterName."</td>";
			$row .=		"<td align=center class='bigFont'>".$result[$i]['status']."</td>";
		}
		else {
			$row .=		"<td align=center><img src='images/".$getterImage."' width=50 height=50 /><br/><br/>".$getterName."</td>";
			$row .= 	"<td align=center class='bigFont' width=100>".Got."</td>";
			$row .=		"<td align=center><img src='images/".$result[$i]['object_type'].".png' width=50 height=50 /><br/><br/>".$result[$i]['object_type']."</td>";
			$row .=		"<td align=center><img src='uploads/".$result[$i]['object_image']."' width=50 height=50 /><br/><br/>".$result[$i]['object_name']."</td>";
			$row .= 	"<td align=center class='bigFont' width=100>".From."</td>";
			$row .=		"<td align=center><img src='images/".$giverImage."' width=50 height=50 /><br/><br/>".$giverName."</td>";
			$row .=		"<td align=center class='bigFont'>".$result[$i]['status']."</td>";
		}
		$row .= "</tr>";
	}
}
$row .= "</table>";
echo $row;
?>
</body>
</html>