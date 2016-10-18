<?php
	$db = new mysqli('localhost', 'root', '', 'dan');

	if ($db->connect_error): 
		die ("Could not connect to db " . $db->connect_error); 
	endif;
	
	$result = $db->query("SELECT * FROM appetizer");
	$numrows = $result->num_rows;
	$entArray = Array();
	for($i = 0; $i < $numrows; $i++)
	{
		$row = $result->fetch_array();
		$title = $row[1];
		$ingr = $row[2];
		$dir = $row[3];
    $rate = $row[4];
		$contents = Array($title, $ingr, $dir, $rate);
		$entArray[] = $contents;
	}
  $returndata = json_encode($entArray);
	echo $returndata;
?>