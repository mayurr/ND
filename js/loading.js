var flag1 = 0;
var flag2 = 0;
var flag3 = 0;
window.onload = loadData();

function loadData() {
	$.ajax({
		url:'Controller/controller.user.php',
		data:{action:"GetAllUsers"},
		type:'post',
		success:function(data){
			flag1 = 1;
			if(parseInt(data) > 0){
				$.ajax({
					url:'Controller/controller.action.php',
					data:{action:"GetAllGives"},
					type:'post',
					success:function(data){
						flag2 = 1;
						$.ajax({
							url:'Controller/controller.action.php',
							data:{action:"GetAllGets"},
							type:'post',
							success:function(data){
								flag3 = 1;
								$.ajax({
									url:'Controller/controller.action.php',
									data:{action:"GetAllApplicants"},
									type:'post',
									success:function(data){
										flag4 = 1;
										$.ajax({
											url:'Controller/controller.notification.php',
											data:{userId:userId,action:"CheckNotifications"},
											type:'post',
											success:function(data){
												if(flag1 == 1 && flag2 == 1 && flag3 == 1 && flag4 == 1) {
													$("#loadingImage").hide();
													$("#loadingText").hide();
													if(data == "0") {
														window.location = "view.php";														
													}
													else {
														window.location = "notifications.php"
													}
												}
												else {
													stepVal += 1;
													//window.location = "loading.php?step="+stepVal;
												}
											}
										});
									}
								});
							}
						});
					}
				});
			}
		}
	});	
}