<?php session_start()?>
<?php
require_once 'config.inc';
?>
<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {

	$name = sanitize_input($_POST['name']);
	$password = md5($_POST['password']);
	$timestamp = date('Y-m-d G:i:s');
	$sql = "SELECT user_id, admin FROM users WHERE user_name = '". $name . "' and user_password = '" . $password ."'";
	$sql2 = "INSERT INTO success_login (user_name, time_stamp)
	VALUES ('".$name."', '".$timestamp."')";
	$result = mysqli_query($conn,$sql);

	$sql3 = "SELECT user_id FROM users WHERE user_name = '". $name . "' and user_password <> '" . $password ."'";
	$sql4 = "INSERT INTO FAIL_LOGIN (user_name, time_stamp)
	VALUES ('".$name."', '".$timestamp."')";
	$result2 = mysqli_query($conn,$sql3);
	$row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
	$count2 = mysqli_num_rows($result2);

	if($count2 == 1){
		mysqli_query($conn,$sql4);
	}

	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$priv = $row['admin'];


	$count = mysqli_num_rows($result);
	if($count == 1) {
         //session_register("myusername");
		$_SESSION['login_user'] = $name;
		$result = mysqli_query($conn,$sql2);

		if($priv){

			$_SESSION['admin'] = $priv;
			echo "<script>
				alert('You have successfully logged in as an admin!');
				window.location.href='admin.php'; </script>";
		}else {
			echo "<script>
				alert('You have successfully logged in!');
				window.location.href='index.php'; </script>";
		}
	}else {
		echo "<script>
    alert('Your username or password is invalid!');
    window.location.href='index.php'; </script>";
                }

}

function sanitize_input($input) {
	$input = htmlspecialchars($input);
	$input = trim($input);
	$input = stripslashes($input);
	return $input; 
}

?>
