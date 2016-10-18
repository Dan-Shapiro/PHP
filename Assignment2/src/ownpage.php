<!DOCTYPE html>
<html>
<?php
	session_start();

	//retrieve from the form
	$email = rtrim(strip_tags($_POST["email"]));
	$pass = rtrim(strip_tags($_POST["password"]));

	//connect to db
	$db = new mysqli('localhost', 'root', '', 'dan');
	if($db->connect_error)
	{
		die ("Could not connect to db: " . $db->connect_error);
	}

	//build query
	$query = "SELECT * FROM Owners WHERE OEmail='" . $email . "' AND OPassword='" . $pass . "'";
	trim($query);
	$query = stripslashes($query);
	
	//execute query
	$result = $db->query($query);
	if(!$result)
	{
		die ("Query could not be executed: " . $db->error);
	}
	
	//how many rows
	$num_rows = $result->num_rows;

	//if not set, you did not login
	if(!isset($_SESSION['good']))
	{
		header("Location: notallowed.php");
	}
	
	$row = $result->fetch_array();
	
	//page starts here
	echo "<h1>Owner Pages:</h1>";
	echo "<h2>Total Earned by " . $row[1] . ": $" . $row[4] . "</h2><br />";
	?>
	
	<!--create a new item-->
	<br />
	<h3>Fill out this form to add an item.</h2>
	<form action="addstore.php" method="POST">
	Item Name:<input type="text" name="Name"><br />
	Item Category:<select name="Category">
						<option value=0>Books</option>
						<option value=1>Music</option>
						<option value=2>Cars</option></select><br />
	Item Description:<input type="text" name="Description"><br />
	Item Cost:<input type="text" name="Cost"><br />
	Number of Item:<input type="number" name="Quantity"><br />
	<!--hidden field to add the owner id-->
	<input type="hidden" name="id" value="<?php echo $row[0] ?>">
	<input type="submit" value="Submit" />
	</form>
	
	<!--logout-->
	<form action="logout.php" method="POST">
	<button type="submit">Logout</button>
	</form>
</html>