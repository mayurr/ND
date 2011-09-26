var applicantsUserId;
window.onload = checkFlag();

function checkFlag() {
	if(flag == 1) {		
		showApplicants(getId);
	}
}

function showApplication() {
	$("#submit").hide();
	$("#applicantsContainer").animate({"top": "+=120px"}, "fast");
	$("#confirmApplication").show();
}

function cancelApply(){
	$("#confirmApplication").hide();
	$("#applicantsContainer").animate({"top": "-=120px"}, "fast");
	$("#submit").show();
}

function addApplicant() {
	$("#loadingImageLeft").show();
	$("#confirmApplication").hide();
	//$("#submit").hide();
	$("#applicantsContainer").animate({"top": "-=120px"}, "fast");
	var comments = $("#applicantComments").val();
	$.ajax({
		url :"Controller/controller.action.php",
		data:{givegetId:getId,comments:comments,action:"AddApplicant"},
		type : 'POST',
		success:function(data){
			showApplicants(getId);
		}
	});
}

function showApplicants(id) {
	$("#loadingImageLeftTop").show();
	$("#applicantsContainer").html("");
	var tempArray = id.split("w");
	if(tempArray.length > 1) {
		$("#"+id).addClass("getRowClickBorder");
		getId = tempArray[1];
	}
	else {
		$("#getRow"+id).addClass("getRowClickBorder");
		getId = id;
	}
	$.ajax({
		url :"Controller/controller.action.php",
		data:{userId:userId,givegetId:getId,action:"ShowApplicants"},
		type : 'POST',
		success:function(data){
			dataInfo=eval("("+data+")");
			if(dataInfo.result[0]['empty'] != "empty") {
				var row = "<table id=applicantList>";
				/*for(var j=0;j<dataInfo.result.length;j++){
					applicantsArray[j] = dataInfo.result[j]['applicantId'];
				}*/
				var alreadyApplied = 0;
				var chosenFlag = 0;
				for(var i=0;i<dataInfo.result.length;i++){
					row += "<tr id=appRow"+dataInfo.result[i]["applicantId"]+">";
					row += "<td><table><tr>";
					row += 		"<td height=100 width=60 align=center><img height=50 width=50 src=images/"+dataInfo.result[i]['userImage']+" /></td>";
					row += 		"<td width=100 align=left>"+dataInfo.result[i]['firstName']+" "+dataInfo.result[i]['lastName']+"</td>";
					for(var j=0;j<dataInfo.result.length;j++){
						if(dataInfo.result[j]['status'] == "Chosen") {
							chosenFlag = 1;
							break;
						}						
					}
					row += 		"<td width=200 align=left>"+dataInfo.result[i]['comments']+"</td>";
					
					if(flag == 1){
						if(dataInfo.result[i]['userId'] == sessionUserId) {
							if(dataInfo.result[i]['status'] == "Pending"){
								row += 		"<td width=100 align=center>"+dataInfo.result[i]['status']+"<br /><br /><button id="+dataInfo.result[i]['applicantId']+" onclick='withdrawApplication(this.id);'>Withdraw</button></td>";
							}
							else if(dataInfo.result[i]['status'] == "Chosen"){
								row += 		"<td width=100 align=center>"+dataInfo.result[i]['status']+"<br /><br />Confirmation Pending</td>";
							}
							else {
								row += 		"<td width=100 align=center>"+dataInfo.result[i]['status']+"<br /><br /></td>";
							}
							alreadyApplied = 1;
						}
						else{
							row += 		"<td width=100 align=center>"+dataInfo.result[i]['status']+"<br /><br /></td>";
						}
					}
					else {
						if(dataInfo.result[i]['status'] == "Pending"){
							if(!chosenFlag) {
								row += 		"<td width=100 align=center>"+dataInfo.result[i]['status']+"<br /><br /><button id="+dataInfo.result[i]['applicantId']+" onclick='chooseApplicant(this.id);'>Get</button></td>";
							}
							else {
								row += 		"<td width=100 align=center>"+dataInfo.result[i]['status']+"<br /><br /></td>";
							}
						}
						else if(dataInfo.result[i]['status'] == "Chosen"){
							applicantsUserId = dataInfo.result[i]['userId'];
							row += 		"<td width=100 align=center>"+dataInfo.result[i]['status']+"<br /><br /></td>";
						}
						else if(dataInfo.result[i]['status'] == "Withdrawn"){
							row += 		"<td width=100 align=center>"+dataInfo.result[i]['status']+"<br /><br /></td>";
						}
						else {
							row += 		"<td width=100 align=center>"+dataInfo.result[i]['status']+"<br /><br /></td>";
						}
					}
					
					row += "</tr></table></td>";
					row += "</tr>";
					row += "<tr><td><div id=separatorContainer><div id=separator></div></div></td></tr>";
				}
				row += "</table>";
				$("#loadingImageLeftBottom").hide();
				$("#applicantsContainer").html(row);
				if(alreadyApplied == 1) {
					$("#submit").hide();
				}
				else{
					$("#submit").show();
				}
			}
			$("#loadingImageLeftTop").hide();
			$("#objectType").val(dataInfo.result1[0]['objectType']);
			$("#getImage").attr('src',"uploads/"+dataInfo.result1[0]['objectImage']);
			$("#objectName").val(dataInfo.result1[0]['objectName']);
			$("#desc").val(dataInfo.result1[0]['objectDescription']);
			$("#comments").val(dataInfo.result1[0]['comments']);
			$("#location").val(dataInfo.result1[0]['location']);
			$("#popupDatepicker").val(dataInfo.result1[0]['startDate']);
			$("#popupDatepickerEnd").val(dataInfo.result1[0]['endDate']);
		}
	});
}

