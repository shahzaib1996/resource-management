<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_icon";

// Create connection
$con = mysqli_connect($servername,$username,$password,$database);

// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$mysqli = new mysqli($servername, $username, $password, $database);
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

?>