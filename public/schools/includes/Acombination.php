<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
    $cn = stripcslashes($_POST['combname']);
	$s1 = stripcslashes($_POST['subjectid1']);
	$s2 = stripcslashes($_POST['subjectid2']);
	$s3 = stripcslashes($_POST['subjectid3']);
	$ss = stripcslashes($_POST['subsidiary']);

    $cn = mysqli_real_escape_string($conn,$_POST['combname']);
	$s1 = mysqli_real_escape_string($conn,$_POST['subjectid1']);
	$s2 = mysqli_real_escape_string($conn,$_POST['subjectid2']);
	$s3 = mysqli_real_escape_string($conn,$_POST['subjectid3']);
	$ss = mysqli_real_escape_string($conn,$_POST['subsidiary']);
	
	 $date = date("d/m/y");
        //validate username n pwd
        $sql2 = "SELECT id FROM tblacombination WHERE CombName = '$cn'";
        $result2 = mysqli_query($conn,$sql2);
        $count2 = mysqli_num_rows($result2);

        if ($count2 >= 1) {
             header("Location: ../Acombination.php?combination=nameexists");
            exit();
        }else {
			  $sql = "SELECT id FROM tblacombination WHERE SubjectId1=$s1 AND SubjectId2=$s2 AND SubjectId3=$s3";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        if ($count >= 1) {
             header("Location: ../Acombination.php?combination=subjectsexist");
            exit();
        }else {     
			$sql1="INSERT INTO  tblacombination(CombName,SubjectId1,SubjectId2,SubjectId3,Subsidiary,GP,Status,CreationDate,UpdationDate)
		   VALUES('$cn',$s1,$s2,$s3,$ss,51,1,'$date','Not yet updated')";
			mysqli_query($conn,$sql1);
			header("Location: ../Acombination.php?combination=success");
        exit();
		}
    }
}else {
    header("Location: ../Acombination.php?combination=notset");
        exit();
}