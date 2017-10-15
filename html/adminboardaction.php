<?php session_start()?>
<?php require 'config.inc';
  if((!isset($_SESSION['login_user']) || (!isset($_SESSION['admin'])))){
    header("Location: index.php"); /* Redirect browser */
    exit();
  }?>
<?php


    if(isset($_POST['delete'])){

      $sql2 = "DELETE FROM sounds WHERE board_id='".$_POST['board_id']."'";
      $result2 = mysqli_query($conn, $sql2);
      $sql = "DELETE FROM board WHERE board_id='".$_POST['board_id']."'";

      $result = mysqli_query($conn, $sql);

      $target_dir = "users/" . $_POST['user_id'] . "/soundboards/" . $_POST['board_name'];



      rrmdir($target_dir);

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


 //  if(isset($_POST['add'])){
 //    $target_dir = "users/" . $_POST['user_id'] . "/soundboards/";
 //    if(is_dir($target_dir) === false )
 //    {
 //        mkdir($target_dir);
 //    }
 //    $target_dir = "users/" . $_POST['user_id'] . "/soundboards/" . $_POST['board_name'];
 //    if(is_dir($target_dir) === false )
 //    {
 //        mkdir($target_dir);


 //        $boardname = $_POST['board_name'];
 //        $display = $_POST['display'];
 //        $user = $_POST['user_id'];

 //        $sql = "INSERT INTO board (board_name, display, user_id) VALUES ('".$boardname."', '".$display."', '".$user."')";

 //        	if (mysqli_query($conn, $sql)) {
 //            header("location: mysoundboards.php");
 //        	} else {
 //        		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
 //        	}
 //      }
 //  } else if (isset($_POST['update'])) {

 //     $old_board_name = $_POST['old_board_name'];
 //     $display = $_POST['display'];
	//    $board_id = $_POST['board_id'];
 //     $new_board_name = $_POST['new_board_name'];
 //     $target_dir = "users/" . $_POST['user_id'] . "/soundboards/" . $_POST['old_board_name'];
 //     $new_dir = "users/" . $_POST['user_id'] . "/soundboards/" . $_POST['new_board_name'];
 //     if(is_dir($target_dir) === true )
 //     {
 //        rename($target_dir, $new_dir);
 //     }
 //     else{
 //       echo "For some reason has already been deleted.";
 //     }

	//    $sql = "UPDATE board SET board_name='" .$new_board_name."' , display='".$display."' WHERE board_id='".$board_id."'";
 //     $result = mysqli_query($conn, $sql);


	// }  else if(isset($_POST['delete'])) {
 //    $sql = "DELETE FROM board WHERE board_id='".$_POST['board_id']."'";
 //    $result = mysqli_query($conn, $sql);
 //      $target_dir = "users/" . $_POST['user_id'] . "/soundboards/" . $_POST['board_name'];
 //      rrmdir($target_dir);
	// }

 //  if ($_SESSION['admin'] = $priv) {
 //    header("location: admin.php");
 //  }


  function rrmdir($path) {
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
      header('Location: adminboards.php');
	// 	header('Location: adminboards.php');

?>
