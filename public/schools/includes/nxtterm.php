<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
    $nxtdate = stripcslashes($_POST['nxtdate']);

    $nxtdate = mysqli_real_escape_string($conn,$_POST['nxtdate']);
	
	 $date = date("d/m/y");
	$time = date("h : i a");
    $duedt = explode("/",$date);
    $week = mktime(0,0,0,$duedt[1],$duedt[0],$duedt[2]);
    $years = (int)date('Y',$week);
	
	$sql="INSERT INTO tblnxtdate(nxtdate) VALUES('$nxtdate');";
	mysqli_query($conn,$sql);
	 header("Location: ../nxtterm.php?date=success");
            exit();
	}else {
    header("Location: ../nxtterm.php?date=notset");
            exit();
}