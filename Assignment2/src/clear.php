<!DOCTYPE html>
<html>
<?php
	//connect to db
	$db = new mysqli('localhost', 'root', '', 'dan');
	if($db->connect_error)
	{
		die ("Could not connect to db: " . $db->connect_error);
	}
	
	//drop checkout table
	$query = "drop table Checkout";
	$result = $db->query($query);
	
	//create empty checkout table
	$result = $db->query("create table Checkout	(Name char(30) not null,
												Price decimal(10,2) not null)")
												or die ("Invalid: " . $db->error);
												
	//go to logout
	header("Location: logout.php");
?>
</html>