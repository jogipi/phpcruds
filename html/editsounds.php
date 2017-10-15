<?php session_start()?>
<?php require 'config.inc';
  if(!isset($_SESSION['login_user'])){
    header("Location: index.php"); /* Redirect browser */
    exit();
  }?>
  
<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>
<?php
  $board_id = $_POST['board_id'];
  $sound_id = $_POST['sound_id'];
  $board_name= $_POST['board_name'];


  echo "<form id='uploadimage' action='nidaction.php' method='post' enctype='multipart/form-data'>
    Select image to upload:
    <input type='file' name='fileToUpload' id='fileToUpload'><br>
    Select audio to upload:
    <input type='file' name='audioToUpload' id='audioToUpload'>
    <button type='submit' name='update'>Update</button>
    <input type='hidden' name='board_name' value='".$board_name."'>
    <input type='hidden' name='sound_id' value='".$sound_id."'>
     <input type='hidden' name='board_id' value='".$board_id."'>
  </form><br>";
?>
</body>
</html>
