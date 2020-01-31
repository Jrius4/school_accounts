<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
    $cn = stripcslashes($_POST['classname']);
    $l = stripcslashes($_POST['level']);
	$ct = stripcslashes($_POST['classteacher']);

    $cn = mysqli_real_escape_string($conn,$_POST['classname']);
    $l = mysqli_real_escape_string($conn,$_POST['level']);
	$ct = mysqli_real_escape_string($conn,$_POST['classteacher']);
	
	 $date = date("d/m/y");
        //validate username n pwd
        $sql = "SELECT id FROM tblclasses WHERE ClassName='$cn'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        if ($count >= 1) {
             header("Location: ../createclass.php?createclass=exists");
            exit();
        }else {
			 $sql1 = "SELECT id FROM tblclasses WHERE ClassTeacherId=$ct";
        $result1 = mysqli_query($conn,$sql1);
        $count1 = mysqli_num_rows($result1);
			if($count1 >= 1){
			header("Location: ../createclass.php?createclass=classteacherexists");
        exit();
			}else{
				 $sql2="INSERT INTO  tblclasses(ClassName,Level,ClassTeacherId,CreationDate,UpdationDate) 
		   VALUES('$cn','$l',$ct,'$date','Not yet updated')";
			mysqli_query($conn,$sql2);
			header("Location: ../createclass.php?createclass=success");
        exit();
			}
    }
}else {
    header("Location: ../createclass.php?createclass=notset");
        exit();
}