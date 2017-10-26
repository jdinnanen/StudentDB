
<?php
//START SESSION
session_start();

//GRAB DB LOGIN CREDENTIALS
require_once("dbinfo.php");

//CREATE NEW DB CONNECTION
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//CHECK CONNECTION
if(mysqli_connect_errno() != 0){

  echo "<p>Connection failed</p>";

}

//SET VARIABLES
$delStudentNum = $_GET['id'];
$delFirstName = $_GET['firstname'];
$delLastName = $_GET['lastname'];


//QUERY DB FOR AN STUDENT NUMBER MATCH
$query = "DELETE FROM students WHERE id='". $delStudentNum ."';";
echo $query;

//IF QUERY GOOD - PROCESS DELETION
$results = $db->query($query);

if($results == true){

	$_SESSION['system'] .= "The Entry ". $delStudentNum . ", " . $delFirstName . ", " . $delLastName . ", has Been Removed From the Database!<br>";
	header("Location: ass02_main.php");
	die();

}else{

	$_SESSION['system'] .= "The Entry COULD NOT Be Removed From the Database!<br>";
	header("Location: delete_student.php?id=". $delStudentNum ."&firstname=". $delFirstName . "&lastname=". $delLastName);
	die();
	
 }

?>