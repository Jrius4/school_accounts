<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
    $sid = stripcslashes($_POST['subjectid']);
    $pn = stripcslashes($_POST['papername']);

    $sid = mysqli_real_escape_string($conn,$_POST['subjectid']);
    $pn = mysqli_real_escape_string($conn,$_POST['papername']);
	
	 $date = date("d/m/y");
        //validate username n pwd
        $sql = "SELECT id FROM tblpapers WHERE PaperName='$pn' AND SubjectId='$sid'";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);

        if ($count >= 1) {
             header("Location: ../papersubject.php?createpaper=exists");
            exit();
        }else {
				 $sql2="INSERT INTO  tblpapers(PaperName,SubjectId,Status,CreationDate,UpdationDate) 
		   VALUES('$pn',$sid,1,'$date','Not yet updated')";
			mysqli_query($conn,$sql2);
			header("Location: ../papersubject.php?createpaper=success");
        exit();
    }
}else {
    header("Location: ../papersubject.php?createpaper=notset");
        exit();
}