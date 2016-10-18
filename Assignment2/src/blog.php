<!DOCTYPE html>
<html>
<?php
	session_start();
	
	//retrieve from the form
	$email = rtrim(strip_tags($_POST["email"]));
	$pass = rtrim(strip_tags($_POST["password"]));
	
	setcookie("bemail", $email, time()+600);
	
	//connect to db
	$db = new mysqli('localhost', 'root', '', 'dan');
	if($db->connect_error)
	{
		die ("Could not connect to db: " . $db->connect_error);
	}
	
	//build query
	$query = "SELECT * FROM Buyers WHERE BEmail='" . $email . "' AND BPassword='" . $pass . "'";
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
	if($num_rows == 0)
	{
		session_destroy();
		header("Location: fail.php");
	}
	
	//create session variable
	$_SESSION['good'] = "good";
	
	//go to owner page
	echo "Log in successful!<br />";
?>
	<form action="buypage.php" method="POST">
		<input type="hidden" name="email" value=<?php echo "$email" ?>>
		<input type="hidden" name="password" value=<?php echo "$pass" ?>>
		<input type="submit" value="Go to Page">
	</form>
</html>