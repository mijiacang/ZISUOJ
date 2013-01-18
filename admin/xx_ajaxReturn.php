<?php
	header('Content-Type: text/xml');
	header("Cache-Control: no-cache, must-revalidate");
	require_once("../include/db_info.inc.php");
	if($_POST['s_grade'] && $_POST['s_class']) {
		$grade=$_POST['s_grade'];
		$class=$_POST['s_class'];
		$strSql="select `user_id` from `users`";
		if($grade!=-1) {
			$strSql=$strSql." where `grade`="."'".$grade."'";
			if($class!=-1) {
				$strSql.= " and `class`="."'".$class."'";
			}
		} else if($class!=-1) {
			$strSql.= " where `class`="."'".$class."'";
		}
		//echo $strSql;
		//exit;
		$userList=mysql_query($strSql);
		if($userList) {
			$xmlStr = "<?xml version='1.0' encoding='UTF-8'?>"; 
			$xmlStr .= "<root>";
			while($row = mysql_fetch_array($userList)) {
				 $xmlStr .= "<u_id>".iconv("utf-8","utf-8",$row['user_id'])."</u_id>";
				 //$xmlStr .= "<u_id>".$row['user_id']."</u_id>";
			}
			$xmlStr .="</root>";
			echo $xmlStr;
		}
	} else {
		echo "wrong!";
	}
	?>