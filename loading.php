<?php
session_start();
if(isset($_POST['step'])) {
	$stepVal = $_POST['step'];
}
else {
	$stepVal = 0;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Naya Daur</title>
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
	<link href="css/nd.css" rel="stylesheet"/>
	<script type="text/javascript">
		var userId = "<?php echo $_SESSION['userId'];?>";
		var stepVal = "<?php echo $stepVal;?>";
	</script>
	<script type="text/javascript" src="lib/jquery.js"></script>
	<script type="text/javascript" src="js/loading.js"></script>
</head>

<body>
	<div id="wrapper">
		<img id="loadingImage" src="images/circular.gif"></img>
	</div>
</body>
</html>