<?php

include_once('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['submit'])) {
       
	$username = $_POST['username'];
    $pass = $_POST['password'];

    $sql="SELECT * FROM tab_users where username='$username' ";

	if($result=mysqli_query($con,$sql)) {
		$row=mysqli_fetch_assoc($result);
		
		if($row['password'] == $pass) {
			session_start();
			$_SESSION["uid"] = $row['id'];
			$_SESSION["username"] = $row['username'];
			$_SESSION["type"] = $row['type'];
			$_SESSION["email"] = $row['email'];

			header("Location: index.php");

		}
		else {
			header("Location: login.php");
		}
		
	} else {
		header("Location: login.php");
	}	



    } else {
        



    }
}

// if (isset($_POST['submit'])) {
    

// $sql="SELECT * FROM tab_users ";

// $result=mysqli_query($con,$sql
  
  
//   $row=mysqli_fetch_assoc($result);



// }

?>