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


<?php

echo  "<tr>";
echo "Your Soundbords!";
echo "<div class='col-sm-10'><form action='mysoundboards.php' method='post'>";
echo	"<button type='submit' value='board_name' name='board_name' >Board Name</button>";
echo "</form></div>";
echo "</tr></th></thead>";

  // PAGINATION
      $sql = "SELECT * from board";
      $result = mysqli_query($conn,$sql);
      $numrowstotal = mysqli_num_rows($result);
     $rowssofar = 0;
     // number of rows per page
     $rowperpage = 5;
     if(isset($_POST['num_rows'])){
         $rowperpage = $_POST['num_rows'];
     }

     if(isset($_POST['but_next'])){
         $rowssofar = $_POST['rowssofar'];

         $rowssofar +=  $rowperpage;
         if($rowssofar > $numrowstotal ){
             $rowssofar = $numrowstotal;
         }
     }
     // Previous Button
     if(isset($_POST['but_prev'])){
         $rowssofar = $_POST['rowssofar'];
         $rowssofar -= $rowperpage;
         if( $rowssofar < 0 ){
             $rowssofar = 0;
         }
     }


  if (isset($_POST['row_amount'])) {
    if ($_POST['row_amount'] == "All") {
      $rowperpage = $numrowstotal;
    }
  }
  $totalpages = ceil($numrowstotal/$rowperpage);
  if (isset($_POST['currentpage']) && is_numeric($_POST['currentpage'])) {

     $currentpage = (int) $_POST['currentpage'];
  } else {

     $currentpage = 1;
  }

  if ($currentpage >= $totalpages) {
     // set current page to last page
     $currentpage = $totalpages;
  } // end if
  // if current page is less than first page...
  if ($currentpage < 1) {
     // set current page to first page
     $currentpage = 0;
  } // end if
  //$leftoverpages = $totalpages - $currentpage;
 $user = $_SESSION['user_id'];

 if(isset($_POST['board_name'])){

 	$orderBy = $_POST['board_name'];

 }else{$orderBy = "board_id";}
       $user =  $_SESSION['user_id'];

  $sql = "SELECT board_id, board_name, display FROM board WHERE user_id=$user ORDER BY $orderBy LIMIT $rowssofar,$rowperpage";
  $result = mysqli_query($conn, $sql);
  $rowcounter = 1;

  while ($row = mysqli_fetch_assoc($result)){
    $name = $row['board_name'];
    $display = $row['display'];
    $id = $row['board_id'];
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

    echo "<div class='col-sm-3 style='background-color:lavender;' class='form-horizontal''>";
    if ($display == 0) { echo "<button type='' value='' name='' class='btn btn-default btn-sm'><span class='glyphicon glyphicon-eye-open'></span>"; }
    else {  echo "<button type='' value='' name='' class='btn btn-default btn-sm'><span <span class='glyphicon glyphicon-lock'></span>"; }
    echo "</button>";
    print "</div></td></tr>\n";



    $rowcounter++;
  }
  print "</table>";
  $currentpage -= 1;
  ?>

    <form method="post" action="" id="form">
      <div>
        <input type="hidden" name="rowssofar" value="<?php echo $rowssofar; ?>">
          <input type="hidden" name="leftoverrows" value="<?php echo $leftoverrows; ?>">
          <input type="hidden" name="currentpage" value="<?php echo $currentpage; ?>">
          <input type="submit" class="button" name="but_prev" value="&laquo;">
          <input type="submit" class="button" name="but_next" value="&raquo;" >

          <!-- Number of rows -->
          <div>
          <span>Rows Per Page:</span>&nbsp;
          <select id="num_rows" name="num_rows">
              <?php
              $numarr = array("5", "10", "20", "All");

              foreach($numarr as $rowsperpage){
                  if(($_POST['num_rows'] == $rowsperpage) && (isset($_POST['num_rows'])))
                  {
                      echo '<option value="'.$rowsperpage.'" selected="selected">'.$rowsperpage.'</option>';
                  }else{
                    echo '<option value="'.$rowsperpage.'">'.$rowsperpage.'</option>';
                  }
              }
              ?>
          </div>
      </div>
    </form>

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
                      <form action="soundboardaction.php" method="post">
                           <div class="form-group">
                             <input type="text" class="form-control" name="board_name">
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
