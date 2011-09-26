<?php
session_start();
include_once ("../Model/class.move.php");
include_once ("../Model/class.user.php");

switch ($_POST['action']) {
	case "Attract":
		$move = new Move();
		$user = new User();
		
		$move->setUserId($_POST['getterId']);
		$getterPosition = $move->getPosition();
		$getterX = (float)$getterPosition[0]['x'];
		$getterY = (float)$getterPosition[0]['y'];
		
		$move->setUserId($_POST['giverId']);
		$giverPosition = $move->getPosition();
		$giverX = (float)$giverPosition[0]['x'];
		$giverY = (float)$giverPosition[0]['y'];
		
		$move->setX1($getterX);
		$move->setY1($getterY);
		$move->setX2($giverX);
		$move->setY2($giverY);
		$distance = $move->getDistance();
		if(($distance-11.00)>11.00) {		
			$getterDx = $move->getDx((float)$distance);
			$getterDy = $move->getDy((float)$distance);
			$giverDx = -$getterDx;
			$giverDy = -$getterDy;
			
			$newGetterX = $getterX + $getterDx;
			$newGetterY = $getterY + $getterDy;
			$newGiverX = $giverX + $giverDx;
			$newGiverY = $giverY + $giverDy;
		}
		
		$user->setId($_POST['getterId']);
		$user->updatePositions($newGetterX, $newGetterY, $getterX, $getterY);
		
		$user->setId($_POST['giverId']);
		$user->updatePositions($newGiverX, $newGiverY, $giverX, $giverY);
		break;
		
	case "Repel":
		$move = new Move();
		$user = new User();
		
		$move->setUserId($_POST['getterId']);
		$getterPosition = $move->getPosition();
		$getterX = (float)$getterPosition[0]['x'];
		$getterY = (float)$getterPosition[0]['y'];
		
		$move->setUserId($_POST['giverId']);
		$giverPosition = $move->getPosition();
		$giverX = (float)$giverPosition[0]['x'];
		$giverY = (float)$giverPosition[0]['y'];
		
		$move->setX1($getterX);
		$move->setY1($getterY);
		$move->setX2($giverX);
		$move->setY2($giverY);
		$distance = $move->getDistance();
		if(($distance-11.00)>11.00) {		
			$getterDx = $move->getDx((float)$distance);
			$getterDy = $move->getDy((float)$distance);
			$giverDx = -$getterDx;
			$giverDy = -$getterDy;
			
			$newGetterX = $getterX - $getterDx;
			$newGetterY = $getterY - $getterDy;
			$newGiverX = $giverX - $giverDx;
			$newGiverY = $giverY - $giverDy;
		}
		
		$user->setId($_POST['getterId']);
		$user->updatePositions($newGetterX, $newGetterY, $getterX, $getterY);
		
		$user->setId($_POST['giverId']);
		$user->updatePositions($newGiverX, $newGiverY, $giverX, $giverY);
		
		for($i=0;$i<sizeof($_SESSION['users']);$i++) {
			if($_SESSION['users'][$i]['userId'] == getterId) {
				$_SESSION['users'][$i]['x'] = $newGetterX;
				$_SESSION['users'][$i]['y'] = $newGetterY;
				$_SESSION['users'][$i]['oldX'] = $getterX;
				$_SESSION['users'][$i]['oldY'] = $getterY;
				break;
			}
		}
		for($i=0;$i<sizeof($_SESSION['users']);$i++) {
			if($_SESSION['users'][$i]['userId'] == giverId) {
				$_SESSION['users'][$i]['x'] = $newGiverX;
				$_SESSION['users'][$i]['y'] = $newGiverY;
				$_SESSION['users'][$i]['oldX'] = $giverX;
				$_SESSION['users'][$i]['oldY'] = $giverY;
				break;
			}
		}
		$_SESSION['user1']['x'] = $newGetterX;
		$_SESSION['user1']['y'] = $newGetterY;
		$_SESSION['user1']['oldX'] = $getterX;
		$_SESSION['user1']['oldY'] = $getterY;
		break;
}
?>