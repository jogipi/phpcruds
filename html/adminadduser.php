<?php session_start()?>
<?php require 'config.inc';
  if((!isset($_SESSION['login_user']) || (!isset($_SESSION['admin'])))){
    header("Location: index.php"); /* Redirect browser */
    exit();
  }?>
<!DOCTYPE html>
<html>
<head>
<title>Edit User</title>
</head>
<body>

<?php
  $user_id = $_POST['user_id'];
  echo "<form action='adminuseraction.php' method='POST'>
      	 <label for='first_name'>First Name</label>
      	 <input type='text' name='first_name'>
      	  <label for='last_name'>Last Name</label>
      	<input type='text' name='last_name'>
      	<label for='user_name'>Username</label>
      	<input type='text' name='login' value='user_name'>
      	<label>Password</label>
      	<input type='text' name='password' value=''>
      	<input type='hidden' name='user_id' value='$user_id'>
      	<input type='submit' value='add'>
      	<input type='submit' value='Cancel' name='cancel'  class='btn btn-default'>
  </div>"
?>
  </form>
</body>
</html>
