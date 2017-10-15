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


  if(isset($user_id)){
  echo "Editing Info For User " . $_POST['user_name'] . "<br>";
  echo "Current Info for User:" . "<br>";
  echo "First Name: " . $_POST['first_name'] . "<br>" ;
  echo "Last Name: " . $_POST['last_name'] . "<br>";
  echo "User Name: " . $_POST['user_name'] . "<br>";
  echo "Email Name: " . $_POST['email'] . "<br>";
  echo "<br>";echo "<br>";


  }else{

    echo "Click Cancel";
      echo "<br>";
            echo "<br>";
  }

  echo "<form action='adminuseraction.php' method='POST'>
      	 <label for='first_name'>First Name</label>
      	 <input type='text' name='first_name'>
      	  <label for='last_name'>Last Name</label>
      	<input type='text' name='last_name'>
      	<label for='user_name'>Username</label>
      	<input type='text' name='login'>


        <label>Email</label>
        <input type='text' name='email'>



      	<label>Password</label>
      	<input type='text' name='password' value=''>
      	<input type='hidden' name='user_id' value='$user_id'>
      	<input type='submit' name='update' value='Edit'>
      	<input type='submit' value='Cancel' name='cancel'  class='btn btn-default'>
  </div>"
?>
  </form>
</body>
</html>
