	<?php
		require_once("../include/db_info.inc.php");
		header("Content-Type:text/html;charset=utf-8");
	?>
	<?php 
	//导入Excel文件
	function uploadFile($file,$filetempname) //（文件名，临时文件名）
	{
		//echo "uploadFile<br />";
		//自己设置的上传文件存放路径
		//$filePath = './xx_upFile/';
		//echo "fffffffffff<br>";
		$filePath = '../upload/';
		$str = "";

		//下面的路径按照你PHPExcel的路径来修改
		//set_include_path('.'. PATH_SEPARATOR .    
		//     'D:\xampp\htdocs\XM1\PHPExcel' . PATH_SEPARATOR .    
		//       get_include_path()); 
		      
		require_once '../PHPEXCEL/Classes/PHPExcel.php';
		require_once '../PHPEXCEL/Classes/PHPExcel/IOFactory.php';
		require_once '../PHPEXCEL/Classes/PHPExcel/Reader/Excel5.php';
		
		$filename=explode(".",$file);//把上传的文件名以“.”号为准做一个数组。 
		$time=date("y-m-d-H-i-s");//取当前上传的时间 
		
		//echo "filename:".$filename."<br>";
		//echo "time:".$time."<br>"; 
		
		$filename[0]=$time;//取文件名t替换 
		$name=implode(".",$filename); //上传后的文件名 
		$uploadfile=$filePath.$name;//上传后的文件名地址 
		//echo "filename: ".$filename.",   newName: ".$name."<br />";
		//echo "uploadfile:".$uploadfile;
		
		//move_uploaded_file() 函数将上传的文件移动到新位置。若成功，则返回 true，否则返回 false。
		$result=move_uploaded_file($filetempname,$uploadfile);//假如上传到当前目录下
		if($result){ //如果上传文件成功，就执行导入excel操作
				//echo ">>>>>>><<<<<<<<<<<";
			   $objReader = PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format 
			   $objPHPExcel = $objReader->load($uploadfile); 
			   $sheet = $objPHPExcel->getSheet(0); 
			   $highestRow = $sheet->getHighestRow(); // 取得总行数 
			   $highestColumn = $sheet->getHighestColumn(); // 取得总列数
				//循环读取excel文件,读取一条,插入一条
			  // echo "<br>"."rows:".$highestRow."<br>";
			  // echo "<br>"."columns:".$highestColumn."<br>";
			   for($j=2;$j<=$highestRow;$j++) { 
				    for($k='A';$k<=$highestColumn;$k++)
				    { 
				     $str .= iconv("utf-8","utf-8",$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue()).'\\';//读取单元格
				    } 
				    //explode:函数把字符串分割为数组。
				    $strs = explode("\\",$str);
				   // echo "strs is :".$strs."<br>";
				    
				    
				    $sql = "INSERT INTO users (`grade`,`class`,`user_id`,`nick`,`sex`,`password`,`accesstime`,`reg_time`,`ip`) 
				    VALUES('".
				    $strs[0]."','".	//grade		    
				    $strs[1]."','".	//class
				    $strs[2]."','".	//user_id
				    $strs[3]."','".	//nick
				    $strs[4]."','".	//sex
				    md5($strs[5])."',
				    NOW(),
				    NOW(),
				    '".$_SERVER['REMOTE_ADDR']."')";  
				    //echo "sqlStr=".$sql."<br />";
				    mysql_query("set names 'utf8'");//这就是指定数据库字符集，一般放在连接数据库后面就系了 
				    if(!mysql_query($sql))
				    {	
				    	//output success lines and wrong lines
				    	echo "successed <span class='red'>".($j-2)."</span> lines<br />
				    								<span class='red'>Import wrong!!!</span>";
				    	unlink($uploadfile); //删除上传的excel文件
				    	return false;
				    }
				    $tmpStr="import_".($j-1)." :  ".$strs[0].",".$strs[1].",".$strs[2].",".$strs[3].",".$strs[4]." successed.<br />";
				    echo $tmpStr;
			    	$str = "";
			   } 
			   
			   unlink($uploadfile); //删除上传的excel文件
			   $msg = "all successed!<br />";
			   //output success
		 }else {//file does not exist
		 		$msg = "file does not exist!<br>Please first choose file.";
		 } 
		 //all successed
		return $msg;
	}
	?>