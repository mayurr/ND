window.onload = fetchNotifications();

function fetchNotifications() {
	$.ajax({
		url:'Controller/controller.notification.php',
		data:{userId:userId,action:"FetchNotifications"},
		type:'post',
		success:function(data){
			if(data == "empty") {
				alert("No new Notifications!");
				window.location = "view.php";
			}
			else{
				data = data.split(":::");
				dataInfo1=eval("("+data[0]+")");
				dataInfo2=eval("("+data[1]+")");
				var row = "<table id=notificationsTable>";
				if(dataInfo1.result1[0]['empty'] != "empty") {
					for(var i=0;i<dataInfo1.result1.length;i++) {
						row += "<tr>";
						row += "<td align=center><img src='images/"+dataInfo1.result1[i]["giverImage"]+"' width=50 height=50 /><br/><br/>"+dataInfo1.result1[i]["giverName"]+"</td>";
						row += "<td align=center class='bigFont' width=100>Has Chosen To Give</td>";
						row += "<td align=center><img src='uploads/"+dataInfo1.result1[i]["objectImage"]+"' width=50 height=50 /><br/><br/>"+dataInfo1.result1[i]["objectName"]+"</td>";
						row += "<td align=center class='bigFont' width=100>To You.</td>";
						row += "<td align=center><button class='notificationButtons' id="+dataInfo1.result1[i]["getterId"]+"-"+dataInfo1.result1[i]["giverId"]+"-"+dataInfo1.result1[i]["objectId"]+"-"+dataInfo1.result1[i]["applicantId"]+"-"+dataInfo1.result1[i]["giveId"]+"-give onclick=confirmReceipt(this.id);>Completed</button><br/><button class='notificationButtons' id="+dataInfo1.result1[i]["getterId"]+"-"+dataInfo1.result1[i]["giverId"]+"-"+dataInfo1.result1[i]["objectId"]+"-"+dataInfo1.result1[i]["applicantId"]+"-"+dataInfo1.result1[i]["giveId"]+"-give onclick=confirmNonReceipt(this.id);>Cancelled</button><br/><button class='notificationButtons' onclick='skip();'>Not Yet</button></td>";						
						row += "</tr>";
					}
				}
				if(dataInfo2.result2[0]['empty'] != "empty") {
					for(var i=0;i<dataInfo2.result2.length;i++) {
						row += "<tr>";
						row += "<td width=150 align=center class='bigFont' width=100>You have Chosen To Get</td>";
						row += "<td width=150 align=center><img src='uploads/"+dataInfo2.result2[i]["objectImage"]+"' width=50 height=50 /><br/><br/>"+dataInfo2.result2[i]["objectName"]+"</td>";
						row += "<td width=50align=center class='bigFont' width=100>From </td>";
						row += "<td width=150 align=center><img src='images/"+dataInfo2.result2[i]["giverImage"]+"' width=50 height=50 /><br/><br/>"+dataInfo2.result2[i]["giverName"]+"</td>";
						row += "<td align=center><button class='notificationButtons' id="+dataInfo2.result2[i]["getterId"]+"-"+dataInfo2.result2[i]["giverId"]+"-"+dataInfo2.result2[i]["objectId"]+"-"+dataInfo2.result2[i]["applicantId"]+"-"+dataInfo2.result2[i]["getId"]+"-get onclick=confirmReceipt(this.id);>Completed</button><br/><button class='notificationButtons' id="+dataInfo2.result2[i]["getterId"]+"-"+dataInfo2.result2[i]["giverId"]+"-"+dataInfo2.result2[i]["objectId"]+"-"+dataInfo2.result2[i]["applicantId"]+"-"+dataInfo2.result2[i]["getId"]+"-get onclick=confirmNonReceipt(this.id);>Cancelled</button><br/><button class='notificationButtons' onclick='skip();'>Not Yet</button></td>";						
						row += "</tr>";
					}
				}
				row += "</table>";
				$("#notifications").html(row);
			}
		}
	});
}

function confirmReceipt(id) {
	tempArray = id.split("-");
	getterId = tempArray[0];
	giverId = tempArray[1];
	objectId = tempArray[2];
	applicantId = tempArray[3];
	givegetId = tempArray[4];
	tableName = tempArray[5];
	$.ajax({
		url :"Controller/controller.action.php",
		data:{getterId:getterId,giverId:giverId,objectId:objectId,applicantId:applicantId,givegetId:givegetId,tableName:tableName,action:"ConfirmReceipt"},
		type : 'POST',
		success:function(data){
			$.ajax({
				url :"Controller/controller.move.php",
				data:{getterId:getterId,giverId:giverId,action:"Attract"},
				type : 'POST',
				success:function(data){
					$.ajax({
						url :"Controller/controller.history.php",
						data:{getterId:getterId,giverId:giverId,givegetId:givegetId,objectId:objectId,type:tableName,action:"Insert"},
						type : 'POST',
						success:function(data){
							$("#tab4").removeClass('active');
							var pageNumber = 1;
							var tabNumber = pageNumber;
							$("#tab"+tabNumber).addClass('active');
							window.location = "view.php?flag=2&getterId="+getterId+"&giverId="+giverId;
						}
					});
				}
			});
			alert("You have confirmed Receipt!");
		}
	});
}

function confirmNonReceipt(applicantId) {
	tempArray = id.split("-");
	getterId = tempArray[0];
	giverId = tempArray[1];
	objectId = tempArray[2];
	applicantId = tempArray[3];
	givegetId = tempArray[4];
	tableName = tempArray[5];
	$.ajax({
		url :"Controller/controller.action.php",
		data:{getterId:getterId,giverId:giverId,objectId:objectId,applicantId:applicantId,givegetId:givegetId,tableName:tableName,action:"ConfirmNonReceipt"},
		type : 'POST',
		success:function(data){
			$.ajax({
				url :"Controller/controller.move.php",
				data:{getterId:getterId,giverId:giverId,action:"Repel"},
				type : 'POST',
				success:function(data){
					$.ajax({
						url :"Controller/controller.history.php",
						data:{getterId:getterId,giverId:giverId,givegetId:givegetId,objectId:objectId,type:tableName,action:"Insert"},
						type : 'POST',
						success:function(data){
							$("#tab4").removeClass('active');
							var pageNumber = 1;
							var tabNumber = pageNumber;
							$("#tab"+tabNumber).addClass('active');
							window.location = "view.php?flag=2&getterId="+getterId+"&giverId="+giverId;
						}
					});
				}
			});
			alert("You have confirmed Non Receipt!");
		}
	});
}

function skip() {
	window.location = "view.php";
}