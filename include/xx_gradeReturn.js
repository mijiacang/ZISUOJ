function g_callBack() {
	//alert("do_callback");
	if(xmlHttp.readyState == 4 && xmlHttp.status==200) {
		//var response = xmlHttp.responseText;
		//alert(response);
		var xmlDOM = xmlHttp.responseXML;
		var root=xmlDOM.getElementsByTagName("u_class");
		//alert(root.length);
		//get select
		var objSelect = document.getElementById("s_class");
		objSelect.options.length = 0;
		//new select
		var varItem = new Option("All","-1");
        objSelect.options.add(varItem);
        var classValue="";
        var classText="";
        
		for(var i=0;i<root.length;i++) {
			if(xmlDOM.getElementsByTagName("u_class")[i].childNodes[0]) {
				classValue=xmlDOM.getElementsByTagName("u_class")[i].childNodes[0].nodeValue;
				classText=classValue;
				//alert(classValue+"xx");
				varItem = new Option(classText,classValue);
			    objSelect.options.add(varItem);
			}
		}
	}
}
function selectGrade(s_grade) {
	//alert(s_grade);
	var myDate = new Date();
	var mSeconds=myDate.getMilliseconds();
	//alert(myDate.getMilliseconds());
	sendRequest("xx_gradeReturn.php?mSeconds="+mSeconds,g_callBack,"s_grade="+s_grade);
}