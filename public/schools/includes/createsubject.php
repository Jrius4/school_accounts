<?php

if ( isset( $_POST[ 'submit' ] ) ) {

	include_once 'db.php';

	$l = stripcslashes( $_POST[ 'level' ] );
	$sn = stripcslashes( $_POST[ 'subjectname' ] );
	$sc = stripcslashes( $_POST[ 'subjectcode' ] );
	$c = stripcslashes( $_POST[ 'compulsory' ] );

	$l = mysqli_real_escape_string( $conn, $_POST[ 'level' ] );
	$sn = mysqli_real_escape_string( $conn, $_POST[ 'subjectname' ] );
	$sc = mysqli_real_escape_string( $conn, $_POST[ 'subjectcode' ] );
	$c = mysqli_real_escape_string( $conn, $_POST[ 'compulsory' ] );

	$date = date( "d/m/y" );
	//validate username n pwd
	$sql = "SELECT * FROM tblsubjects WHERE SubjectCode='$sc' AND Level='$l'";
	$result = mysqli_query( $conn, $sql );
	$count = mysqli_num_rows( $result );

	if ( $count >= 1 ) {
		header( "Location: ../createsubject.php?createsubject=exists" );
		exit();
	} else {
		if ( $l == "A-Level" ) {
			$sql1 = "INSERT INTO  tblsubjects(SubjectName,SubjectCode,Level,compulsory,CreationDate,UpdationDate) 
		   VALUES('$sn','$sc','$l',0,'$date','Not yet updated')";
			mysqli_query( $conn, $sql1 );
			header( "Location: ../createsubject.php?createsubject=success" );
			exit();
		} else {
			if ( $l == "O-Level" && $c == 1 ) {
				$sql1 = "INSERT INTO  tblsubjects(SubjectName,SubjectCode,Level,compulsory,CreationDate,UpdationDate) 
		   VALUES('$sn','$sc','$l',$c,'$date','Not yet updated')";
				mysqli_query( $conn, $sql1 );

				//INSERT comb for o-level
				$sql3="SELECT id FROM tblsubjects WHERE SubjectName='$sn' AND Level='$l';";
				$result3=mysqli_query($conn,$sql3);
				$row = mysqli_fetch_assoc($result3);
				$id=$row['id'];
				$sql4="INSERT INTO tblsubjectcombination(ClassId,SubjectId,Status,CreationDate,UpdationDate) VALUES(1,$id,1,'$date','Not yet updated');";
				mysqli_query( $conn, $sql4 );
				$sql5="INSERT INTO tblsubjectcombination(ClassId,SubjectId,Status,CreationDate,UpdationDate) VALUES(2,$id,1,'$date','Not yet updated');";
				mysqli_query( $conn, $sql5 );
				$sql6="INSERT INTO tblsubjectcombination(ClassId,SubjectId,Status,CreationDate,UpdationDate) VALUES(3,$id,1,'$date','Not yet updated');";
				mysqli_query( $conn, $sql6 );
				$sql7="INSERT INTO tblsubjectcombination(ClassId,SubjectId,Status,CreationDate,UpdationDate) VALUES(4,$id,1,'$date','Not yet updated');";
				mysqli_query( $conn, $sql7 );
				
				header( "Location: ../createsubject.php?createsubject=success" );
				exit();
			} else {
				if ( $l == "O-Level" && $c == 0 ) {
					$sql2 = "INSERT INTO  tblsubjects(SubjectName,SubjectCode,Level,compulsory,CreationDate,UpdationDate) 
		   VALUES('$sn','$sc','$l',$c,'$date','Not yet updated')";
					mysqli_query( $conn, $sql2 );
					
					//insert s1n2 comb only
					$sql8="SELECT id FROM tblsubjects WHERE SubjectName='$sn' AND Level='$l';";
				$result8=mysqli_query($conn,$sql8);
				$row8 = mysqli_fetch_assoc($result8);
				$id=$row8['id'];
				$sql9="INSERT INTO tblsubjectcombination(ClassId,SubjectId,Status,CreationDate,UpdationDate) VALUES(1,$id,1,'$date','Not yet updated');";
				mysqli_query( $conn, $sql9 );
				$sql10="INSERT INTO tblsubjectcombination(ClassId,SubjectId,Status,CreationDate,UpdationDate) VALUES(2,$id,1,'$date','Not yet updated');";
				mysqli_query( $conn, $sql10 );
					header( "Location: ../createsubject.php?createsubject=success" );
					exit();

				} else {}
			}

		}
	}
} else {
	header( "Location: ../createsubject.php?createsubject=notset" );
	exit();
}