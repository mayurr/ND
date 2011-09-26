// JavaScript Document
function feedBackYes(){
	$("#feedbackForm").show();
}

function feedBackNo(){
	window.location="logout.php";
}

function sentFeedback(){
	var feedback=$("#feedbackArea").val();
	
	$.ajax({
		url :"Controller/controller.action.php",
		data:{feedback:feedback,userId:userId,action:"SendFeedback"},
		type : 'POST',
		success:function(data){
			alert("Thank You!");
			window.location="logout.php";
		}
	});
}