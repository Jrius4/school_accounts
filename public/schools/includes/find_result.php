<?php
if (isset($_POST['Rsubmit'])) {
	session_start();
    include_once 'db.php';
    
    $cid = stripcslashes($_POST['classid']);
	$rn = stripcslashes($_POST['rollno']);

    $cid = mysqli_real_escape_string($conn,$_POST['classid']);
	$rn = mysqli_real_escape_string($conn,$_POST['rollno']);
	
	$date = date("d/m/y");
	
	if($cid==5 || $cid==6){
		$sql="SELECT id FROM tblastudents WHERE RollNo='$rn'";
		$result=mysqli_query($conn,$sql);
		$count=mysqli_num_rows($result);
		if($count>0){
		$row=mysqli_fetch_assoc($result);
		$_SESSION['ARid']=$rn;
			$_SESSION['class']=$cid;
			header("Location: ../studentdashboard.php");
        exit();	
		}else{
			 header("Location: ../index.php?roll=notexist");
        exit();	
		}
		
	}else if($cid==4 || $cid==3){
		$sql1="SELECT id FROM tbls34 WHERE  RollNo='$rn';";
		$result1=mysqli_query($conn,$sql1);
		$count1=mysqli_num_rows($result1);
		if($count1>0){
		$row1=mysqli_fetch_assoc($result1);
		$_SESSION['S34id']=$rn;	
			$_SESSION['class']=$cid;
			header("Location: ../studentdashboard.php");
        exit();	
		}else{
			 header("Location: ../index.php?roll=notexist");
        exit();	
		}
}else if($cid==2 || $cid==1){
		$sql2="SELECT id FROM tbls21 WHERE  RollNo='$rn';";
		$result2=mysqli_query($conn,$sql2);
		$count2=mysqli_num_rows($result2);
		if($count2>0){
		$row2=mysqli_fetch_assoc($result2);
		$_SESSION['S21id']=$rn;	
			$_SESSION['class']=$cid;
			header("Location: ../studentdashboard.php");
        exit();
		}else{
			 header("Location: ../index.php?roll=notexist");
        exit();	
		}
	}
	
	}else {
    header("Location: ../index.php?roll=notset");
        exit();
}
		