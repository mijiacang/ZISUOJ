function getXmlHttpRequest() {
	var xmlHttp=null;
	if(window.XMLHttpRequest) {
		xmlHttp=new XMLHttpRequest();
	} else if(window.ActiveXObject("Micosoft.XMLHTTP")) {
	xmlHttp=new ActiveXObject("Micosoft.XMLHTTP");
	}
	return xmlHttp;
}
function sendRequest(url,call_back,data) {
	xmlHttp.onreadystatechange=call_back;
	xmlHttp.open('POST',url,true);
	xmlHttp.setRequestHeader("Content-type",
			"application/x-www-form-urlencoded");
	xmlHttp.setRequestHeader("Content-length",data);
	xmlHttp.setRequestHeader("Connection","close");
	xmlHttp.send(data);
}
function write_id(users) {
	//alert(users);
	//alert("xx");
	var oldList=document.getElementById("ulist").value;
	//alert("oldList="+oldList);
	users=oldList+users;
	var browser=navigator.appName; //浏览器名
	//alert(browser);
	if(browser=="Microsoft Internet Explorer") {//IE
		//alert("IE");
		document.getElementById("ulist").innerText=	users;
	} else if(browser="Netscape") {//firefox
		//alert("firefox");
		document.getElementById("ulist").innerHTML=	users;
	} else {
		alert("please use IE or FireFox browser!");
	}
}	
function callBack() {
	//alert("do_callback");
	//alert(xmlHttp.readyState);
	if(xmlHttp.readyState == 4 && xmlHttp.status==200) {
		//var response = xmlHttp.responseText;
		//alert(response);
		var xmlDOM = xmlHttp.responseXML;
		var root=xmlDOM.getElementsByTagName("u_id");
		//alert(root.length);
		//var user_id=new Array();
		var users="";
		for(var i=0;i<root.length;i++) {
			//user_id[i]=xmlDOM.getElementsByTagName("u_id")[i].childNodes[0].nodeValue;
			//alert(user_id[i]);
			users=users+xmlDOM.getElementsByTagName("u_id")[i].childNodes[0].nodeValue+"\n";
			//alert("users="+users);
		}
		//alert(users);
		write_id(users);
	}
}
var xmlHttp = getXmlHttpRequest();//new xmlHttpRequest
function AjaxReauest() {
	var s_grade=document.getElementById("s_grade").value;
	var s_class=document.getElementById("s_class").value;
	//alert(s_grade);
	//alert(s_class);
	var myDate = new Date();
	var mSeconds=myDate.getMilliseconds();
	//alert(myDate.getMilliseconds());
	sendRequest("xx_ajaxReturn.php?mSeconds="+mSeconds,callBack,"s_grade="+s_grade+
			"&s_class="+s_class);
	
}