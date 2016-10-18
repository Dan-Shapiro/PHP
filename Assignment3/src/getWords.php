<!DOCTYPE html>
<html>
<?php
	//set up db
	$db = new mysqli('localhost', 'root', '', 'dan');
	if($db->connect_error)
	{
		die ("Could not connect to db: " . $db->connect_error);
	}
	
	//get number of rows in db
	$query = "SELECT * FROM words";
	$result = $db->query($query);
	$rows = $result->num_rows;
	
	//pick 5 random unique numbers between 1 and $rows
	$num1 = mt_rand(1, $rows);
	$num2 = mt_rand(1, $rows);
	while($num2 == $num1)
	{
		$num2 = mt_rand(1, $rows);
		echo $num2;
	}
	$num3 = mt_rand(1, $rows);
	while($num3 == $num1 && $num3 == $num2)
	{
		$num3 = mt_rand(1, $rows);
	}
	$num4 = mt_rand(1, $rows);
	while($num4 == $num1 && $num4 == $num2 && $num4 == $num3)
	{
		$num4 = mt_rand(1, $rows);
	}
	$num5 = mt_rand(1, $rows);
	while($num5 == $num1 && $num5 == $num2 && $num5 == $num3 && $num5 == $num4)
	{
		$num5 = mt_rand(1, $rows);
	}
	
	//get corresponding words
	$query = "SELECT words.word FROM words WHERE words.id=$num1";
	$result = $db->query($query);
	$word1 = $result->fetch_array();
	
	$query = "SELECT words.word FROM words WHERE words.id=$num2";
	$result = $db->query($query);
	$word2 = $result->fetch_array();
	
	$query = "SELECT words.word FROM words WHERE words.id=$num3";
	$result = $db->query($query);
	$word3 = $result->fetch_array();
	
	$query = "SELECT words.word FROM words WHERE words.id=$num4";
	$result = $db->query($query);
	$word4 = $result->fetch_array();
	
	$query = "SELECT words.word FROM words WHERE words.id=$num5";
	$result = $db->query($query);
	$word5 = $result->fetch_array();
	
	//output them so script can read them
	echo $word1[0] . $word2[0] . $word3[0] . $word4[0] . $word5[0];	
?>
<html>