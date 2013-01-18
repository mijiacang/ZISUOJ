	<?php
		require_once("admin-header.php");
		require_once("xx_excel_lead.php");

		//echo $_POST[leadExcel];
		//if($leadExcel == "true")
		if(isset($_POST[leadExcel]) && $_POST[leadExcel]=="true")
		{
			//获取上传的文件名
			$filename = $_FILES['inputExcel']['name'];
			echo "local_fileName: ".$filename."<br />";
		
			//上传到服务器上的临时文件名
			$tmp_name = $_FILES['inputExcel']['tmp_name'];
			echo "tmp_name: ".$tmp_name."<br />";
			$msg = uploadFile($filename,$tmp_name);
			echo $msg;
		}
	?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Import Users</title>
		<form name="form_lead" method="post" enctype="multipart/form-data" action='<?php echo $_SERVER['PHP_SELF']?>'>
		<input type="hidden" name="leadExcel" id="leadExcel" value="true">
		<p> <center><h2>Import Users</h2></center></p>
		<p>
		<input type="file" name="inputExcel" >
	    <input type="submit" value="lead_Excel" >
	    </p>
	    <p>
	    	Import format as below.
	    </p>
	    <p>
	    	<img src='../image/xx_in_excel_fromat.jpg'>
	    </p>
	    <p>or</p>
	    <p>
	    	<img src='../image/xx_in_excel_format2.jpg'>
	    </p>
		</form>
	<?php 
	require_once("../oj-footer.php");
	
	?>
	
