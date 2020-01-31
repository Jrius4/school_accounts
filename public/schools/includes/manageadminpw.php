<?php

if (isset($_POST['submit'])) {
session_start();
    include_once 'db.php';
    
    
    $pass = stripcslashes($_POST['newuserpassword']);
	
    $pass = mysqli_real_escape_string($conn,$_POST['newuserpassword']);
	$pass = password_hash($pass, PASSWORD_DEFAULT);
	$an = $_SESSION['adminname'];
//	$sql="INSERT INTO users(userName,userPassword,Acctype) VALUES('fees','$pass','Fees')";
//	mysqli_query($conn,$sql);
  $sql="UPDATE users SET userPassword='$pass' WHERE userName='$an'";
	mysqli_query($conn,$sql);
	header("Location: ../manageadminpw.php?adminpw=success");
        exit();
	
}else {
    header("Location: ../manageadminpw.php?adminpw=notset");
        exit();
}