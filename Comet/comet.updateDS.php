<?php
session_start();
$curl_handle=curl_init();
curl_setopt($curl_handle,CURLOPT_URL,'../SqlWrapper/Class.DatabaseAlt.php');
curl_exec($curl_handle);
curl_close($curl_handle);

$db = new DatabaseAlt();
?>