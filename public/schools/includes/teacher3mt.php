<?php

if (isset($_POST['submit'])) {

    include_once 'db.php';
     $marks=array();
	$cid = stripcslashes($_POST['classids']);
	$s = stripcslashes($_POST['subjectid']);
    $sRoll = stripcslashes($_POST['studentid']);

    $cid = mysqli_real_escape_string($conn,$_POST['classids']);
	$s = mysqli_real_escape_string($conn,$_POST['subjectid']);
	$sRoll = mysqli_real_escape_string($conn,$_POST['studentid']);
	
	$marks=$_POST['marks'];
	
	 $date = date("d/m/y");
    $time = date("h : i a");
    $duedt = explode("/",$date);
    $week = mktime(0,0,0,$duedt[1],$duedt[0],$duedt[2]);
    $years = (int)date('Y',$week);
	
$sql2="SELECT id FROM tblresultmt WHERE SubjectId=$s AND StudentRoll='$sRoll' AND Year=$years  AND Term=3;";
	$result2=mysqli_query($conn,$sql2);
	$count=mysqli_num_rows($result2);
	if($count >0){
		header("Location: ../teachert1mt.php?marks=alreadyexist");
        exit();
	}else{
	$sql="SELECT PaperName,id FROM tblpapers WHERE SubjectId=$s AND Status=1";
	$result=mysqli_query($conn,$sql);
	$pid1=array();
	while($row=mysqli_fetch_assoc($result)){
		array_push($pid1,$row['id']);
	}
	for($i=0;$i<count($marks);$i++){
		 $mar=$marks[$i];
  $pid=$pid1[$i];
		
		$sql3="SELECT Percentage FROM tblsetpp WHERE PaperId=$pid AND SubjectId=$s;";
		$result3=mysqli_query($conn,$sql3);
		$row3=mysqli_fetch_assoc($result3);
		$per=$row3['Percentage'];
		$count1=mysqli_num_rows($result3);
		if($count1<=0){
			header("Location: ../teachert3mt.php?marks=ttpernotset");
        exit();
		}else{
		$final=($mar/100)*$per;
		$sql4="INSERT INTO tblfinalmt(SubjectId,PaperId,StudentRoll,Term,FinalMark,Year) VALUES($s,$pid,'$sRoll',3,$final,$years)";
		mysqli_query($conn,$sql4);
		
		$sql1="INSERT INTO  tblresultmt(StudentRoll,ClassId,SubjectId,PaperId,Marks,Term,Year) VALUES('$sRoll',$cid,$s,$pid,$mar,3,$years);";
		mysqli_query($conn,$sql1);
	}
	}
	header("Location: ../teachert3mt.php?marks=success");
        exit();
	}
}else{
	 header("Location: ../teachert3mt.php?notset");
        exit();
}