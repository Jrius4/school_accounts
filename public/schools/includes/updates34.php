<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
    $cn = stripcslashes($_POST['studentid']);
	$sid1 = stripcslashes($_POST['subjectid1']);
	$sid2 = stripcslashes($_POST['subjectid2']);
	$sid3 = stripcslashes($_POST['subjectid3']);

    $cn = mysqli_real_escape_string($conn,$_POST['studentid']);
	$sid1 = mysqli_real_escape_string($conn,$_POST['subjectid1']);
	$sid2 = mysqli_real_escape_string($conn,$_POST['subjectid2']);
	$sid3 = mysqli_real_escape_string($conn,$_POST['subjectid3']);
	
	 $date = date("d/m/y");
        //validate username n pwd
       $sql="UPDATE tbls34 SET Subject1Id=$sid1, Subject2Id=$sid2, Subject3Id=$sid3,Status=1 WHERE id=$cn;";
	mysqli_query($conn,$sql);
	 header("Location: ../Ocombination.php?combination=success");
        exit();
}else {
    header("Location: ../Ocombination.php?combination=notset");
        exit();
}