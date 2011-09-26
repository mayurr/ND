var zoomCount;
var size;
var relChangeX=new Array;
var relChangeY=new Array;
var baseX = 0;
var baseY = 0;
var arr=new Array;
var imageArr=new Array;
var arr1=new Array;
var imageArr1=new Array;
var userPositionsArray = new Array;
var paper = Raphael(document.getElementById('pageContainer'), 1000, 500);
var relPosX=0;
var relPosY=0;
var t;
var userDetailsArray1 = new Array;
var count=0;
window.onload = getPositions();
function getPositions() {
	if(flag == 0) {
		zoomCount = 10;
		size = 15;
	}
	else {
		zoomCount = 0;
		size = 3;
	}
	for(var i=0;i<userDetailsArray.length;i++){
		if(userDetailsArray[i].userId==sessionId){
			//relChangeX=500-parseInt(dataInfo.result[i]['x']);
			//relChangeY=250-parseInt(dataInfo.result[i]['y']);
			baseX = parseFloat(userDetailsArray[i].x);
			baseY = parseFloat(userDetailsArray[i].y);
			break;
		}
		/*userPositionsArray[i]=new Object;
		userPositionsArray[i].id = dataInfo.result[i]['id'];
		userPositionsArray[i].x=dataInfo.result[i]['x'];
		userPositionsArray[i].y=dataInfo.result[i]['y'];*/
	}
	for(var i=0;i<userDetailsArray.length;i++){
		relPosX=500 + ((parseFloat(userDetailsArray[i].x)-baseX)*10);
		relPosY=250 + ((parseFloat(userDetailsArray[i].y)-baseY)*10);
		if(flag == 0) {
			eval("var p"+i+"=paper.circle(relPosX,relPosY,size);");
			eval("var image"+i+"=paper.image('images/"+userDetailsArray[i].image+"',relPosX-25,relPosY-70,50,50);");
			arr[i]=eval("p"+i+";");
			imageArr[i] = eval("image"+i+";");
			arr[i].attr("fill","#fff");
			arr[i].node.id = userDetailsArray[i].firstName+" "+userDetailsArray[i].lastName;
			arr[i].node.onmouseover = function() {  
			    this.style.cursor = 'pointer';
			    showUser(this, this.id);
			};
			arr[i].node.onmouseout = function() {  
			    hideUser(this);
			};
			relChangeX[i] = (parseFloat(arr[i].attr("cx")) - parseFloat(userDetailsArray[i].x))/10;
			relChangeY[i] = (parseFloat(arr[i].attr("cy")) - parseFloat(userDetailsArray[i].y))/10;
		}
		else {
			if(userDetailsArray[i].userId == getterId || userDetailsArray[i].userId == giverId) {
				eval("var p"+i+"=paper.circle(userDetailsArray[i].oldX,userDetailsArray[i].oldY,size);");
				eval("var image"+i+"=paper.image('images/"+userDetailsArray[i].image+"',userDetailsArray[i].oldX-25,userDetailsArray[i].oldY-70,50,50);");
				arr1[count]=eval("p"+i+";");
				imageArr1[count]=eval("image"+i+";");
				userDetailsArray1[count] = new Object;
				userDetailsArray1[count].oldX = userDetailsArray[i].oldX;
				userDetailsArray1[count].oldY = userDetailsArray[i].oldY;
				userDetailsArray1[count].x = userDetailsArray[i].x;
				userDetailsArray1[count].y = userDetailsArray[i].y;
				count += 1;
			}
			else {
				eval("var p"+i+"=paper.circle(userDetailsArray[i].x,userDetailsArray[i].y,size);");
				eval("var image"+i+"=paper.image('images/"+userDetailsArray[i].image+"',userDetailsArray[i].x-25,userDetailsArray[i].y-70,50,50);");
			}
			arr[i]=eval("p"+i+";");
			imageArr[i] = eval("image"+i+";");
			arr[i].attr("fill","#fff");
			arr[i].node.id = userDetailsArray[i].firstName+" "+userDetailsArray[i].lastName;
			arr[i].node.onmouseover = function() {  
			    this.style.cursor = 'pointer';
			    showUser(this, this.id);
			};
			arr[i].node.onmouseout = function() {  
			    hideUser(this);
			};
			relChangeX[i] = (parseFloat(relPosX) - parseFloat(userDetailsArray[i].x))/10;
			relChangeY[i] = (parseFloat(relPosY) - parseFloat(userDetailsArray[i].y))/10;
		}
	}
	if(flag == 1) {
		arr1[0].animate({"cx":parseFloat(userDetailsArray1[0].x)},500);
		arr1[0].animate({"cy":parseFloat(userDetailsArray1[0].y)},500);
		arr1[1].animate({"cx":parseFloat(userDetailsArray1[1].x)},500);
		arr1[1].animate({"cy":parseFloat(userDetailsArray1[1].y)},500);
		imageArr1[0].animate({"x":parseFloat(userDetailsArray1[0].x-25)},500);
		imageArr1[0].animate({"y":parseFloat(userDetailsArray1[0].y-70)},500);
		imageArr1[1].animate({"x":parseFloat(userDetailsArray1[1].x-25)},500);
		imageArr1[1].animate({"y":parseFloat(userDetailsArray1[1].y-70)},500);
			
	}

}

function zoomIn(){
	zoomCount+=1;
	if(zoomCount>10){
		zoomCount=10;
	}
	else{
		for(var i=0;i<arr.length;i++){
			arr[i].attr({"cx":parseFloat(arr[i].attr("cx"))+ parseFloat(relChangeX[i])});
			arr[i].attr({"cy":parseFloat(arr[i].attr("cy"))+ parseFloat(relChangeY[i])});
			arr[i].attr({"r":arr[i].attr("r")+ 1.2});
			imageArr[i].attr({"x":parseFloat(imageArr[i].attr("x")) + parseFloat(relChangeX[i])});
			imageArr[i].attr({"y":parseFloat(imageArr[i].attr("y")) + parseFloat(relChangeY[i])});
		}
	}
}

function zoomOut(){
	zoomCount-=1;
	if(zoomCount<0){
		zoomCount=0;
	}
	else{
		for(var i=0;i<arr.length;i++){
			arr[i].attr({"cx":parseFloat(arr[i].attr("cx")) - parseFloat(relChangeX[i])});
			arr[i].attr({"cy":parseFloat(arr[i].attr("cy")) - parseFloat(relChangeY[i])});
			arr[i].attr({"r":arr[i].attr("r") - 1.2});
			imageArr[i].attr({"x":parseFloat(imageArr[i].attr("x")) - parseFloat(relChangeX[i])});
			imageArr[i].attr({"y":parseFloat(imageArr[i].attr("y")) - parseFloat(relChangeY[i])});
		}
	}
}

function showUser(userRaphaelObject, userId) {
	var bBox = userRaphaelObject.getBBox();
	t = paper.text(bBox.x + 13, bBox.y+35,userId);
}

function hideUser(userRaphaelObject) {
	t.remove();
}