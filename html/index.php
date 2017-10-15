<?php session_start()?>
<?php require 'config.inc'; ?>

<?php
if(!isset($_SESSION['login_user'])){
    $button1 = "Login";
    $button2 = "Sign Up";
}
else{

    $button1 = "Add Sound";
    $button2 = "Sign Out";

    }
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="bootstrap-3.3.7/dist/css/bootstrap.min.css">
        <script src="bootstrap-3.3.7/dist/js/jquery-3.2.1.min.js"></script>
        <script src="bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
        <script src="bootstrap-validator/dist/validator.min.js"></script>
	<link href="style.css" type="text/css" rel="stylesheet">
       <script src="script.js" type="text/javascript"></script>
       <style>
       #navname { color: GREEN; font-family: 'Raleway',sans-serif; font-size: 32px; font-weight: 800; text-align: center; text-transform: uppercase;}
       #opening {
            font: 600 1.5em/1 'Raleway', sans-serif;
            color: rgba(0,0,0,.5);
            text-align: center;
            text-transform: uppercase;
            letter-spacing: .5em;
            position: absolute;
            top: 10%;
            width: 100%;
        }
        #page {
          font-weight: bold;
        }
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
                      <li class="active"><a href="index.php">Home</a></li>
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

        <!-- Register modal-->
        <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h2 class="modal-title" id="modalLabel">Sign Up!</h2>
                    </div>
                    <div class="modal-body">
                    <form role="form" data-toggle="validator" action="register.php" method="POST">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username" name="name" maxlength="15" 
					pattern="^[a-zA-Z]+(?:[a-zA-Z0-9.])*$"
					data-pattern-error="Must start with a letter and can contain only letters, numbers, and underscores."
					required>
                            <div class="help-block with-errors"></div>
 			    </div>
                            <div class="form-group">
                                <label for="firstname">First Name:</label>
                                <input type="text" class="form-control" id="firstname" name="first" maxlength="15"
					pattern="^[a-zA-Z]{1,}$" data-pattern-error="Can contain only letters"
					data-required-erro="Please fill out this field." required>
                            	<div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name:</label>
                                <input type="text" class="form-control" id="lastname" name="last" maxlength="15"
					pattern="^[a-zA-Z]{1,}$" data-pattern-error="Can contain only letters"
					required>
                            	<div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" maxlength="30" 
					data-error="Invalid email format (E.g. example@gmail.com)" required>
                            	<div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="pwd">Password:</label>
                                <input type="password" class="form-control" id="pwd" name="password" data-minlength="6" 
					data-error="Password must have a minimum of 6 characters" required>
				<div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="inputPwdConfirm">Confirm password:</label>
			    	<input type="password" class="form-control" id="inputPwdConfirm" data-match="#pwd" 
					data-match-error="Passwords do not match" required>
                            	<div class="help-block with-errors"></div>
				</div>
				<div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                            </div>
                        </form>
		    </div>
                </div>
            </div>
        </div>
        <!--Login Modal-->
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h2 class="modal-title" id="modalLabel">Login!</h2>
                    </div>
                    <div class="modal-body">
                    <form role="form" data-toggle="validator" action="login.php" method="POST">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username" name="name" maxlength="15" 
					pattern="^[a-zA-Z]+(?:[a-zA-Z0-9.])*$"
					data-pattern-error="Can contain only letters, numbers, and underscores." required>
                            <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="pwd">Password:</label>
                                <input type="password" class="form-control" id="pwd" name="password">
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" name="submit" value="Login">
                            </div>
                        </form>
		    </div>
                </div>
            </div>
        </div>

<table><thead><span id="opening" colspan="12">Public Soundboards!</th></thead></table>

<?php

  //Creating a directory for a given user
  if (isset($_SESSION['login_user'])) {
     $name =  $_SESSION['login_user'];
  }else{
     $name = "";
  }

  $sql = "SELECT user_id FROM users WHERE user_name = '". $name ."'" ;
  $result = mysqli_query($conn,$sql);
  $target_dir = "users/";

  while ($row = mysqli_fetch_assoc($result)){
    $dir = $target_dir . $row['user_id'];
    if(is_dir($dir) === false )
    {
      mkdir($dir);
    }
    $_SESSION['user_id'] = $row['user_id'];
  }



