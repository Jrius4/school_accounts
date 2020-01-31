<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
	$id = stripcslashes($_POST['sid']);
	$ct = stripcslashes($_POST['classteacherid']);

	$id = mysqli_real_escape_string($conn,$_POST['sid']);
	$ct = mysqli_real_escape_string($conn,$_POST['classteacherid']);
	
	 $date = date("d/m/y");
	 $sql1 = "SELECT id FROM tblclasses WHERE ClassTeacherId=$ct";
        $result1 = mysqli_query($conn,$sql1);
        $count1 = mysqli_num_rows($result1);
			if($count1 >= 1){
				 header("Location: ../manageclasses.php?editclass=classteacheralready");
        exit();	
			}else{
			 $sql="UPDATE tblclasses SET ClassTeacherId=$ct,UpdationDate='$date' WHERE id=$id;";
	mysqli_query($conn,$sql);
	 header("Location: ../manageclasses.php?editclass=success");
        exit();	
			}
}else {
    header("Location: ../editclass.php?editclass=notset");
        exit();
}