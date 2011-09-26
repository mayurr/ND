<?php
session_start();
$curl_handle=curl_init();
curl_setopt($curl_handle,CURLOPT_URL,'../Model/class.give.php');
curl_exec($curl_handle);
curl_close($curl_handle);

switch ($_POST['action']) {
	case "GetAllGives":
		$fp = fopen("../files/gives.txt", "r");
		$content = fgets($fp);
		$dataObject = base64_decode($content);
		echo $dataObject;
		break;
}
?>