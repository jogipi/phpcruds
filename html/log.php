<?php session_start()?>
<?php require 'config.inc';
  if(!isset($_SESSION['login_user'])){
    header("Location: index.php"); /* Redirect browser */
    exit();
  }?>

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



</table>

<br><br>
<a href="adminusers.php">Users Admin</a><br>
<a href="log.php">Logs</a><br>
<a href="adminboards.php">Admin Boards</a><br>
<br>
<?php

echo "Successful logins total for all users " ;

$rows=mysqli_num_rows(@mysqli_query($conn, "SELECT * FROM SUCCESS_LOGIN"));

echo $rows . "<br>";

echo "Unsuccessful logins total for all users " ;

$rows=mysqli_num_rows(@mysqli_query($conn, "SELECT * FROM FAIL_LOGIN"));

echo $rows . "<br>";


echo "Successful logout total for all users " ;

$rows=mysqli_num_rows(@mysqli_query($conn, "SELECT * FROM SUCCESS_LOGOUT"));

echo $rows . "<br>";


?>

</body>
</html>
