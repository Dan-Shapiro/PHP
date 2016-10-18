<!DOCTYPE html>
<html>
<?php
session_start();

if(isset($_COOKIE["size"]))
{
	setcookie("size", 0, time()-60);
}

if(isset($_COOKIE["items"]))
{
	setcookie("items", 0, time()-60);
}

	$user = $_POST["username"];
	$pass = $_POST["password"];
	$_SESSION["name"] = $user;
	$userpass = $user . ":" . $pass;
	
	$fileptr = fopen("buyers.txt", "r");
	$found = 0;
	
	//this deals with user login
	while($getInfo = fgetss($fileptr)):
		$info = explode(":", $getInfo);
		if(strcmp(rtrim($user), rtrim($info[0])) == 0) 
		{
			if(strcmp(rtrim($pass), rtrim($info[1])) == 0)
			{
				header("Location: store.php?name=" . $user);
				$found = 1;
			}
		}
	endwhile;
	fclose($fileptr);
	if(!($found))
	{
		$fileptr = fopen("buyers.txt", "a");
		fwrite($fileptr, $userpass);
		fwrite($fileptr, "\n");
		fclose($fileptr);
		echo "$user, your username and password has been registered.";
	?>
		<form action="store.php" method="POST">
			<p align="center"><button type="submit">Go to Store</button></p>
		</form>
	<?php
	}
?>
</html>