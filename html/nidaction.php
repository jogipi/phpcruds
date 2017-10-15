<?php
session_start(); ?>
<?php require 'config.inc';
  if(!isset($_SESSION['login_user'])){
    header("Location: index.php"); /* Redirect browser */
    exit();
  }?>
<?php

$board_name = $_POST['board_name'];
$board_id = $_POST['board_id'];

echo "board name is" . $board_name;


if (isset($_POST['delete'])) {
  $sound_id = $_POST['sound_id'];
  $sql = "SELECT sound_path, img_path FROM sounds WHERE sound_id=' ".$sound_id. "'";
  $result = mysqli_query($conn, $sql);
 //echo $result;
  while($row = $result->fetch_assoc()){
    echo "delete files from".$row["img_path"]." ".$row["sound_path"]."'";

    unlink($row["img_path"]);
    unlink($row["sound_path"]);
  }

  $sql = "DELETE FROM sounds WHERE sound_id=' " .$sound_id. "'";
  $result = mysqli_query($conn, $sql);


}
else if (isset($_POST['update'])) {
  $board_name = $_POST['board_name'];
  $target_dir = "users/" . $_SESSION['user_id'] . "/soundboards/" .$board_name. "/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $target_file2 = $target_dir . basename($_FILES["audioToUpload"]["name"]);
  $sound_id = $_POST['sound_id'];
  $sql = "SELECT sound_path, img_path FROM sounds WHERE sound_id='".$sound_id."'";
  $result = mysqli_query($conn, $sql);

  while($row = $result->fetch_assoc()) {
    unlink($row["img_path"]);
    unlink($row["sound_path"]);
    echo "deleting files from".$row["img_path"]." ".$row["sound_path"]."'";
  }

  $sql = "UPDATE sounds SET img_path='".$target_file."' , sound_path='".$target_file2."' WHERE sound_id='".$sound_id."'";
  echo $sql;
  $result = mysqli_query($conn, $sql);

  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
  } else {
      echo "Sorry, there was an error uploading your file.";
  }
  if (move_uploaded_file($_FILES["audioToUpload"]["tmp_name"], $target_file2)) {
      echo "The file ". basename( $_FILES["audioToUpload"]["name"]). " has been uploaded.";
  }

 } else if (isset($_POST['add'])) {
  if(isset($_SESSION['login_user'])){

    echo "You are signed in " . $_SESSION['login_user'];
  }

  $target_dir = "users/" . $_SESSION['user_id'] . "/soundboards/" .$board_name. "/";
  echo "target dir is " . $target_dir;
  if(is_dir($target_dir) === false )
  {
      mkdir($target_dir);

  }
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $target_file2 = $target_dir . basename($_FILES["audioToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  $audioFileType = pathinfo($target_file2,PATHINFO_EXTENSION);
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
      } else {
          echo "File is not an image.";
          $uploadOk = 0;
      }
  }
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	echo $imageFileType;  
	
  	if ($imageFileType == "jpg" || $imageFileType == "jpeg" )
	{
	 	$output = shell_exec("jpegoptim -m75 ".$target_file); 
	 	echo $output; 
	}
	else if ($imageFileType == "png")
	{ 
		echo "IM PNG!!";
		$output = shell_exec("optipng " .$target_file);
		echo $output; 
	}

      } else {
          echo "Sorry, there was an error uploading your file.";
      }
      if (move_uploaded_file($_FILES["audioToUpload"]["tmp_name"], $target_file2)) {
          echo "The file ". basename( $_FILES["audioToUpload"]["name"]). " has been uploaded.";
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
      $sql = "INSERT INTO sounds (img_path, sound_path, board_id) VALUES ('".$target_file."' , '".$target_file2."','".$board_id."')";
      $result = mysqli_query($conn, $sql);
      echo "sql is" . $sql;
	echo "result is" . !$result;
  }
}

?>
<form action="sounds.php" method="post" enctype="multipart/form-data">
  <input type="submit" value="Go Back" name="action" class="btn btn-primary">
  <input type="hidden" name="board_name" value=<?php echo $board_name?>>
  <input type="hidden" name="board_id" value=<?php echo $board_id?>>
</form><br>
