<!DOCTYPE html>
<html>
<?php
	//connect to db
	$db = new mysqli('localhost', 'root', '', 'dan');
	if($db->connect_error)
	{
		die("Could not connect to db: " . $db->connect_error);
	}

	//assign post values to table values
	$n = $_POST['Name'];
	$c = $_POST['Category'];
	$d = $_POST['Description'];
	$co = $_POST['Cost'];
	$q = $_POST['Quantity'];
	$id = $_POST['id'];
	
	//form query and add it
	$query = "INSERT INTO Items (IName, ICategory, IDescription, ICost, IQuantity, IOwnerID) VALUES ('$n', '$c', '$d', '$co', '$q', '$id')";
			
	$db->query($query) or die("Invalid insert: " . $db->error);
?>

<form action="logout.php" method="POST">
	<button type="submit">Logout</button>
</form>

</html>