// PAGINATION

$start=0;

if(isset($_GET['records']))
{
  $limit=$_GET['records'];
}else{
  $limit=5;
}

if(isset($_GET['id']))
{
  $id=$_GET['id'];
  $start=($id-1)*$limit;
}else{
  $id=1;
}


if(isset($_GET['records']) && $_GET['records'] == 'all'){
    $sql = "SELECT board_id, board_name, display FROM board WHERE display=0";
  $query = mysqli_query($conn,$sql);

}else{
    $sql = "SELECT board_id, board_name, display FROM board WHERE display=0 limit $start, $limit";
  }
  $query = mysqli_query($conn,$sql);
}
?>
<table class="table table-striped">
  <thead class="thead-reverse">

    </th>
    <?php
  while($query2 = mysqli_fetch_assoc($query)){

    echo '<tbody><tr scope="row">';
      $name = $query2['board_name'];
      $id =  $query2['board_id'];
      $public = $query2['display'];

      echo "<div style='background-color:lavender;' class='form-horizontal''><form action='publicboard.php' method='POST'>";
      echo  "<input type='hidden' value='".$id."' name='board_id'>";
      echo  "<input type='hidden' value='".$name."' name='board_name'>";
      echo  "<button type='submit' value='submit' name='board_name'><span class='glyphicon glyphicon-play-circle'></span> $name</button>";
      echo "</form></div>";
      echo "<br>";
          echo '</tr></tbody>';

  }

?>
</table>
<?php
if(isset($_GET['records']))
{
  $limit="&records=".$_GET['records'];
}else{
  $limit="&records=5";
}
?>

<?php

echo "<form method='GET' action=''>";
echo "<select class='selectpicker' name='records'>";

  if(isset($_GET['records']) && $_GET['records'] == $number) {
    echo "<option value='5'>5 Records per page</option>
          <option value='10'>10 Records per page</option>
          <option value='20'>20 Records per page</option>
          <option value='all'>All Records per page</option>";
  }else{
    echo " <option value='5'>5 Records per page</option>";
    echo "<option value='10'>10 Records per page</option>";
    echo "<option value='20'>20 Records per page</option>";
    echo "<option value='all'>All Records per page</option>";
  }


echo "</select>";
echo "<input type='submit' value='Go'/>";
echo "</form>";
?>




<?php
  $rows=mysqli_num_rows(mysqli_query($conn, "SELECT board_id FROM board WHERE display=0"));
if(isset($_GET['records']) && $_GET['records'] == 'all'){

}else{

if(isset($_GET['records']))
{
  $records=$_GET['records'];
}else{
  $records="5";
}


if(isset($_GET['id'])){
  $page = $_GET['id'];
}else{
  $page = 1;
}

$total=ceil($rows/$records);


echo "<ul class=pagination pagination-sm>";
$is_first ="";
$is_last = "";
    if($page == 1){
      $is_first = 1;
    }
    if($page == $total){
      $is_last = 1;
    }


    $prev = max(1, $page - 1);

    $next = min($total , $page + 1);

    if(!$is_first) {
      echo '<li><a href="?id=1"> << First</a></li>';
      echo '<li><a href="?id='.$prev.'">Previous</a></li>';
    }


    for($i=1;$i<=$total;$i++)
    {
      if($i==$id) { echo "<li>Page ".$i."</li>"; }
      else { echo "<li><a href='?id=".$i."".$limit."'>Page ".$i."</a></li>"; }
    }

    if(!$is_last) {
      echo '<li><a href="?id='.$next.'">Next </a></li>';
      echo '<li><a href="?id='.$total.'">Last >></a></li>';
    }
echo "</ul>";
  echo '<span id="pagename">Page '.$page.' / '.$total.'</span>';
}

?>
</div>

</body>
</html>
