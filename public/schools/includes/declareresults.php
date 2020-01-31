<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
    $cid = stripcslashes($_POST['classids']);
	$t = stripcslashes($_POST['term']);

    $cid = mysqli_real_escape_string($conn,$_POST['classids']);
	$t = mysqli_real_escape_string($conn,$_POST['term']);
	
	$date = date("d/m/y");
	$time = date("h : i a");
    $duedt = explode("/",$date);
    $week = mktime(0,0,0,$duedt[1],$duedt[0],$duedt[2]);
    $years = (int)date('Y',$week);
		
	
			$sqlq="INSERT INTO tbldeclare(ClassId,Term,Status,Year) VALUES($cid,$t,1,$years)";
			mysqli_query($conn,$sqlq);
			 header("Location: ../declareresults.php?add=success");
                exit();
	
}else {
    header("Location: ../declareresults.php?add=notset");
        exit();
}