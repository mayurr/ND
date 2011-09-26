<?php
session_start();
include_once ("../SqlWrapper/Class.DatabaseAlt.php");
include_once ("../Model/class.mail.php");
error_reporting(E_ALL ^ E_NOTICE);
if (!isset($_SESSION['adminId'])) {
	header("Location:adminLogin.php");
}
$db = new DatabaseAlt();
$db->setQuery("SELECT * FROM history ORDER BY closing_timestamp ASC");
$result=$db->executeQuery();
$db->setQuery("SELECT * FROM users");
$result1=$db->executeQuery();
$row = "<table>";
if ($result != FALSE) {
	$count = 0;
	for ($i=0;$i<sizeof($result);$i++) {
		for ($j=0;$j<sizeof($result1);$j++) {
			if($result1[$j]['user_id'] == $result[$i]['getter_id']) {
				$getterName = $result1[$j]['first_name']." ".$result1[$j]['last_name'];
				$getterImage = $result1[$j]['image'];
				break;
			}
		}
		for ($j=0;$j<sizeof($result1);$j++) {
			if($result1[$j]['user_id'] == $result[$i]['giver_id']) {
				$giverName = $result1[$j]['first_name']." ".$result1[$j]['last_name'];
				$giverImage = $result1[$j]['image'];
				break;
			}
		}
		$row .= "<tr>";
		if($result[$i]['transaction_type'] == "give"){
			$row .=		"<td align=center><img src='www.nayadaur.org/images/".$giverImage."' width=50 height=50 /><br/>".$giverName."</td>";
			$row .= 	"<td align=center class='bigFont' width=100>".Gave."</td>";
			$row .=		"<td align=center><img src='www.nayadaur.org/images/".$result[$i]['object_type'].".png' width=50 height=50 /><br/>".$result[$i]['object_type']."</td>";
			$row .=		"<td align=center><img src='www.nayadaur.org/uploads/".$result[$i]['object_image']."' width=50 height=50 /><br/>".$result[$i]['object_name']."</td>";
			$row .= 	"<td align=center class='bigFont' width=100>".To."</td>";
			$row .=		"<td align=center><img src='www.nayadaur.org/images/".$getterImage."' width=50 height=50 /><br/>".$getterName."</td>";
			//$row .=		"<td align=center class='bigFont'>".$result[$i]['status']."</td>";
		}
		else {
			$row .=		"<td align=center><img src='www.nayadaur.org/images/".$getterImage."' width=50 height=50 /><br/>".$getterName."</td>";
			$row .= 	"<td align=center class='bigFont' width=100>".Got."</td>";
			$row .=		"<td align=center><img src='www.nayadaur.org/images/".$result[$i]['object_type'].".png' width=50 height=50 /><br/>".$result[$i]['object_type']."</td>";
			$row .=		"<td align=center><img src='www.nayadaur.org/uploads/".$result[$i]['object_image']."' width=50 height=50 /><br/>".$result[$i]['object_name']."</td>";
			$row .= 	"<td align=center class='bigFont' width=100>".From."</td>";
			$row .=		"<td align=center><img src='www.nayadaur.org/images/".$giverImage."' width=50 height=50 /><br/>".$giverName."</td>";
			//$row .=		"<td align=center class='bigFont'>".$result[$i]['status']."</td>";
		}
		$row .= "</tr>";
		if($count == 0) {
			$row1 = $row."</table>";
			$count += 1;
		}
		$row .= "<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
	}
}
$row .= "</table>";
for($i=0;$i<sizeof($result1);$i++) {
	$message = "<html><head></head><body>";
	$message .= "<p>Greetings ".$result1[$i]['first_name']."!</p>";
	$message .= "<p>It has been a week since the alpha release of our little experiment, and we are getting cautiously excited with the rising swell of activity.</p>";
	$message .= "<p>The first Gift ever given on Naya Daur was:</p>";
	$message .= $row1."<br/>";
	$message .= "<p>In the past week,</p>";
	$message .= $row."<br/>";
	$message .= "<p>The number of Gifts being posted keeps growing: Laptops, Music Systems, and DVDs are on offer, while members of our community need help cleaning, writing and commuting.</p>";
	$message .= "<p>We have had a lot more Gives than Gets, which is nice, but the List page does seem a little imbalanced.</p>";
	$message .= "<p>Is this sustainable? Could we perhaps use a few more Gets?</p>";
	$message .= "<p>Above all, thank you for your continued participation in Naya Daur, despite the rather buggy alpha and sometimes ponderous loading times. We are working hard to improve our performance everyday.</p>";
	$message .= "<p>Keep on Giving(and Getting)!</p>";
	$message .= "<p>Ram</p>";
	$message .= "<p>--</p>";
	$message .= "<p>Admin,</p>";
	$message .= "<p>Naya Daur</p>";
	$message .= "</body></html>";
	
	$mail = new Mail();
	$mail->setSubject("The story so far...");
	$mail->setFrom("admin@nayadaur.org");
	$mail->setMessage($message);
	$mail->setTo($result1[$i]['email']);
	//$mail->sendMail();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>