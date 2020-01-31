<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
    $sn = stripcslashes($_POST['subjectname']);
	$sc = stripcslashes($_POST['subjectcode']);
	$id = stripcslashes($_POST['sid']);
	$c = stripcslashes($_POST['compulsory']);

    $sn = mysqli_real_escape_string($conn,$_POST['subjectname']);
	$sc = mysqli_real_escape_string($conn,$_POST['subjectcode']);
	$id = mysqli_real_escape_string($conn,$_POST['sid']);
	$c = mysqli_real_escape_string($conn,$_POST['compulsory']);
	
	 $date = date("d/m/y");
        //Update
        $sql="update  tblsubjects set compulsory=$c,SubjectName='$sn',SubjectCode='$sc',UpdationDate='$date' where id=$id";
         mysqli_query($conn,$sql);
	header("Location: ../managesubjects.php?editsubject=success");
}else {
    header("Location: ../managesubjects.php?editsubject=notset");
        exit();
}