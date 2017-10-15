<?php session_start()?>
<?php require 'config.inc';
  if((!isset($_SESSION['login_user']) || (!isset($_SESSION['admin'])))){
    header("Location: index.php"); /* Redirect browser */
    exit();
  }?>
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
$sql = "SELECT * FROM users WHERE admin = 0 ORDER BY user_id";
$result = mysqli_query($conn, $sql);
?>

<table class='table'>
<tr><th>First Name</th><th>Last Name</th><th>Username</th><th>Email</th><th></th></tr>

<?php



    $result = mysqli_query($conn,$sql);

    while ($row = mysqli_fetch_assoc($result)){
      echo "<tr>";
      echo "<td>". $row['first_name']   . "</td>" ;
      echo "<td>". $row['last_name']    . "</td>" ;
      echo "<td>". $row['user_name']        . "</td>" ;
      echo "<td>". $row['email']     . "</td>" ;
      $user_id = $row['user_id'];

      print "<td><div class='row'>";

      echo "<div class='col-sm-3' class='form-horizontal'><form action='adminuseraction.php' method='post'>";
      echo	"<input type='hidden' value='".$user_id."' name='user_id'>";
      echo	"<input type='hidden' value='delete' name='delete'>";
      echo	"<button type='submit' name='deleteuser' OnClick='return confirm(\"Are you sure you want to delete this board?\");'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button>";
      echo "</form></div>";


      echo "<div class='col-sm-3' class='form-horizontal'><form action='adminedituser.php' method='post'>";
      echo	"<input type='hidden' value='".$user_id."' name='user_id'>";
      echo  "<input type='hidden' value='".$row['first_name']."' name='first_name'>";
      echo  "<input type='hidden' value='".$row['last_name'] ."' name='last_name'>";
      echo  "<input type='hidden' value='".$row['user_name'] ."' name='user_name'>";
      echo  "<input type='hidden' value='".$row['email'] ."' name='email'>";
      echo	"<input type='hidden' value='edit' name='edit'>";
      echo	"<button type='submit' name='edituser'><span class='glyphicon glyphicon-edit'> Edit</button>";
      echo "</form></div>";

      print "</div></td></tr>\n";

    }

?>

</table>
<?php
// echo "
// <form action='adminadduser.php' method='POST'>
// 	<input type='submit' name='adduser' value='Add user'>
//   <input type='hidden' value='".$user_id."' name='user_id'>

// </form>"
echo "<button><a href='' class='button' data-toggle='modal' data-target='#signupModal'>Create User</a></button>";

?>
<br><br>
<a href="adminusers.php">Users Admin</a><br>
<a href="Logs.php">Logs</a><br>
<a href="adminboards.php">Admin Boards</a><br>
<br>



<!-- Register modal-->
        <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h2 class="modal-title" id="modalLabel">Create User</h2>
                    </div>
                    <div class="modal-body">
                        <form action="register.php" method="POST">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username" name="name">
                            </div>
                            <div class="form-group">
                                <label for="firstname">First Name:</label>
                                <input type="text" class="form-control" id="firstname" name="first">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name:</label>
                                <input type="text" class="form-control" id="lastname" name="last">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Password:</label>
                                <input type="password" class="form-control" id="pwd" name="password">
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary btn-green" value="Submit" name="submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</body>
</html>
