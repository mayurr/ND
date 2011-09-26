<?php
session_start();
if(!isset($_SESSION['userId'])) {
	header("Location:index.php");
}
$userId=$_GET['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="css/view.css"/>
<link rel="stylesheet" type="text/css" href="css/feedback.css"/>
<script type="text/javascript" src="lib/jquery.js"></script>
<script type="text/javascript" src="js/feedback.js"></script>
<script type="text/javascript">var userId = "<?php echo $userId; ?>";</script>
</head>

<body>
<div id="wrapper">
    <div id="headName">Naya Daur</div>
    <div id="feedback">
    	<p id="feedbackP">Feedback</p>
        <p id="feedbackButtons">
        	<button onclick="feedBackYes();">Yes</button>
           <button onclick="feedBackNo();">No</button>
        </p>
        <div id="feedbackForm">
        	<textarea  id="feedbackArea"></textarea><br />
           <button id="fbSubmit" onclick="sentFeedback();">Submit</button>
        </div>
    </div>
</div>
</body>
</body>
</html>