<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
     $paperper=array();
	$s = stripcslashes($_POST['subjectid']);

	$s = mysqli_real_escape_string($conn,$_POST['subjectid']);
	
	$paperper=$_POST['paperper'];
	
	 $date = date("d/m/y");
    $time = date("h : i a");
    $duedt = explode("/",$date);
    $week = mktime(0,0,0,$duedt[1],$duedt[0],$duedt[2]);
    $years = (int)date('Y',$week);

	$sql="SELECT PaperName,id FROM tblpapers WHERE SubjectId=$s AND Status=1";
	$result=mysqli_query($conn,$sql);
	$pid1=array();
	while($row=mysqli_fetch_assoc($result)){
		array_push($pid1,$row['id']);
	}
		$psum=0;
	for($i=0;$i<count($paperper);$i++){
		 $per=$paperper[$i];
		$psum+=$per;
	}
		if($psum > 100){
				header("Location: ../managepaperpercentage.php?paper=greaterthan100");
        exit();
		}else if($psum < 100){
				header("Location: ../managepaperpercentage.php?paper=lessthan100");
        exit();
		}else if($psum == 100){
			for($i=0;$i<count($paperper);$i++){
				$pers=$paperper[$i];
  $pid=$pid1[$i];
				$sql1="UPDATE tblsetpp SET Percentage=$pers WHERE SubjectId=$s AND PaperId=$pid;";
		mysqli_query($conn,$sql1);
	}
		}
	header("Location: ../managepaperpercentage.php?paper=success");
        exit();
}else{
	 header("Location: ../managepaperpercentage.php?paper=notset");
        exit();
}