<?php
require_once 'config.inc';
 ?>
<?php
session_start();

$name = $_SESSION['login_user'];
$timestamp = date('Y-m-d G:i:s');

$sql = "INSERT INTO SUCCESS_LOGOUT (user_name, time_stamp)
	VALUES ('".$name."', '".$timestamp."')";
mysqli_query($conn,$sql);
$_SESSION['login_user'] = null;
// remove all session variables
session_unset();

// destroy the session
session_destroy();

echo "<script>
	alert('You have successfully logged out!');
	window.location.href='index.php';
	</script>";
?>
