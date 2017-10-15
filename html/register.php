<?php session_start()?>
<?php
require_once 'config.inc';
?>
<?php

if (isset($_POST["submit"])) {

	$name = sanitize_input($_POST['name']);
	$first = sanitize_input($_POST['first']);
	$last = sanitize_input($_POST['last']);
	$email = sanitize_input($_POST['email']);
	$password = md5($_POST['password']);

	// Perform queries
	$sql = "INSERT INTO users (user_name, first_name, last_name , email, user_password)
	VALUES ('".$name."', '".$first."', '".$last."', '".$email."', '".$password."')";

	if (mysqli_query($conn, $sql)) {
		$_SESSION['login_user'] = $name;
		echo "<script>
			alert('You havve successfully registered!');
			window.location.href='index.php'; </script>";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}
//header("Location: index.php");

function sanitize_input($input) {
	$input = htmlspecialchars($input);
	$input = trim($input);
	$input = stripslashes($input);
	return $input; 
}

?>
