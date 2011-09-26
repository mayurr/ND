<?php
session_start();
$flag = 0;
if (isset($_GET['userId'])) {
	$userId = $_GET['userId'];
	$getId = $_GET['getId'];
	$objectId = $_GET['objectId'];
}
else {
	$userId = $_SESSION['user1']['userId'];
}

if($userId != $_SESSION['user1']['userId']){
	$flag = 1;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="css/page2.css?<?php echo date("t"); ?>" />
<script type="text/javascript" src="lib/jquery.datepick.js"></script>
<script type="text/javascript">var userId = "<?php echo $userId; ?>";var flag = "<?php echo $flag; ?>";var getId = "<?php echo $getId; ?>";var objectId = "<?php echo $objectId; ?>";var sessionUserId = "<?php echo $_SESSION['user1']['userId']; ?>";var applicantsArray = "<?php echo $_SESSION['applicants'];?>";var getsArray = "<?php echo $_SESSION['gets'];?>";</script>
<script type="text/javascript" src="js/page3.js"></script>
<script type="text/javascript" src="scripts/ajaxupload.js"></script>
<?php 
if ($flag == 0) {
?>
<style type="text/css">
#uploadPhoto{
	display:none;
}
#submit{
	display:none;
}
#dropDown{
	position:absolute;
	font-family:Trebuchet MS;
	font-size:12px;
	margin-top:0px;
	margin-left:5px;
	width:84px;
	border:1px solid #000;	
}
#nameDiv{
	display:none;
}
#Location{
	display:none;
}
#description{
	display:none;
}
#notes{
	display:none;
}
#calendarStart{
	display:none;
}
#calendarEnd{
	display:none;
}
#image{
	display:none;
}
</style>
<?php 
}
else {
?>
<style>
#confirmApplication{
	display:none;
}
</style>
<?php	
}
?>
</head>