function chooseApplicant(applicantId){
	$("#loadingImageLeft").show();
	$.ajax({
		url :"Controller/controller.action.php",
		data:{applicantId:applicantId,givegetId:getId,action:"ChooseUser"},
		type : 'POST',
		success:function(data){
			showApplicants(getId);
		}
	});
}

function confirmReceipt(applicantId) {
	$.ajax({
		url :"Controller/controller.action.php",
		data:{getterId:sessionUserId,giverId:applicantsUserId,applicantId:applicantId,givegetId:getId,tableName:"get",action:"ConfirmReceipt"},
		type : 'POST',
		success:function(data){
			$.ajax({
				url :"Controller/controller.move.php",
				data:{getterId:sessionUserId,giverId:applicantsUserId,action:"Attract"},
				type : 'POST',
				success:function(data){
					$.ajax({
						url :"Controller/controller.history.php",
						data:{getterId:sessionUserId,giverId:applicantsUserId,givegetId:getId,objectId:objectId,type:"get",action:"Insert"},
						type : 'POST',
						success:function(data){
							$("#tab2").removeClass('active');
							var pageNumber = 1;
							var tabNumber = pageNumber;
							$("#tab"+tabNumber).addClass('active');
							$("#pageContainer").load("page"+tabNumber+".php?flag=1&getterId="+sessionUserId+"&giverId="+applicantsUserId);
						}
					});
				}
			});
			alert("Congratulations on getting the Get!");
		}
	});
}

function confirmNonReceipt(applicantId) {
	$.ajax({
		url :"Controller/controller.action.php",
		data:{getterId:sessionUserId,giverId:applicantsUserId,applicantId:applicantId,givegetId:getId,tableName:"get",action:"ConfirmNonReceipt"},
		type : 'POST',
		success:function(data){
			$.ajax({
				url :"Controller/controller.move.php",
				data:{getterId:sessionUserId,giverId:applicantsUserId,action:"Repel"},
				type : 'POST',
				success:function(data){
					$.ajax({
						url :"Controller/controller.history.php",
						data:{getterId:sessionUserId,giverId:applicantsUserId,givegetId:getId,objectId:objectId,type:"get",action:"Insert"},
						type : 'POST',
						success:function(data){
							$("#tab2").removeClass('active');
							var pageNumber = 1;
							var tabNumber = pageNumber;
							$("#tab"+tabNumber).addClass('active');
							$("#pageContainer").load("page"+tabNumber+".php?flag=1&getterId="+sessionUserId+"&giverId="+applicantsUserId);
						}
					});
				}
			});
			alert("You have confirmed Non Receipt!");
		}
	});
}

