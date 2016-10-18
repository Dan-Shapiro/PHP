<!DOCTYPE html>
<html>
<?php
	//end session variables
	session_start();
	session_unset($_SESSION['good']);
	session_destroy();
	
	//delete cookies
	setcookie("size", 0, time()-600);
	
	//go back to home
	header("Location: home.php");
?>
</html>