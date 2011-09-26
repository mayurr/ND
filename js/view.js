function setPage(pageNumber) {
	var tabNumber = pageNumber;
	$("#tab"+tabNumber).addClass('active');
	if(flag == "set") {
		$("#pageContainer").load("page1.php?flag=1&getterId="+getterId+"&giverId="+giverId);
	}
	else{
		$("#pageContainer").load("page"+tabNumber+".php");		
	}
}

$(document).ready(function(){
	$(".tab").click(function() {
		$("#loaderImg").show();
		$(this).addClass('active'); //make this tab active
		$(".tab").not(this).removeClass('active'); //make other tabs inactive
		
		var tabId = $(this).attr("id");
		$.ajax({
			url:'Controller/controller.setPage.php',
			data:{tabId:tabId},
			type:'post',
			success:function(){
				$("#loaderImg").hide();
			}
		});
		switch (tabId) {
			case "tab1":
				$("#pageContainer").load("page1.php");
				break;
			case "tab2":
				$("#pageContainer").load("page2.php");
				break;
			case "tab3":
				$("#pageContainer").load("page3.php");
				break;
			case "tab4":
				$("#pageContainer").load("page4.php");
				break;
			case "tab5":
				$("#pageContainer").load("page5.php");
				break;
		}
	});
	
	$(".tab").mouseover(function() {
		$(this).removeClass('withoutBorders');
		$(this).addClass('withBorders');
		$(".tab").not(this).removeClass('withBorders');
	});
	
	$(".tab").mouseout(function() {
		$(this).addClass('withoutBorders');
	});
	
	$('.tab:not(.active)').live('mouseover mouseout', function() {
		$(this).toggleClass('outlineBorders');
	});
});
