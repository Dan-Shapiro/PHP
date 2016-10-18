<!DOCTYPE html>
<html>
<?php
	session_start();

	$size = $_COOKIE["size"];
	$size++;
	setcookie("size", $size, time()+60);
	
	foreach($_POST as $key => $value)
	{
		if(!isset($_COOKIE["items"]))
		{
			$cart = array($value);
			setcookie("items", serialize($cart), time()+60);
		}
		else
		{
			$cart = unserialize($_COOKIE["items"]);
			$cart[] = $value;
			setcookie("items", serialize($cart), time()+60);
			$cart = unserialize($_COOKIE["items"]);
		}
	}
	
	header("Location: store.php");
?>
</html>