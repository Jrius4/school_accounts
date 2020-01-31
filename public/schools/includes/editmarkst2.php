<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
    
    $nm = stripcslashes($_POST['Newmark']);
	$rid = stripcslashes($_POST['rid']);

    $nm = mysqli_real_escape_string($conn,$_POST['Newmark']);
	$rid = mysqli_real_escape_string($conn,$_POST['rid']);
	
	 $date = date("d/m/y");
        //Update
        $sql="update tblresultmt SET Marks=$nm WHERE id=$rid;";
         mysqli_query($conn,$sql);
	header("Location: ../managemarkst1.php?editmarks=success");
	exit();
}else {
    header("Location: ../managemarkst1.php?editmarks=notset");
        exit();
}