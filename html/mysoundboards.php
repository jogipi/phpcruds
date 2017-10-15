<?php session_start()?>
<?php require 'config.inc';
  if(!isset($_SESSION['login_user'])){
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
        <script src="bootstrap-validator/dist/validator.min.js"></script>
	<link href="style.css" type="text/css" rel="stylesheet">
       <script src="script.js" type="text/javascript"></script>
       <style>
       #navname { color: GREEN; font-family: 'Raleway',sans-serif; font-size: 32px; font-weight: 800; text-align: center; text-transform: uppercase;}
       </style>
        <title>Crikey Soundz!</title>
    </head>
      <!--Header-->
      <body data-spy="scroll" data-target=".navbar">
        <nav class="navbar navbar-default">
            <div class="container">
              <div class="col-md-12">
                  <div class="navbar-header">
                    <a id=navname class="navbar-brand"> <?php if(isset($_SESSION['login_user'])){
                     echo "" . $_SESSION['login_user']. "'s soundboards";
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

<?php

echo "<table class='table table-bordered'>";

echo  "<tr>";
echo  "<th>";
echo "<div class='col-sm-10'><form action='mysoundboards.php' method='GET'>";
echo	"<button type='submit' value='order' name='board_name' id='byNameButton'>Board Name</button>";
echo "</form></div>";
echo "</th>";

// PAGINATION

if(isset($_GET['board_name'])){

	$orderBy = "board_name";

} else { $orderBy = "board_id"; }

  $user =  $_SESSION['user_id'];

$start=0;

if(isset($_GET['records']))
{
  $limit=$_GET['records'];
  if (!(($limit == 5) || ($limit == 10) || ($limit == 20) || ($limit =='All'))){$limit=5;}// {$limit = 5; echo $limit;}

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

if(isset($_GET['records']) && $_GET['records'] == 'All'){
  $sql = "SELECT board_id, board_name, display FROM board WHERE user_id=$user ORDER BY $orderBy";// ORDER BY $orderBy";
  $query = mysqli_query($conn,$sql);
}else{
  $sql = "SELECT board_id, board_name, display FROM board WHERE user_id=$user ORDER BY $orderBy limit $start,$limit";// ORDER BY $orderBy";
  $query = mysqli_query($conn,$sql);
}

?>
<table class="table table-striped">
  <thead class="thead-reverse">

  </th>
    <?php
  while($query2 = mysqli_fetch_assoc($query)){

    echo '<tbody><tr scope="row">';
      $name = sanitize_input($query2['board_name']);
      $id =  $query2['board_id'];
      $display = $query2['display'];

      print "<tr>";
      print "<td><div class='row'>";

      echo "<div class='col-sm-3' style='background-color:lavender;' class='form-horizontal''><form action='sounds.php' method='post'>";
      echo	"<input type='hidden' value='$id' name='board_id'>";
      echo	"<input type='hidden' value='$name' name='board_name'>";
      echo	"<button type='submit' value='' name=''><span class='glyphicon glyphicon-play-circle'></span> $name</button>";
      echo "</form></div>";

      echo "<div class='col-sm-3' style='background-color:lavenderblush;' class='form-horizontal'><form action='soundboardaction.php' method='post'>";
      echo	"<input type='hidden' value='$id' name='board_id'>";
      echo	"<input type='hidden' value='$name' name='board_name'>";
      echo	"<button type='submit' name='delete' OnClick='return confirm(\"Are you sure you want to delete this board?\");'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button>";
      echo "</form></div>";


      echo "<div class='col-sm-3' style='background-color:lavender;' class='form-horizontal'><form action='editsoundboard.php' method='post'>";
      echo	"<input type='hidden' value='$id' name='board_id'>";
      echo	"<input type='hidden' value='$name' name='board_name'>";
      echo	"<button type='submit' name='update'><span class='glyphicon glyphicon-edit'> Edit</button>";
      echo "</form></div>";

      echo "<div class='col-sm-3 style='background-color:lavenderblush;' class='form-horizontal''>";
      if ($display == 0) { echo "<button type='' value='' name='' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-eye-open'></span>"; }
      else {  echo "<button type='' value='' name='' class='btn btn-default btn-sm'><span <span class='glyphicon glyphicon-lock'></span>"; }
      echo "</button>";
      echo "</div>";

      print "</div></td></tr>\n";


  }

?>
</table>
<br />
<br />
<?php
if(isset($_GET['records']))
{
  $limit="&records=".$_GET['records'];
}else{

  $limit="&records=5";
}


echo "<form method='GET' action=''>";
echo "<select name='records'>";

 $numrows_arr = array("5", "10", "20", "All");
 foreach ($numrows_arr as $number) {
  if(isset($_POST['records']) && $_POST['records'] == $number) {
    echo "<option value='$number' selected='selected'>$number Records per page</option>";
  }else{
    echo "<option value='$number'>$number Records per page</option>";
  }
}
echo "</select>";
echo "<input type='submit' value='Go' />";
echo "</form>";


if(!(isset($_GET['records']) && $_GET['records'] == 'All')) {

$rows=mysqli_num_rows(mysqli_query($conn, "SELECT board_id FROM board WHERE user_id=" .$_SESSION['user_id']));
if(isset($_GET['records']))
{
  $records=$_GET['records'];
  if (!(($records == 5) || ($records == 10) || ($records == 20) || ($records =='All'))){$records=5;}
}else{
  $records="5";
}

$total=ceil($rows/$records);

if(isset($_GET['id'])){
  $page = $_GET['id'];
  if ($page > $total) {$page=$total;}
  if ($page < 1) {$page=1;}
}else{
  $page = 1;
}

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

  echo '<span id="pagename" align="center">Page '.$page.' / '.$total.'</span>';
}

function sanitize_input($input) {
	$input = htmlspecialchars($input);
	$input = trim($input);
	$input = stripslashes($input);
	return $input; 
}

?>

<div class="center"><button id="addBtn" data-toggle="modal" data-target="#squarespaceModal" class="btn btn-primary left-block">Add a Board</button></div>
   <!-- line modal -->
   <div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
     <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Cancel</span></button>
         <h3 class="modal-title" id="lineModalLabel">Enter Soundboard Name</h3>
       </div>
       <div class="modal-body">
               <!-- content goes here -->
                  <form role="form" data-toggle="validator" action="soundboardaction.php" method="post">
                       <div class="form-group">
                         <input type="text" class="form-control" name="board_name" maxlength="15"
				pattern="^[a-zA-Z]+(?:[a-zA-Z0-9.])*$"
				data-pattern-error="Must start with a letter and can contain only letters, numbers, and periods."
				required>
                            <div class="help-block with-errors"></div>
                       </div>
                       <div class="radio">
                         <label>
                           <input type="radio" name="display" value="0" checked>Public
                         </label>
                         <label>
                           <input type="radio" name="display" value="1">Private
                         </label>
                       </div>
                       <input type="submit" class="btn btn-default" value="Add Board" name="add"  value="Add a soundboard"></button>
                       <input type="hidden" name="board_id" value="">
                      <?php echo "<input type='hidden' value='".$_SESSION['user_id']."' name='user_id' id='sub'>";?>
                 </form>
       <div class="modal-footer">
         <div class="btn-group btn-group-justified" role="group" aria-label="group button">
           <div class="btn-group btn-delete hidden" role="group">
             <button type="button" id="actionBtn" class="btn btn-default btn-hover-red" data-dismiss="modal"  role="button">Cancel</button>
           </div>
         </div>
       </div>
     </div>
     </div>
   </div>

  </body>
  </html>
