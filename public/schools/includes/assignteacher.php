<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
    $tid = stripcslashes($_POST['teacherid']);
	$l = stripcslashes($_POST['level']);
	$sid = stripcslashes($_POST['subjectid']);

    $tid = mysqli_real_escape_string($conn,$_POST['teacherid']);
	$l = mysqli_real_escape_string($conn,$_POST['level']);
	$sid = mysqli_real_escape_string($conn,$_POST['subjectid']);
	
	 $date = date("d/m/y");
        //validate username n pwd
        $sql2 = "SELECT id FROM teachersubjectcombination WHERE TeacherId=$tid AND SubjectId=$sid AND Level='$l'";
        $result2 = mysqli_query($conn,$sql2);
        $count2 = mysqli_num_rows($result2);

        if ($count2 >= 1) {
             header("Location: ../assignteacher.php?assign=exists");
            exit();
        }else {
			$sql = "INSERT INTO teachersubjectcombination(TeacherId,SubjectId,Level,Status,CreationDate,UpdationDate) VALUES($tid,$sid,'$l',1,'$date','Not yet updated')"; 
			mysqli_query($conn,$sql);
			header("Location: ../assignteacher.php?assign=success");
            exit();
    }
}else {
    header("Location: ../assignteacher.php?assign=notset");
        exit();
}