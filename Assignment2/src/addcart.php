<!DOCTYPE html>
<html>
<?php
	//connect to db
	$db = new mysqli('localhost', 'root', '', 'dan');
	if($db->connect_error)
	{
		die ("Could not connect to db: " . $db->connect_error);
	}
	
	//increment cart size
	$size = $_COOKIE["size"];
	$size++;
	setcookie("size", $size, time()+600);
	
	//get item added
	$name = $_POST['item'];
	
	//decrement quantity
	$query = "SELECT Items.IQuantity FROM Items WHERE Items.IName='$name'";
	$result = $db->query($query);
	$row = $result->fetch_array();
	$quant = $row[0] - 1;
	
	//update item table
	$query = "UPDATE Items SET IQuantity='$quant' WHERE Items.IName='$name'";
	$result = $db->query($query);
	
	//insert into checkout table
	$query = "SELECT Items.ICost FROM Items Where Items.IName='$name'";
	$result = $db->query($query);
	$price = $result->fetch_array();
	$query = "insert into Checkout values ('$name', '$price[0]')";
	$result = $db->query($query) or die("Invalid insert: " . $db->error);
	
	//go back to store
	header("Location: buypage.php");
?>
</html>