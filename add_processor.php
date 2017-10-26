
<?php
//START SESSION
session_start();

//LOAD DB LOGIN CREDS
require_once("dbinfo.php");

//NEW CONNECTION
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//CHECK CONNECTION
if(mysqli_connect_errno() != 0){

  	$_SESSION['system'] .= "<p>Connection failed, Please Check Your DB Credentials!</p>";

}

//SET VARIABLES
$newStudentNum = "";
$newFirstName = "";
$newLastName = "";
$key = "";
$_SESSION['system'] = "";
$pattern = "/^[A-B]0[0-9]{7}$/i";
$setString = "";
$id = $_POST['id'];
$validEntry = false;

//CHECK STUDENT NUMBER FOR VALIDITY
if( preg_match( $pattern , trim($_POST['id'])) != 1 && $_POST['id'] != " "){

	$validEntry = false;
	$_SESSION['system'] .= "<p>Not a valid student number. Must match A0####### format!</P>";
	
}else{

	$id = $_POST['id'];
	$checkStuNumQuery = "SELECT id FROM students WHERE id= '$id';";
	$checkResult = $db->query($checkStuNumQuery);
		
//DUPLICATE STUDENT NUMBER CHECKER
	if ($checkResult->num_rows > 0){

		$newStudentNum = $db->real_escape_string(ucfirst($_POST['id']));
		$_SESSION['system'] .= ucfirst($newStudentNum) . " is already assigned. Please use a different student number.<br>";
		//FREE-UP QUERY RESULTS
		$checkResult->free();
		header("location: add_student.php");
		die();

	}else{

		$validEntry = true;
		$newStudentNum = $db->real_escape_string(ucfirst($_POST['id']));
		$_SESSION['system'] .= " New Student #: " . ucfirst($newStudentNum) . "<br>";

	}//END DUPLICATE STUDENT NUMBER CHECKER

}//END STUDENT NUMBER CHECKER

//FIRSTNAME CHECKER
if (isset($_POST['firstname']) && $_POST['firstname'] != " " && $_POST['firstname'] != "" ){

	$validEntry = true;
	$newFirstName = $db->real_escape_string(ucfirst($_POST['firstname']));
	$_SESSION['system'] .= " New Firstname: " . ucfirst($newFirstName) . "<br>";

}else{

	$validEntry = false;
	$_SESSION['system'] .= " New Firstname: INVALID<br>";

}//END FIRSTNAME CHECKER

//LASTNAME CHECKER
if (isset($_POST['lastname']) && $_POST['lastname'] != " " && $_POST['lastname'] != "" ){

	$validEntry = true;
	$newLastName = $db->real_escape_string(ucfirst($_POST['lastname']));
	$_SESSION['system'] .=  " New Lastname: " . ucfirst($newLastName) . "<br>";

}else{

	$validEntry = false;
	$_SESSION['system'] .=  "New Lastname: INVALID<br>";

}//END LASTNAME CHECKER


//CHECK FOR ERRORS
if ($validEntry == false){

//DISPLAY MESSAGE IS THERE IS AN ERROR IN ONE OR MORE OF THE INPUT FIELDS
	$messageOrderShift = $_SESSION['system'];
	$_SESSION['system'] =  "Invalid Entry! Please review the information below and try again!<br>" . $messageOrderShift;
	header("Location: add_student.php");
	die();

}else{

//SEND QUERY TO ADD NEW STUDENT INTO TABLE
	$query = "INSERT INTO students (primary_key, id, firstname, lastname) VALUES (null, '$newStudentNum', '$newFirstName', '$newLastName');";

//VERIFY QUERY WAS ACCEPTED
	$results = $db->query($query);

	if($results == true){

//REVIEW ADDED INFORMATION
		$messageOrderShift = $_SESSION['system'];
		$_SESSION['system'] =  "The Record has been added to the database!<br>" . $messageOrderShift;
		
		header("Location: ass02_main.php");
		die();

	}else{

//GIVE ERROR MESSAGE
		$_SESSION['system'] .= "<p>The record could not be added as requested.</p>";
		header("Location: add_student.php");
		die();

	}

//FREE-UP QUERY RESULTS
	$results->free();

}

//CLOSE DB CONNECTION
$db->close();

?>