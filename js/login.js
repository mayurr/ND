$(document).ready(function(){
	$("#enter").click(function(){
		$("#loginForm").show();
		$("#invalidText").hide();
	});
	
	$("#password").keyup(function(event){
		if(event.keyCode == 13){
			$("#loginBtn").click();
		}
	});
	
	$("#userName").keyup(function(event){
		if(event.keyCode == 13){
			$("#loginBtn").click();
		}
	});
});

function submitLogin() {
	var userName = document.getElementById("userName").value;
	var password = document.getElementById("password").value;
	var loginFlag = 0;
	$.ajax({
		url:'Controller/controller.login.php',
		data:{userName:userName,password:password,action:"Check"},
		type:'post',
		success:function(data){
			if (data != "") {
				window.location = "loading.php";
			}
			else{
				window.location = "index.php?flag=1";
			}
		}
	});
}