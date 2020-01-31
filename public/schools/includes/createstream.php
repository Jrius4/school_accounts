<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
    $cn = stripcslashes($_POST['classid']);
    $sn = stripcslashes($_POST['streamname']);

    $cn = mysqli_real_escape_string($conn,$_POST['classid']);
    $sn = mysqli_real_escape_string($conn,$_POST['streamname']);
	
	 $date = date("d/m/y");
        //validate username n pwd
        $sql = "SELECT id FROM tblstreams WHERE StreamName='$sn' AND ClassId='$cn'";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);

        if ($count >= 1) {
             header("Location: ../createstream.php?createstream=exists");
            exit();
        }else {
				 $sql2="INSERT INTO  tblstreams(StreamName,ClassId,CreationDate,UpdationDate) 
		   VALUES('$sn',$cn,'$date','Not yet updated')";
			mysqli_query($conn,$sql2);
			header("Location: ../createstream.php?createstream=success");
        exit();
    }
}else {
    header("Location: ../createstream.php?createstream=notset");
        exit();
}