function withdrawApplication(applicantId) {
	$.ajax({
		url :"Controller/controller.action.php",
		data:{applicantId:applicantId,action:"WithdrawApplication"},
		type : 'POST',
		success:function(data){
			showApplicants(getId);
		}
	});
}

function addBorder(id) {
	$("#"+id).addClass("getRowBorder");
}

function removeBorder(id) {
	$("#"+id).removeClass("getRowBorder");
}

$(document).ready(function(){
	$('#popupDatepicker').datepick();
	$('#popupDatepickerEnd').datepick();
});

function getImage(changeImgVal){
	if(changeImgVal=="Type"){
		$("#leftContainerContents").hide();
	}
	else{
		$("#leftContainerContents").show();
		$("#nameDiv").show();
		$("#Location").show();
		$("#description").show();
		$("#notes").show();
		$("#calendarStart").show();
		$("#calendarEnd").show();
		$("#submit").show();
		if(changeImgVal=="Time"){
			$('#right_col').css("background-image", "url(images/time.jpg)"); 
			document.getElementById("selectImg").style.visibility="hidden";
		}
		if(changeImgVal=="Space"){
			$('#right_col').css("background-image", "url(images/space.jpg)"); 
			document.getElementById("selectImg").style.visibility="hidden";
		}
		if(changeImgVal=="Information"){
			$('#right_col').css("background-image", "url(images/info.jpg)");
			document.getElementById("selectImg").style.visibility="hidden"; 
		 }
		if(changeImgVal=="Items"){
			document.getElementById("selectImg").style.visibility="visible";
			$('#right_col').css("background-image", "");
		}
		if(changeImgVal=="Health"){
			$('#right_col').css("background-image", "url(images/health.jpg)"); 
			document.getElementById("selectImg").style.visibility="hidden";
		}
	}
}

function giveData(){
	var name=document.getElementById("objectName").value;
	var desc=document.getElementById("desc").value;
	var dropDown=document.getElementById("dropDown").value;
	var location=document.getElementById("location").value;
	//if(dropDown=="Items"){
	var imagePath=$("#example1").attr("href");
	if(imagePath != undefined) {
		var imageArr=imagePath.split("/");
		//alert(imageArr);
		var image = imageArr[4];
	}
	
	var start=document.getElementById("popupDatepicker").value;
	var arrStart = start.split("/");
	var year=arrStart[2];
	var month=arrStart[0];
	var day=arrStart[1];
	var arr=new Array();
	arr[0]=year;
	arr[1]=month;
	arr[2]=day;
	var startDate=arr.join("-");
	
	var end=document.getElementById("popupDatepickerEnd").value;	
	var arrEnd = end.split("/");
	var endyear=arrEnd[2];
	var endmonth=arrEnd[0];
	var endday=arrEnd[1];
	var arrEndDate=new Array();
	arrEndDate[0]=endyear;
	arrEndDate[1]=endmonth;
	arrEndDate[2]=endday;	
	var endDate=arrEndDate.join("-");	
	
	var comments=document.getElementById("comments").value;
	if(image==""){
		alert("Upload Image");
		return false;
	}
	else if(name=="Name"){
		alert("Enter Name");
		return false;
	}
	else if(location=="Location"){
		alert("Enter Location");
		return false;
	}
	else if(desc=="Description"){
		alert("Enter Description");
		return false;
	}
	else if(comments=="Additional Info"){
		alert("Enter Additional Info");
		return false;
	}
	else if(dropDown=="Type"){
		alert("Enter type");
		return false;
	}
	else if(start=="Start"){
		alert("Enter Start Date");
		return false;
	}
	else if(end=="End"){
		alert("Enter End Date");
		return false;
	}
	
	else{
		$("#loadingImageRight").show();
		$.ajax({
			url :"Controller/controller.action.php",
			data:{type:dropDown,name:name,description:desc,image:image,startDate:startDate,endDate:endDate,comments:comments,location:location,action:"Get"},
			type : 'POST',
			success:function(data){
				$("#leftContainerContents").hide();
				$("#dropDown").val("Select");
				$("#example1").remove();
				$("#image").val("");
				$("#objectName").val("");
				$("#desc").val("");
				$("#comments").val("");
				$("#location").val("");
				$("#popupDatepicker").val("");
				$("#popupDatepickerEnd").val("");
				var dataString = data+"::"+startDate+"::"+endDate+"::"+comments+"::Active::"+name+"::"+desc+"::"+image+"::"+dropDown;
				addNewGetToList(dataString);
			}
		});
	}		
}

