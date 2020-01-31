<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
    $fn = stripcslashes($_POST['fullname']);
	$un = stripcslashes($_POST['username']);
	$g = stripcslashes($_POST['gender']);
    $pass = stripcslashes($_POST['userpassword']);

    $fn = mysqli_real_escape_string($conn,$_POST['fullname']);
	$un = mysqli_real_escape_string($conn,$_POST['username']);
	$g = mysqli_real_escape_string($conn,$_POST['gender']);
    $pass = mysqli_real_escape_string($conn,$_POST['userpassword']);
	
	$date = date("d/m/y");
	
        //validate teacher existance
        $sql = "SELECT * FROM users WHERE userName='$un'";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);

        if ($count >= 1) {
                    header("Location: ../addteacher.php?add=userexists");
                    exit();
           
        }else {
			  $files = $_FILES['upload'];

        $fileName = $_FILES['upload']['name'];
        $fileTmp = $_FILES['upload']['tmp_name'];
        $fileError = $_FILES['upload']['error'];
			if($fileError === 0){
                $fileDestination = '../uploads/'.$fileName;
                move_uploaded_file($fileTmp,$fileDestination);
				$pass = password_hash($pass, PASSWORD_DEFAULT);
                $sql1 = "INSERT INTO tblteachers(FullName,UserName,UserPassword,Gender,img,CreationDate,UpdationDate) VALUES('$fn','$un','$pass','$g','$fileName','$date','Not yet updated')";
           mysqli_query($conn, $sql1);
				$sql2 = "INSERT INTO users(userName,userPassword,Acctype) VALUES('$un','$pass','Teacher')";
				mysqli_query($conn, $sql2);
           header("Location: ../addteacher.php?add=success");
           exit();
            }else{
                header("Location: ../addteacher.php?add=fileError");
                exit();
            }
    }
}else {
    header("Location: ../addteacher.php?add=notset");
        exit();
}