<body>
<div id="mainContainer">
	<?php 
	if ($flag == 0){
	?>
	<div id="leftContainer">
		<div id="dropDownDiv">
			<select id="dropDown" onchange="getImage(this.value)">
				<option>Type</option>
		    	<option>Object</option>
		    	<option>Time</option>
		    	<option>Space</option>
		    	<option>Information</option>
		    	<option>Health</option>
			</select>
		</div>
		<div id="leftContainerContents">
	     	<div id="nameDiv">
	     		<input type="text" id="objectName" size="30" onblur="javascript: if(this.value=='') { this.value='Get Name';this.className='blur'}"
                onfocus="javascript: 					if(this.value=='Get Name') {this.value='';this.className='focus'};" value="Get Name"/>
	     	</div>
	     	 <div id="Location"  >
            	<input type="text" id="location" "javascript: if(this.value=='') { this.value='Location';this.className='blur'}"
                onfocus="javascript: 					if(this.value=='Location') {this.value='';this.className='focus'};" value="Location" size="30"/> 
            </div>
	  		<form action="scripts/ajaxupload.php" method="post" name="unobtrusive" id="unobtrusive" enctype="multipart/form-data">
				<input type="hidden" name="maxSize" value="9999999999" />
				<input type="hidden" name="maxW" value="200" />
				<input type="hidden" name="fullPath" value="http://nayadaur.org/uploads/" />
				<input type="hidden" name="relPath" value="../uploads/" />
				<input type="hidden" name="colorR" value="255" />
				<input type="hidden" name="colorG" value="255" />
				<input type="hidden" name="colorB" value="255" />
				<input type="hidden" name="maxH" value="300" />
				<input type="hidden" name="filename" value="filename" />
				<div id="selectImg">
				</div>
				<noscript><p><input type="submit" name="submit" value="Upload Image" /></p></noscript>
				<dd class='custuploadblock'><p id="uploadPhoto">Upload Photo</p><input type="file" name="filename" id="image" value="filename" onchange="ajaxUpload(this.form,'scripts/ajaxupload.php?filename=filename&amp;maxSize=9999999999&amp;maxW=200&amp;fullPath=http://nayadaur.org/uploads/&amp;relPath=../uploads/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=300','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'images/ajax-loader.gif\'  border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;" class='transfileform' /></dd>
				<noscript><p><input type="submit" name="submit" value="Upload Image" /></p></noscript>
				<div id="right_col">
	    			<div id="upload_area"></div>
	    		</div>
			</form>
	   		<div id="description">
	    		<textarea id="desc" rows="5" cols="27" onblur="javascript: if(this.value=='') { this.value='Description';this.className='blur'}"
                onfocus="javascript: 					if(this.value=='Description') {this.value='';this.className='focus'};" >Description</textarea>
	    	</div>
	    	<div id="notes">
	  	 		<textarea id="comments" rows="5" cols="27" onblur="javascript: if(this.value=='') { this.value='Caveats';this.className='blur'}"
                onfocus="javascript: 					if(this.value=='Caveats') {this.value='';this.className='focus'};">Caveats</textarea>
	   		</div>
	    	<div id="calendarStart">
	    		<input type="text" id="popupDatepicker" value="Start" size="10" onblur="javascript: if(this.value=='') { this.value='Start';}"
                onfocus="javascript: 					if(this.value=='Start') {this.value='';this.className='focus'};" />
	    	</div>
	     	<div id="calendarEnd">
	    		<input type="text" id="popupDatepickerEnd" value="End" size="10" onblur="javascript: if(this.value=='') { this.value='End';}"
                onfocus="javascript: 					if(this.value=='End') {this.value='';this.className='focus'};" />
	    	</div>  
           
	    	<button id="submit" onclick="giveData();" name="getSubmit">Add Get</button>
	   	</div>
	   	<div id="applicantsContainer"></div>
	</div>
	<div id="rightContainer">
		<?php
		if($_SESSION['userGets'][0]['getId'] != "empty"){
			echo "<table id='getList'>";
			for($i=0;$i<sizeof($_SESSION['userGets']);$i++){		
				echo "<tr class='getRow'>";
				echo    "<td id=getRow".$_SESSION['userGets'][$i]['getId']." onmouseover='addBorder(this.id);' onmouseout='removeBorder(this.id);' onclick='showApplicants(this.id);'>";
				echo    "<table>";
				echo   		"<tr><td><table><tr>";
				echo   			"<td width=150 height=100 align=center><img class='getListImage' width=100 height=100 src=uploads/".$_SESSION['userGets'][$i]['objectImage']." /></td>";
				echo   			"<td width=300 height=100 align=left><p class='getListDescription'>".$_SESSION['userGets'][$i]['objectDescription']."</p></td>";
				echo   		"</tr></table></td></tr>";
				echo   		"<tr><td><table><tr>";
				echo   			"<td width=150 height=10 align=center><p class='getListName'>".$_SESSION['userGets'][$i]['objectName']."</p></td>";
				echo   			"<td width=150 height=10 align=left><p class='getListStartDate'>Start: ".$_SESSION['userGets'][$i]['startDate']."</p></td>";
				echo   			"<td width=150 height=10 align=left><p class='getListEndDate'>End: ".$_SESSION['userGets'][$i]['endDate']."</p></td>";
				echo   		"</tr></table></td></tr>";
				echo    "</table>";
				echo    "</td>";
				echo "</tr>";
				echo "<tr><td><div id=separatorContainer><div id=separator></div></div></td></tr>";		
			}
			echo "</table>";
		}
		?>
	</div>
	<?php 
	}
	else {
	?>
	<div id="leftContainer">
		<div id="dropDownDiv">
			<input type="text" id="objectType" size="15" />
		</div>
		<div id="leftContainerContentsAlt">
	     	<div id="nameDiv">
	     		<input type="text" id="objectName" size="30" />
	     	</div>
	     	 <div id="Location"  >
            	<input type="text" id="location" size="30" /> 
            </div>
			<div id="right_col">
    			<div id="upload_area">
    				<img id="getImage" height="190" width="190"/>
    			</div>
    		</div>
	   		<div id="description">
	    		<textarea id="desc" rows="5" cols="27"></textarea>
	    	</div>
	    	<div id="notes">
	  	 		<textarea id="comments" rows="5" cols="27"></textarea>
	   		</div>
	    	<div id="calendarStart">
	    		<input type="text" id="popupDatepicker" size="10" disabled="disabled" />
	    	</div>
	     	<div id="calendarEnd">
	    		<input type="text" id="popupDatepickerEnd" size="10" disabled="disabled" />
	    	</div>  
           
	    	<button id="submit" onclick="showApplication();" name="showApplication">Apply</button>
	    	
	    	<div id="confirmApplication">
	    		<textarea id="applicantComments" rows="5" cols="27" onblur="javascript: if(this.value=='') { this.value='Comments';this.className='blur'}" onfocus="javascript: if(this.value=='Comments') {this.value='';this.className='focus'};">Comments</textarea>
	    		<button id="submitApplication" onclick="addApplicant();" name="applicantSubmit">Confirm</button>
	    		<button id="cancelApplication" onclick="cancelApply();" name="applicantCancel">Cancel</button>
	    	</div>
	   	</div>
	   	<img id="loadingImageLeftTop" src="images/circular.gif"></img>
	   	<div id="applicantsContainer"></div>
	   	<img id="loadingImageLeftBottom" src="images/circular.gif"></img>
	</div>
	<div id="rightContainer">
	<?php
		if($_SESSION['gets'][0]['getId'] != "empty"){
			echo "<table id='getList'>";
			for($i=0;$i<sizeof($_SESSION['gets']);$i++){
				if ($_SESSION['gets'][$i]['userId'] == $userId) {	
					$className = "getRow";
					if($_SESSION['gets'][$i]['getId'] == $getId) {
						$className .= "ClickBorder";
					} 
					echo "<tr class='".$className."'>";
					echo    "<td id=getRow".$_SESSION['gets'][$i]['getId']." onmouseover='addBorder(this.id);' onmouseout='removeBorder(this.id);' onclick='showApplicants(this.id);'>";
					echo    "<table>";
					echo   		"<tr><td><table><tr>";
					echo   			"<td width=150 height=100 align=center><img class='getListImage' width=100 height=100 src=uploads/".$_SESSION['gets'][$i]['objectImage']." /></td>";
					echo   			"<td width=300 height=100 align=left><p class='getListDescription'>".$_SESSION['gets'][$i]['objectDescription']."</p></td>";
					echo   		"</tr></table></td></tr>";
					echo   		"<tr><td><table><tr>";
					echo   			"<td width=150 height=10 align=center><p class='getListName'>".$_SESSION['gets'][$i]['objectName']."</p></td>";
					echo   			"<td width=150 height=10 align=left><p class='getListStartDate'>Start: ".$_SESSION['gets'][$i]['startDate']."</p></td>";
					echo   			"<td width=150 height=10 align=left><p class='getListEndDate'>End: ".$_SESSION['gets'][$i]['endDate']."</p></td>";
					echo   		"</tr></table></td></tr>";
					echo    "</table>";
					echo    "</td>";
					echo "</tr>";
					echo "<tr><td><div id=separatorContainer><div id=separator></div></div></td></tr>";		
				}
			}
			echo "</table>";
		}
		?>
	</div>
	<?php
	}
	?>
	<img id="loadingImageRight" src="images/circular.gif"></img>
</div>

</body>
</html>