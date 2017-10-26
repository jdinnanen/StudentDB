
<?php
//START SESSION
session_start();

//SET VARIABLES
$newStudentNum = "";
$newFirstName = "";
$newLastName = "";
$key = "";
$_SESSION['system'] = "";
$pattern = "/^[A-B]0[0-9]{7}$/i";
$idValid = false;
$numRows = "";

//GET DB LOGIN CREDENTIALS
require_once("dbinfo.php");

//NEW DB CONNECTION OBJECT
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//CHECK CONNECTION
if(mysqli_connect_errno() != 0){

	$_SESSION['system'] .= "<p>Connection failed</p>";
	header("location: update_student.php?key=" . $_SESSION['key'] . "&id=" . $_SESSION['id'] . "&firstname=" . $_SESSION['firstname'] . "&lastname=" . $_SESSION['lastname']);
	die();

}

//CHECK PRIMARY_KEY AND STORE FOR UPDATE REFERENCE
if (isset($_GET['key']) && $_GET['key'] != "" && $_GET['key'] != " "){

	$key = $_GET['key'];
		

//CHECK FOR DUPLICATE ID
	$id = $_GET['id'];

	if($_SESSION['id']==$_GET['id']){

		$idValid = true;
		$newStudentNum = $db->real_escape_string(ucfirst($_GET['id']));

	}else{

		$checkStuNumQuery = "SELECT `id` FROM `students` WHERE `id`= '$id';";
		$checkResult = $db->query($checkStuNumQuery);
		$numRows = $checkResult->num_rows;		
		
		if($numRows>0){


		$_SESSION['system'] .= "<p>" . $_GET['id'] ." Is already assigned, try a different student number!</p>";
			
		$checkResult->close();
		}else{


			if( preg_match( $pattern , trim($_GET['id'])) > 0 && $_GET['id'] != " " && $_GET['id'] != ""){

				$idValid = true;
				$newStudentNum = $db->real_escape_string(ucfirst($_GET['id']));

			}else{	

				$_SESSION['system'] .= "<p>" . $_GET['id'] . ", is an invalid Student Number. Must be 9 characters and match the A0####### format.<br>";

			}	

			$checkResult->close();
		}
	}


//VALIDATE FIRSTNAME
	if (isset($_GET['firstname']) && $_GET['firstname'] != " " && $_GET['firstname'] != ""){

		$newFirstName = $db->real_escape_string(ucfirst($_GET['firstname']));
			
	}else{

		$_SESSION['system'] .= " Invalid Firstname.<br>";

	}
//VALIDATE LASTNAME
	if (isset($_GET['lastname']) && $_GET['lastname'] != " " && $_GET['lastname'] != ""){

		$newLastName = $db->real_escape_string(ucfirst($_GET['lastname']));
		
				
	}else{

		$_SESSION['system'] .= " Invalid Lastname.<br>";
//REDIRECT BACK TO UPDATE STUDENT PAGE WITH FIELDS POPULATED WITH OLD VALUES
		header("location: update_student.php?key=" . $_SESSION['key'] . "&id=" . $_SESSION['id'] . "&firstname=" . $_SESSION['firstname'] . "&lastname=" . $_SESSION['lastname']);
		die();
	}

}

//IF ALL REQUIREMENTS ARE MET QUERY TO UPDATE INFROMATION ON DATABASE
if ($idValid == true){
//SET MESSAGES IF VALID
	$_SESSION['system'] .= " Updated Student #: " . ucfirst($newStudentNum) . "<br>";
	$_SESSION['system'] .= " Updated Firstname: " . ucfirst($newFirstName) . "<br>";
	$_SESSION['system'] .=  " Updated Lastname: " . ucfirst($newLastName) . "<br>";
	$query = "UPDATE students SET id='". $newStudentNum ."',firstname='". $newFirstName ."',lastname='". $newLastName ."' WHERE primary_key = $key;";

	$results = $db->query($query);

	if($results == true){

		$messageOrderShift = $_SESSION['system'];
		$_SESSION['system'] =  "<p>The record has been updated with the new information.</p>" . $messageOrderShift;
		header("Location: ass02_main.php");
		die();

	}else{

		$messageOrderShift = $_SESSION['system'];
		$_SESSION['system'] =  "<p>The record could not be updated as requested.</p>" . $messageOrderShift;
		header("location: update_student.php?key=" . $_SESSION['key'] . "&id=" . $_SESSION['id'] . "&firstname=" . $_SESSION['firstname'] . "&lastname=" . $_SESSION['lastname']);
		die();

	}

}else{

	header("location: update_student.php?key=" . $_SESSION['key'] . "&id=" . $_SESSION['id'] . "&firstname=" . $_SESSION['firstname'] . "&lastname=" . $_SESSION['lastname']);
	die();	

}

?>