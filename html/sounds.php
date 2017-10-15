<?php session_start()?>
<?php require 'config.inc';
  if(!isset($_SESSION['login_user'])){
    header("Location: index.php"); /* Redirect browser */
    exit();
  }?>

<?php
if(isset($_POST['submit'])){
    echo $_POST['board_name'] . $_POST['board_id'];
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
        #navname { color: GREEN; font-family: 'Raleway',sans-serif; font-size: 32px; font-weight: 800; text-align: center; text-transform: uppercase;}


	.img-thumbnail{

	max-width: 300px;
	height: 300px;
	}

        .item {
            width: 100px;
            min-height: 120px;
            max-height: auto;
            float: left;
            margin: 3px;
            padding: 3px;
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

<table>
<?php

$board_name = $_POST['board_name'];
$board_id = $_POST['board_id'];

      $sql = "SELECT * FROM sounds WHERE board_id=" .$board_id. " ORDER BY sound_id";
      echo $sql;
      $result = mysqli_query($conn, $sql);
      $array = [];
      $i = 1;
      while($row = mysqli_fetch_assoc($result)){
        $image = $row['img_path'];
        $audio = $row['sound_path'];
        $sound_id = $row['sound_id'];
        $board_id = $row['board_id'];

        if (($i % 5) == 0) { echo "<tr>";}
        echo "<td>";
        echo "<div class='item'><img class='img-thumbnail' src=' ".$image." ' onclick='togglePlay()'>
         <div><audio controls id='hilo' . ' > <source src='".$audio."'type='audio/mpeg'></audio></div>";
       echo "<form action='nidaction.php' method='post'>
       <input type='hidden' name='board_id' value='".$board_id."'>
       <input type='hidden' name='board_name' value='".$board_name."'>
          <input type='submit' value='Delete' OnClick='return confirm(\"Are you sure you want to delete this sound?\");' name='delete'>
           <input type='hidden' name='sound_id' value='".$sound_id."'>
        </form><br>";
        echo "<form action='editsounds.php' method='post'>
           <input type='submit' value='Update' name='update'>
            <input type='hidden' name='sound_id' value='".$sound_id."'>
            <input type='hidden' name='board_name' value='".$board_name."'>
            <input type='hidden' name='board_id' value='".$board_id."'>
         </form><br></div>";
    print "<td>";
     echo "</tr>";

      $i++;

    }
 ?>
 </table>


   <form id="uploadimage" action="nidaction.php" method="post" enctype="multipart/form-data">
     Select image to upload:
     <input type="file" name="fileToUpload" id="fileToUpload"><br>
     Select audio to upload:
     <input type="file" name="audioToUpload" id="audioToUpload">
     <button type="submit" name="add" id="check">Add to board</button>
      <input type="hidden" name="board_id" value=<?php echo $board_id?>>
     <input type="hidden" name="board_name" value=<?php echo $board_name?>>
   </form><br>




</body>

</html>
