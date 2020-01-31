<?php

if ( isset( $_POST[ 'adminsubmit' ] ) ) {
	session_start();
	include_once 'db.php';

	$names = stripcslashes( $_POST[ 'username' ] );
	$pass = stripcslashes( $_POST[ 'userpassword' ] );

	$names = mysqli_real_escape_string( $conn, $_POST[ 'username' ] );
	$pass = mysqli_real_escape_string( $conn, $_POST[ 'userpassword' ] );


	//validate username n pwd
	$sql = "SELECT * FROM users WHERE userName='$names'";
	$result = mysqli_query( $conn, $sql );
	$row = mysqli_fetch_array( $result, MYSQLI_ASSOC );
	$count = mysqli_num_rows( $result );
	$hashedpwd = $row[ 'userPassword' ];

	if ( $count == 1 ) {
		if ( $row[ 'Acctype' ] == "Dos" ) {
			if ( password_verify( $pass, $hashedpwd ) ) {
				$_SESSION[ 'adminname' ] = $row[ 'userName' ];
				header( "Location: ../admindashboard.php" );
				exit();
			} else {
				header( "Location: ../index.php?signin=invalidpassword" );
				exit();
			}
		} else {
			if ( $row[ 'Acctype' ] == "Teacher" ) {
				if ( password_verify( $pass, $hashedpwd ) ) {
					$_SESSION[ 'teachername' ] = $row[ 'userName' ];
					header( "Location: ../teacherdashboard.php" );
					exit();
				} else {
					header( "Location: ../index.php?signin=invalidpassword" );
					exit();
				}

			} else {
				if ( $row[ 'Acctype' ] == "HeadMaster" ) {
					if ( password_verify( $pass, $hashedpwd ) ) {
						$_SESSION[ 'hmname' ] = $row[ 'userName' ];
						header( "Location: ../hmdashboard.php" );
						exit();
					} else {
						header( "Location: ../index.php?signin=invalidpassword" );
						exit();
					}

				} else {
					if ( $row[ 'Acctype' ] == "secretary" ) {
					if ( password_verify( $pass, $hashedpwd ) ) {
						$_SESSION[ 'secname' ] = $row[ 'userName' ];
						header( "Location: ../addstudent.php" );
						exit();
					} else {
						header( "Location: ../index.php?signin=invalidpassword" );
						exit();
					}

				} else{
							if ( $row[ 'Acctype' ] == "Fees" ) {
					if ( password_verify( $pass, $hashedpwd ) ) {
						header( "Location: ../payfees.php" );
						exit();
					} else {
						header( "Location: ../index.php?signin=invalidpassword" );
						exit();
					}
							}
					}
				}
			}
		}
	} else {
		header( "Location: ../index.php?signin=invalidusername" );
		exit();
	}
} else {
	header( "Location: ../index.php?signin=notset" );
	exit();
}