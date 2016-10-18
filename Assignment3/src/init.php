<!DOCTYPE html>
<html>
<?php
	//set up db
	$db = new mysqli('localhost', 'root', '', 'dan');
	if($db->connect_error)
	{
		die ("Could not connect to db: " . $db->connect_error);
	}
	
	//drop tables
	$db->query("drop table Words");
	
	//create tables
	$result = $db->query("create table Words	(id int primary key not null, 
												word char(5) not null)") 
												or die ("Invalid: " . $db->error);
	$w = file("words.txt");
	
	//read from flat file
	$c = 1;
	foreach ($w as $words)
	{
		$w = rtrim($words);
		$query = "insert into Words values ($c, '$w')";
		$c++;
		$db->query($query) or die("Invalid insert : " . $db->error);
	}
	
	header("Location: home1.php");
?>
<html>