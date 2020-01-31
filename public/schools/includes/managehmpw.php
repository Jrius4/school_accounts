<?php

if (isset($_POST['submit'])) {
session_start();
    include_once 'db.php';
    
    $names = stripcslashes($_POST['newusername']);
    $pass = stripcslashes($_POST['newuserpassword']);

    $names = mysqli_real_escape_string($conn,$_POST['newusername']);
    $pass = mysqli_real_escape_string($conn,$_POST['newuserpassword']);
	$pass = password_hash($pass, PASSWORD_DEFAULT);
//	$an = $_SESSION['hmname'];
	
	$sql="INSERT INTO users(userName,userPassword,Acctype) VALUES('$names','$pass','HeadMaster');";
	mysqli_query($conn,$sql);
//  $sql="UPDATE users SET userName='$names',userPassword='$pass' WHERE Acctype='$an'";
//	mysqli_query($conn,$sql);
	header("Location: ../manageadminpw.php?adminpw=success");
        exit();
	
}else {
    header("Location: ../manageadminpw.php?adminpw=notset");
        exit();
}