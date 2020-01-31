<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
    $fn = stripcslashes($_POST['fullname']);
	$un = stripcslashes($_POST['username']);
	$sid = stripcslashes($_POST['sid']);
	$g = stripcslashes($_POST['gender']);
    $pass = stripcslashes($_POST['userpassword']);

    $fn = mysqli_real_escape_string($conn,$_POST['fullname']);
	$un = mysqli_real_escape_string($conn,$_POST['username']);
	$sid = mysqli_real_escape_string($conn,$_POST['sid']);
	$g = mysqli_real_escape_string($conn,$_POST['gender']);
    $pass = mysqli_real_escape_string($conn,$_POST['userpassword']);
	
	$date = date("d/m/y");
	
       
	  $files = $_FILES['upload'];

        $fileName = $_FILES['upload']['name'];
        $fileTmp = $_FILES['upload']['tmp_name'];
        $fileError = $_FILES['upload']['error'];
			if($fileError === 0){
                $fileDestination = '../uploads/'.$fileName;
                move_uploaded_file($fileTmp,$fileDestination);
				$pass = password_hash($pass, PASSWORD_DEFAULT);
                $sql1 = "UPDATE tblteachers SET FullName='$fn',UserName='$un',UserPassword='$pass',Gender='$g',img='$fileName',UpdationDate='$date' WHERE id=$sid;";
           mysqli_query($conn, $sql1);
//				$sql2 = "UPDATE users SET userName='$un',userPassword='$pass'";
//				mysqli_query($conn, $sql2);
           header("Location: ../manageteacher.php?edit=success");
           exit();
            }else{
                header("Location: ../manageteacher.php?edit=fileError");
                exit();
            }
}else {
    header("Location: ../manageteacher.php?edit=notset");
        exit();
}