<!DOCTYPE html>
<html>
<head>
	<title>Assignment 2 - Home</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<style>
		tr:nth-child(odd)		{ background-color:#ccc; }
		tr:nth-child(even)		{ background-color:#fff; }
		</style>
</head>
<body>
<h1>Student Management System</h1>
   
<?php

//START SESSION
session_start();

//CHECKS FOR ANY SYSTEM MESSAGES COMING FROM OTHER PAGES
if(isset($_SESSION['system'])){

//SHOW USER SYSTEM MESSAGES
	echo $_SESSION['system'];

//CLEAR SYSTEM MESSAGES	
	unset($_SESSION['system']);
}

//DB INFO
require_once("./dbinfo.php");

//QUERY SORTER FUNCTIONALITY
$sortBy = "lastname";
if(isset($_GET["id"])){
	$sortBy = "id";
}else if(isset($_GET["firstname"])){
	$sortBy = "firstname";

}

//NEW CONNECTION
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//CHECK CONNECTION
if(mysqli_connect_errno() != 0){

//LET USER KNOW IF THERE IS AN ERROR CONNECTING TO THE DATABASE
  $_SESSION['system'] .= "<p>Connection failed, Please Check Your DB Credentials!</p>";

}

//ADD A NEW STUDENT TO THE DATABASE TABLE
echo "<br>";
echo "<a href='add_student.php?addStudent'><button>Add New Student</button></a>";

//QUERY DATABASE
$query = "SELECT * FROM students ORDER BY $sortBy;";

//PROCESS QUERY RESULTS
echo "<table>";
if ($result =  $db->query($query)) {

//GRAB FIELD NAMES FOR TABLE HEADERS
	$fieldObjectArray = $result->fetch_fields();
 
	foreach($fieldObjectArray as $oneField){

		if($oneField->name == "primary_key"){

//SKIP PRIMARY_KEY FIELD
			continue;

		}else{

//ASSIGN FIELD NAMES FOR TABLE HEADS
			echo "<th><a href='ass02_main.php?". $oneField->name ."'>" . ucfirst($oneField->name) . "</a></th>";
		}
	}

	echo "<th>Update</th><th>Delete</th>";

	//GRABS ASSOCIATED VALUES AND POPULATES TABLE ACCORDINGLY - PRIMARY_KEY IS HIDDEN(USED FOR INDEXING UPDATE INORMATION)
	echo "<tr>";
	while( $oneRecord = $result->fetch_assoc() ){
	  
		printf ("<td>%s</td> <td>%s</td> <td>%s</td>\n",$oneRecord["id"], $oneRecord["firstname"], $oneRecord["lastname"], $oneRecord["primary_key"]); 

		echo "<td><a href='update_student.php?id=". $oneRecord["id"] ."&firstname=". $oneRecord["firstname"] . "&lastname=". $oneRecord["lastname"] . "&key=" . $oneRecord["primary_key"] . "'><button>UPDATE</button></a></td>";

		echo "<td><a href='delete_student.php?id=". $oneRecord["id"] ."&firstname=". $oneRecord["firstname"] . "&lastname=". $oneRecord["lastname"] . "&key=" . $oneRecord["primary_key"] . "'><button>DELETE</button></a></td>";
		echo "</tr>";
		
	}

	echo "</table>";

	//RESULT CLEAR
	$result->free();

}

//DB CLOSE
$db->close();


?>	
	
</body>
</html>