function addNewGetToList(dataString){
	var tempArray = dataString.split("::");
	var getId = tempArray[0];
	var userId = tempArray[1];
	var objectId = tempArray[2];
	var startDate = tempArray[3];
	var endDate = tempArray[4];
	var comments = tempArray[5];
	var status = tempArray[6];
	var name = tempArray[7];
	var description = tempArray[8];
	var image = tempArray[9];
	var type = tempArray[10];
	
	var row = "";
	row += "<tr>";
	row +=	   "<td class='getRow' id=getRow"+getId+" onmouseover='addBorder(this.id);' onmouseout='removeBorder(this.id);' onclick='showApplicants(this.id);'>";
	row +=	   "<table>";
	row +=	   		"<tr><td><table><tr>";
	row +=	   			"<td width=150 height=100 align=center><img class='getListImage' width=100 height=100 src=uploads/"+ image +" /></td>";
	row +=	   			"<td width=300 height=100 align=left><p class='getListDescription'>"+ description +"</p></td>";
	row +=	   		"</tr></table></td></tr>";
	row +=	   		"<tr><td><table><tr>";
	row +=	   			"<td width=150 height=10 align=center><p class='getListName'>"+ name +"</p></td>";
	row +=	   			"<td width=150 height=10 align=left><p class='getListStartDate'>Start: "+ startDate +"</p></td>";
	row +=	   			"<td width=150 height=10 align=left><p class='getListEndDate'>End: "+ endDate +"</p></td>";
	row +=	   		"</tr></table></td></tr>";
	row +=	   "</table>";
	row +=	   "</td>";
	row += "</tr>";
	row +=	   "<tr><td><div id=separatorContainer><div id=separator></div></div></td></tr>";
	
	if($("#getList").length > 0){
		$("#loadingImage").hide();
		$("#getList").prepend(row);
	}
	else{
		$("#loadingImageRight").hide();
		var row = "<table id='getList'>"+row+"</table>";
		$("#rightContainer").html(row);
	}
}

var custuploadblocks = document.getElementsByTagName('dd');
for (var i = 0; i < custuploadblocks.length; i++) {
	if (custuploadblocks[i].className == 'custuploadblock') {
		custuploadblocks[i].id = 'right_col';
	}
}

var transfileforms = document.getElementsByTagName('input');
for (var i = 0; i < transfileforms.length; i++) {
	if (transfileforms[i].className == 'transfileform') {
		var newform = transfileforms[i].cloneNode(true);
		newform.id = 'right_col_upload';
		newform.style.opacity = 0; // css3 (safari2+ and opera9+)
		newform.style.MozOpacity = 0; // firefox1.5+
		newform.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity:0)'; // IE5.5+
		var parent_element = transfileforms[i].parentNode;
		parent_element.removeChild(transfileforms[i]);
		parent_element.appendChild(newform);
		var upload_area=document.createElement("div");
		upload_area.setAttribute('id','upload_area');
		parent_element.appendChild(upload_area);
		
	}
}
