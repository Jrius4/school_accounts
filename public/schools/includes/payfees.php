<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
    $cid = stripcslashes($_POST['classid']);
    $sRoll = stripcslashes($_POST['studentid']);
	$t = stripcslashes($_POST['term']);
	$f = stripcslashes($_POST['fees']);

    $cid = mysqli_real_escape_string($conn,$_POST['classid']);
    $sRoll = mysqli_real_escape_string($conn,$_POST['studentid']);
	$t = mysqli_real_escape_string($conn,$_POST['term']);
	$f = mysqli_real_escape_string($conn,$_POST['fees']);
	
	 $date = date("d/m/y");
	$time = date("h : i a");
    $duedt = explode("/",$date);
    $week = mktime(0,0,0,$duedt[1],$duedt[0],$duedt[2]);
    $years = (int)date('Y',$week);
	
	//check if fees is a numeric number
       if(!is_numeric($f)){
		    header("Location: ../payfees.php?pay=notnumeric");
            exit();
	   }else{
		   
        $sql = "SELECT id,Fees FROM tblfees WHERE StudentRoll='$sRoll' AND ClassId=$cid AND Term=$t AND Year=$years";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
		   
        if ($count == 1) {
           $row=mysqli_fetch_assoc($result);
			$sum=$f+$row['Fees'];
			$sql1="UPDATE tblfees SET Fees=$sum WHERE StudentRoll='$sRoll' AND ClassId=$cid AND Term=$t AND Year=$years";
			mysqli_query($conn,$sql1);
			 header("Location: ../payfees.php?pay=updated");
            exit();
        }else {
			 $sql="INSERT INTO tblfees(StudentRoll,ClassId,Term,Fees,Year) VALUES('$sRoll',$cid,$t,$f,$years);";
			mysqli_query($conn,$sql);
			 header("Location: ../payfees.php?pay=success");
            exit();
    }
		   
	   }
}else {
    header("Location: ../payfees.php?pay=notset*");
            exit();
}