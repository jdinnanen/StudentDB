<!DOCTYPE html>
<html>
<head>
	<title>PHP MySQL</title>
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

//GRAB DB LOGIN CREDENTIALS
require_once("dbinfo.php");

//CREATE NEW DB CONNECTION OBJECT
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//DISPLAY ANY ERROR MESSAGES FROM PREVIOUS DELETE ATTEMPT
if(isset($_SESSION['system'])){

	echo $_SESSION['system'];

	unset($_SESSION['system']);
	
}

//CHECK CONNECTION
if(mysqli_connect_errno() != 0){
	$_SESSION['system'] .= "<p>Connection failed, please check your database connection information and try again.</p>";
	header("location: ass02_main.php");
	die();
}



//DISPLAY INFORMATION SELECTED FOR DELETION
$id = $_GET['id'];
$fname = $_GET['firstname'];
$lname = $_GET['lastname'];
echo "<p>Are You Sure You Want to Delete:</p>";
echo "<table>";
echo "<th>Student #</th><th>Firstname</th><th>Lastname</th>";
echo "<tr>";
echo "<td>" . $_GET['id'] . "</td>";
echo "<td>" . $_GET['firstname'] . "</td>";
echo "<td>" . $_GET['lastname'] . "</td>";
echo "</tr>";
echo "</table>";


//CONFIRM DELETION - SEND INFORMATION TO PROCESSOR
echo "<a href='delete_processor.php?id=".$id."&firstname=".$fname."&lastname=".$lname."'><button>Confirm Deletion!</button></a><br>";

//CLOSE DB CONNECTION
$db->close();

?>
<a href="ass02_main.php"><button>Home</button></a>
</body>
</html>