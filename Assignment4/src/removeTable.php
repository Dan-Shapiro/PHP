<?php
	$db = new mysqli('localhost', 'root', '', 'dan');

	if ($db->connect_error): 
		die ("Could not connect to db " . $db->connect_error); 
	endif;
  
  $table = $_POST['table'];
  $title = $_POST['titles'];

  $result = $db->query("DELETE FROM " . $table . " WHERE title='$title'");
  
  $ret = json_encode($table);
  echo $ret;
?>