<?php

if (isset($_POST['s56submit'])) {

    include_once 'db.php';
    
    $fn = stripcslashes($_POST['fullname']);
	$rn = stripcslashes($_POST['rollno']);
	$cid = stripcslashes($_POST['classid']);
    $sid = stripcslashes($_POST['streamid']);
	$coid = stripcslashes($_POST['combinationid']);
	$g = stripcslashes($_POST['gender']);
	$f = stripcslashes($_POST['fees']);

    $fn = mysqli_real_escape_string($conn,$_POST['fullname']);
	$rn = mysqli_real_escape_string($conn,$_POST['rollno']);
	$cid = mysqli_real_escape_string($conn,$_POST['classid']);
    $sid = mysqli_real_escape_string($conn,$_POST['streamid']);
	$coid = mysqli_real_escape_string($conn,$_POST['combinationid']);
	$g = mysqli_real_escape_string($conn,$_POST['gender']);
	$f = mysqli_real_escape_string($conn,$_POST['fees']);
	
	$date = date("d/m/y");
	
	 $files = $_FILES['profilepic'];
        $fileName = $_FILES['profilepic']['name'];
        $fileTmp = $_FILES['profilepic']['tmp_name'];
        $fileError = $_FILES['profilepic']['error'];
	
	 $files1 = $_FILES['medicalform'];
        $fileName1 = $_FILES['medicalform']['name'];
        $fileTmp1 = $_FILES['medicalform']['tmp_name'];
        $fileError1 = $_FILES['medicalform']['error'];
	
	 $files2 = $_FILES['admissionform'];
        $fileName2 = $_FILES['admissionform']['name'];
        $fileTmp2 = $_FILES['admissionform']['tmp_name'];
        $fileError2 = $_FILES['admissionform']['error'];
	
			if($fileError === 0){
				if($fileError1 === 0){
		if($fileError2 === 0){
				
                $fileDestination = '../uploads/'.$fileName;
                move_uploaded_file($fileTmp,$fileDestination);
			$fileDestination1 = '../uploads/'.$fileName1;
                move_uploaded_file($fileTmp1,$fileDestination1);
			$fileDestination2 = '../uploads/'.$fileName2;
                move_uploaded_file($fileTmp2,$fileDestination2);
				$sql = "INSERT INTO tblstudents(RollNo,Level,Status,CreationDate,UpdationDate) VALUES('$rn','A-Level',1,'$date','Not yet updated')";
			mysqli_query($conn,$sql);
			$sqlq="INSERT INTO tblastudents(FullName,RollNo,ClassId,StreamId,CombinationId,Gender,fees,Status,profilepic,medicalform,admissionform,CreationDate,UpdationDate) VALUES('$fn','$rn',$cid,$sid,$coid,'$g',$f,1,'$fileName','$fileName1','$fileName2','$date','Not yet updated')";
			mysqli_query($conn,$sqlq);
			 header("Location: ../addstudent.php?add=success");
                exit();
            }else{
                header("Location: ../addstudent.php?add=fileError2");
                exit();
            }
				
            }else{
                header("Location: ../addstudent.php?add=fileError1");
                exit();
            }
            }else{
                header("Location: ../addstudent.php?add=fileError");
                exit();
            }
}else {
    header("Location: ../addstudent.php?add=notset");
        exit();
}