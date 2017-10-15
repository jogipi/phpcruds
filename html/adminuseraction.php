<?php
  session_start();
	require 'config.inc';
  if((!isset($_SESSION['login_user']) || (!isset($_SESSION['admin'])))){
	    header("Location: index.php"); /* Redirect browser */
	    exit();
	  }
?>
<?php

if (isset($_POST['user_id'])){
$user_id = $_POST['user_id'];
}

if (isset($_POST['delete'])) {

     $sql = "DELETE FROM users WHERE user_id='".$_POST['user_id']."'";

    $result = mysqli_query($conn, $sql);
      $target_dir = "users/" . $_POST['user_id'];
      rrmdir($target_dir);
}

  function rrmdir($path) {
 // Open the source directory to read in files
    $i = new DirectoryIterator($path);
    foreach($i as $f) {
        if($f->isFile()) {
            unlink($f->getRealPath());
        } else if(!$f->isDot() && $f->isDir()) {
            rrmdir($f->getRealPath());
        }
    }
    rmdir($path);
  }

if (isset($_POST['update'])) {

  $login = $_POST['login'];
  $first_name = $_POST['first_name'];
   $last_name = $_POST['last_name'];
   $email = $_POST['email'];
   $id = $_POST['user_id'];
$user_password = md5($_POST['password']);

   $sql = "UPDATE users SET first_name='" .$first_name."' ,last_name='".$last_name."' ,user_name='".$login."' ,user_password='".$user_password."' WHERE user_id='".$user_id."'";



   $result = mysqli_query($conn, $sql);
}


header('Location: adminusers.php');

?>
