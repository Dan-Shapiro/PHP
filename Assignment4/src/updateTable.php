<?php
	$db = new mysqli('localhost', 'root', '', 'dan');

	if ($db->connect_error): 
		die ("Could not connect to db " . $db->connect_error); 
	endif;
  
  $table = $_POST['table'];
  $ing = $_POST['val1'];
  $dir = $_POST['val2'];
  $rat = $_POST['val3'];
  $title = $_POST['title'];
  
  $result = $db->query("UPDATE " . $table . " SET ingredients = '$ing' WHERE title='$title'");
  $result = $db->query("UPDATE " . $table . " SET directions = '$dir' WHERE title='$title'");
  $result = $db->query("UPDATE " . $table . " SET rating = '$rat' WHERE title='$title'");
?>