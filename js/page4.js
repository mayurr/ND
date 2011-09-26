window.onload = getData();

function getData() {
	$.ajax({
		url:'Controller/controller.give.php',
		data:{action:"GetAllGives"},
		type:'post',
		success:function(data){
			var dataObject = eval("("+data+")");
			var row = "<table>";
			for (var i=0;i<dataObject.length;i++) {				
				var className = "giveList";
				if(dataObject[i]['status'] == "Failure"){
					className += "Fail";
				}
				row += "<tr>";
				row += "<td class='"+className+"' id='"+dataObject[i]['user_id']+"-"+dataObject[i]['give_id']+"-"+dataObject[i]['object_id']+"' onmouseover='addGiveBorder(this.id);' onmouseout='removeGiveBorder(this.id);' onclick=showGive(this.id);>";
				row += "<table><tr>";
				row += "<td align=center width=80><img width=55 height=55 src='images/"+dataObject[i]['type']+".png' /><br />"+dataObject[i]['type']+"</td>";
				row += "<td align=center width=140><img width=55 height=55 src=uploads/"+dataObject[i]['object_image']+" /><br />"+dataObject[i]['name']+"</td>";
				row += "<td align=center width=140><img width=55 height=55 src=images/"+dataObject[i]['user_image']+" /><br />"+dataObject[i]['first_name']+" "+dataObject[i]['last_name']+"</td>";
				row += "<td>"+dataObject[i]['start_date']+"<br /><br />"+dataObject[i]['end_date']+"</td>";
				row += "</tr></table>";
				row += "</td>";
				row += "</tr>";
			}
			row += "</table>";
			$("#loadingImageLeft").hide();
			$("#loadingImageRight").hide();
			$("#giveTable").html(row);
		}
	});
}

function showGive(id) {
	var tempArray = id.split("-");
	var userId = tempArray[0];
	var giveId = tempArray[1];
	var objectId = tempArray[2];
	
	var pageNumber = 2;
	var tabNumber = pageNumber;
	$("#pageContainer").load("page"+tabNumber+".php?userId="+userId+"&giveId="+giveId+"&objectId="+objectId);
}

function showGet(id) {
	var tempArray = id.split("-");
	var userId = tempArray[0];
	var getId = tempArray[1];
	var objectId = tempArray[2];
	
	var pageNumber = 3;
	var tabNumber = pageNumber;
	$("#pageContainer").load("page"+tabNumber+".php?userId="+userId+"&getId="+getId+"&objectId="+objectId);
}

function addGiveBorder(id) {
	$("#"+id).addClass("giveListBorder");
}

function removeGiveBorder(id) {
	$("#"+id).removeClass("giveListBorder");
}

function addGetBorder(id) {
	$("#"+id).addClass("getListBorder");
}

function removeGetBorder(id) {
	$("#"+id).removeClass("getListBorder");
}