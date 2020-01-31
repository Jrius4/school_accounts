<?php

if (isset($_POST['submit'])) {
session_start();
    include_once 'db.php';
    
    $names = stripcslashes($_POST['newusername']);
    $pass = stripcslashes($_POST['newuserpassword']);
	$sid = stripcslashes($_POST['sid']);

    $names = mysqli_real_escape_string($conn,$_POST['newusername']);
    $pass = mysqli_real_escape_string($conn,$_POST['newuserpassword']);
	$sid = mysqli_real_escape_string($conn,$_POST['sid']);
	
	$pass = password_hash($pass, PASSWORD_DEFAULT);
	
  $sql="UPDATE users SET userName='$names',userPassword='$pass' WHERE id=$sid;";
	mysqli_query($conn,$sql);
	header("Location: ../manageaccountpw.php?editaccountpw=success");
        exit();
	
}else {
    header("Location: ../manageaccountpw.php?editaccountpw=notset");
        exit();
}