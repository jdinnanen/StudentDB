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

//GRAB DB LOGING CREDNTIALS
require_once("dbinfo.php");

//CREATE A NEW DB CONNECTION OBJECT
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//CHECK CONNECTION
if(mysqli_connect_errno() != 0){
  echo "<p>Connection failed</p>";
}

//DISPLAY AND THEN CLEAR SYSTEM MESSAGES
if(isset($_SESSION['system'])){

	echo $_SESSION['system'];

	unset($_SESSION['system']);
}

//DISPLAY CURRENT STUDENT INFORMATION
echo "<table>";
echo "<th>Student #</th><th>Firstname</th><th>Lastname</th>";
echo "<tr>";
echo "<td>" . $_GET['id'] . "</td>";
echo "<td>" . $_GET['firstname'] . "</td>";
echo "<td>" . $_GET['lastname'] . "</td>";
echo "</tr>";
echo "</table>";

//SET SESSION INFORMATION FOR AUTO-REPOPULATION OF FIELDS
$_SESSION['id'] = $_GET['id'];
$_SESSION['firstname'] = $_GET['firstname'];
$_SESSION['lastname'] = $_GET['lastname'];
$_SESSION['key'] = $_GET['key'];
?>

<!-- FORM FOR UPDATING INFORMATION - AUTOPOPULATES WITH CURRENT INFORMATION -->
<h2>Enter the Information to Update:</h2>
<form method="GET" action='update_processor.php'>
		<label for="id">Student #:</label>
		<input type="text" name="id" id="id" value="<?php echo $_GET['id'] ?>" /><br />
		<label for="firsname">Firstname:</label>
		<input type="text" name="firstname" id="firstname" value="<?php echo $_GET['firstname'] ?>" /><br />
		<label for="lastname">Lastname:</label>
		<input type="lastname" name="lastname" id="lastname" value="<?php echo $_GET['lastname'] ?>"/><br />
		<input type="hidden" name="key" value="<?php echo $_GET['key'] ?>" />
		<input type="submit" /><br />
</form>
<a href="ass02_main.php"><button>Home</button></a>

</body>
</html>