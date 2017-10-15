<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>
<?php
  $board_id = $_POST['board_id'];
  $oldName = $_POST['board_name'];

  echo "<form action='soundboardaction.php' method='post'>
		Input New Soundboard info:
		<input type='text' name='new_board_name'>
    <input type='radio' name='display' value='0' checked> Public
    <input type='radio' name='display' value='1'> Private
    <input type='hidden' name='board_id' value='".$board_id."'>
    <input type='hidden' name='old_board_name' value ='".$oldName."'>
		<input type='submit' value='Update' name='update'>
	</form><br><br>";
?>
</body>
</html>


