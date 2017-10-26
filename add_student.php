<!DOCTYPE html>
<html>
<head>
	<title>Assignment 2 - Add A Student</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<style>
		tr:nth-child(odd)		{ background-color:#ccc; }
		tr:nth-child(even)		{ background-color:#fff; }
		</style>
</head>
<body>

<?php

//START SESSION
session_start();

//DB LOGIN CREDS
require_once("dbinfo.php");

//CHECKS FOR ANY SYSTEM MESSAGES COMING FROM OTHER PAGES
if(isset($_SESSION['system'])){

//SHOW USER SYSTEM MESSAGES
	echo $_SESSION['system'];

//CLEAR SYSTEM MESSAGES	
	unset($_SESSION['system']);
}

//NEW DATABASE CONNECTION
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//CHECK CONNECTION
if(mysqli_connect_errno() != 0){
  $_SESSION['system'] .= "<p>Connection failed, please check your database connection information and try again.</p>";
  header("location: ass02_main.php");
  die();
}

//CLOSE DB CONNECTION
$db->close();
?>

<!-- NEW STUDENT INFORMATION FORM -->
<h2>Enter the New Student Information:</h2>
<form method="POST" action='add_processor.php'>
		<label for="id">Student #:</label>
		<input type="text" name="id" id="id" placeholder="A00XXXXXX Format"/><br />
		<label for="firsname">Firstname:</label>
		<input type="text" name="firstname" id="firstname" /><br />
		<label for="lastname">Lastname:</label>
		<input type="lastname" name="lastname" id="lastname" /><br />
		<input type="submit" />
</form>

<!-- LINK BACK TO HOME -->
<a href="ass02_main.php"><button>Home</button></a>

</body>
</html>