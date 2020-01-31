<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
    $cn = stripcslashes($_POST['classid']);
	$sn = stripcslashes($_POST['subjectid']);

    $cn = mysqli_real_escape_string($conn,$_POST['classid']);
	$sn = mysqli_real_escape_string($conn,$_POST['subjectid']);
	
	 $date = date("d/m/y");
        
        $sql = "SELECT * FROM tblsubjectcombination WHERE ClassId = $cn AND SubjectId = $sn";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        if ($count >= 1) {
             header("Location: ../Ocombination.php?combination=exists");
            exit();
        }else {
           $sql1="INSERT INTO  tblsubjectcombination(ClassId,SubjectId,Status,CreationDate,UpdationDate) 
		   VALUES('$cn','$sn',1,'$date','Not yet updated')";
			mysqli_query($conn,$sql1);
			header("Location: ../Ocombination.php?combination=success");
        exit();
    }
}else {
    header("Location: ../Ocombination.php?combination=notset");
        exit();
}