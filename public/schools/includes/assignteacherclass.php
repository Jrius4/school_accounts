<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
    $tid = stripcslashes($_POST['teacherid']);
	$cid = stripcslashes($_POST['classid']);

    $tid = mysqli_real_escape_string($conn,$_POST['teacherid']);
	$cid = mysqli_real_escape_string($conn,$_POST['classid']);
	
	 $date = date("d/m/y");
        //validate username n pwd
        $sql2 = "SELECT id FROM teacherclasscombination WHERE TeacherId=$tid AND ClassId=$sid";
        $result2 = mysqli_query($conn,$sql2);
        $count2 = mysqli_num_rows($result2);

        if ($count2 >= 1) {
             header("Location: ../assignteacherclass.php?assign=exists");
            exit();
        }else {
			$sql = "INSERT INTO teacherclasscombination(TeacherId,ClassId,Status,CreationDate,UpdationDate) VALUES($tid,$cid,1,'$date','Not yet updated')"; 
			mysqli_query($conn,$sql);
			header("Location: ../assignteacherclass.php?assign=success");
            exit();
    }
}else {
    header("Location: ../assignteacherclass.php?assign=notset");
        exit();
}