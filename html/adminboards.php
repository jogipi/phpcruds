<?php session_start()?>
<?php require 'config.inc';
  if((!isset($_SESSION['login_user']) || (!isset($_SESSION['admin'])))){
    header("Location: index.php"); /* Redirect browser */
    exit();
  }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="bootstrap-3.3.7/dist/css/bootstrap.min.css">
        <script src="bootstrap-3.3.7/dist/js/jquery-3.2.1.min.js"></script>
        <script src="bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
        <link href="style.css" type="text/css" rel="stylesheet">
       <script src="script.js" type="text/javascript"></script>
       <style>
       #navname {color:green; font-weight:bold}
       </style>
        <title>Crikey Soundz!</title>
    </head>
      <!--Header-->
      <body data-spy="scroll" data-target=".navbar">
        <nav class="navbar navbar-default">
            <div class="container">
              <div class="col-md-12">
                  <div class="navbar-header">
                    <a id=navname class="navbar-brand">Crikey Soundz! <?php if(isset($_SESSION['login_user'])){
                     echo "Welcome, " . $_SESSION['login_user']. "!";
                    }
                     ?></a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                  </div>
                  <div class="collapse navbar-collapse navbar-right" id="myNavbar">
                    <ul class="nav navbar-nav">
                      <li class=""><a href="index.php">Home</a></li>
                                            <?php
                        if(!isset($_SESSION['login_user'])){
                          echo "<li><a href='' class='icon-bar' data-toggle='modal' data-target='#signupModal'>Sign Up</a></li>";
                          echo "<li><a href='' class='icon-bar' data-toggle='modal' data-target='#loginModal'>Login</a></li>";
                        } else if (isset($_SESSION['admin'])){
                          echo "<li class=''><a href='admin.php'>Admin</a></li>";
                          echo "<li class=''><a href='mysoundboards.php'>Soundboards</a></li>";
                          echo "<li><a href='logout.php' class='icon-bar'>Logout</a></li>";
                        }
                        else {
                          echo "<li class=''><a href='mysoundboards.php'>Soundboards</a></li>";
                          echo "<li><a href='logout.php' class='icon-bar'>Logout</a></li>";
                        }
                      ?>
                    </ul>
                  </div>
              </div>
            </div>
          </nav>

<div class="container">

<h1>Admin Page!</h1>
<?php
$sql = "SELECT * FROM board ORDER BY board_id";

$result = mysqli_query($conn, $sql);
?>

<table class='table'>
<tr><th>Board Id</th><th>Board Name</th><th>Public</th><th>User_id</th><th></th><th></th></tr>
<?php


    $result = mysqli_query($conn,$sql);

    while ($row = mysqli_fetch_assoc($result)){
      $board_id = $row['board_id'];
      $board_name = $row['board_name'];
      $display = $row["display"];
      $user_id = $row["user_id"];
      echo "<tr>";
      echo "<td>". $row['board_id']   . "</td>" ;
      echo "<td>". $row['board_name']    . "</td>" ;
      echo "<td>". $display. "</td>";
      echo "<td>". $user_id. "</td>";

      print "<td><div class='row'>";


      echo "<div class='col-sm-3' class='form-horizontal'><form action='adminboardaction.php' method='post'>";
      echo	"<input type='hidden' value='".$board_id."' name='board_id'>";
      echo	"<input type='hidden' value='".$board_name."' name='board_name'>";
      echo	"<input type='hidden' value='".$user_id."' name='user_id'>";
      echo	"<button type='submit' name='delete'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button>";
      echo "</form></div>";


      echo "<div class='col-sm-3' class='form-horizontal'><form action='editadminsoundboard.php' method='post'>";
      echo	"<input type='hidden' value='".$board_id."' name='board_id'>";
      echo	"<input type='hidden' value='".$board_name."' name='board_name'>";
      echo	"<input type='hidden' value='".$user_id."' name='user_id'>";
      echo	"<button type='submit' name='update'><span class='glyphicon glyphicon-edit'> Edit Name</button>";
      echo "</form></div>";

      echo "<div class='col-sm-3' class='form-horizontal'><form action='sounds.php' method='get'>";
      echo  "<input type='hidden' value='".$board_id."' name='board_id'>";
      echo  "<input type='hidden' value='".$board_name."' name='board_name'>";
      echo  "<input type='hidden' value='".$user_id."' name='user_id'>";
      echo  "<button type='submit' name='update'><span class='glyphicon glyphicon-edit'>Edit Sounds</button>";
      echo "</form></div>";

      print "</div></td></tr>\n";

    }




?>

</table>

<br><br>
<a href="adminusers.php">Users Admin</a><br>
<a href="log.php">Logs</a><br>
<a href="adminboards.php">Admin Boards</a><br>
<br>


</body>
</html>
