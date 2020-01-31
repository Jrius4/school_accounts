<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
    $cn = stripcslashes($_POST['classid']);
    $sn = stripcslashes($_POST['streamname']);

    $cn = mysqli_real_escape_string($conn,$_POST['classid']);
    $sn = mysqli_real_escape_string($conn,$_POST['streamname']);
	
	 $date = date("d/m/y");
        //validate username n pwd
        $sql = "SELECT id FROM tblstreams WHERE StreamName='$sn' AND id=$cn";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
	
        if ($count >= 1) {
             header("Location: ../managestream.php?editstream=nochange");
            exit();
        }else {
				 $sql2="UPDATE tblstreams SET StreamName='$sn',UpdationDate='$date' WHERE id=$cn;";
			mysqli_query($conn,$sql2);
			header("Location: ../managestream.php?editstream=success");
        exit();
    }
}else {
    header("Location: ../managestream.php?editstream=notset");
        exit();
}