<?php session_start()?>
<?php require 'config.inc';
  if(!isset($_SESSION['login_user'])){
    header("Location: index.php"); /* Redirect browser */
    exit();
  }?>

<?php

  if(isset($_POST['add'])){
    $target_dir = "users/" . $_SESSION['user_id'] . "/soundboards/";
    if(is_dir($target_dir) === false )
    {
        mkdir($target_dir);
    }
    $target_dir = "users/" . $_SESSION['user_id'] . "/soundboards/" . str_replace(' ', '_', sanitize_input($_POST['board_name']));;
    if(is_dir($target_dir) === false )
    {
        mkdir($target_dir);


        $boardname = sanitize_input(str_replace(' ', '_', $_POST['board_name']));
        $display = $_POST['display'];
        $user = $_SESSION['user_id'];
    /*    $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, 'INSERT INTO board (board_name, display, user_id) VALUES=?')){
        mysqli_stmt_bind_param($stmt, "ssi", $boardname, $display, $user);
        mysqli_stmt_close($stmt);
      }*/
        $sql = "INSERT INTO board (board_name, display, user_id) VALUES ('".$boardname."', '".$display."', '".$user."')";

        	if (mysqli_query($conn, $sql)) {
            header("location: mysoundboards.php");
        	} else {
        		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        	}
      }
  } else if (isset($_POST['update'])) {

     $old_board_name = sanitize_input($_POST['old_board_name']);
     $display = $_POST['display'];
	   $board_id = $_POST['board_id'];
     $new_board_name = sanitize_input(str_replace(' ', '_', $_POST['new_board_name']));
     $target_dir = "users/" . $_SESSION['user_id'] . "/soundboards/" . sanitize_input($_POST['old_board_name']);
     $new_dir = "users/" . $_SESSION['user_id'] . "/soundboards/" . sanitize_input($_POST['new_board_name']);
     if(is_dir($target_dir) === true )
     {
        rename($target_dir, $new_dir);
     }
     else{
       echo "For some reason has already been deleted.";
     }

	   $sql = "UPDATE board SET board_name='" .$new_board_name."' , display='".$display."' WHERE board_id='".$board_id."'";
     $result = mysqli_query($conn, $sql);


}  else if(isset($_POST['delete'])) {
    $sql = "DELETE FROM board WHERE board_id='".$_POST['board_id']."'";
    $result = mysqli_query($conn, $sql);
      $target_dir = "users/" . $_SESSION['user_id'] . "/soundboards/" . str_replace(' ', '_', sanitize_input($_POST['board_name']) );
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

  function sanitize_input($input) {
	$input = htmlspecialchars($input);
	$input = trim($input);
	$input = stripslashes($input);
	return $input; 
}
		header('Location: mysoundboards.php');
?>
