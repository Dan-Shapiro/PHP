<?php
	$db = new mysqli('localhost', 'root', '', 'dan');

	if ($db->connect_error): 
		die ("Could not connect to db " . $db->connect_error); 
	endif;
  
  $table = $_POST['table'];
  $ing = $_POST['ingre'];
  $dir = $_POST['direc'];
  $rat = $_POST['rate'];
  $title = $_POST['title'];
  
  $result = $db->query("INSERT INTO " . $table . "(title, ingredients, directions, rating) VALUES ('$title', '$ing', '$dir', '$rat')");
?>