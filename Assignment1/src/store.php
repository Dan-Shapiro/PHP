<!DOCTYPE html>
<html>
<h3>Store Page:</h3>
<?php
	session_start();

	if(!isset($_SESSION["name"]))
	{
		$user = $_GET['name'];
		setcookie("name", $user, time()+360);
	}
	else
	{
		$user = $_SESSION["name"];
	}
	
	
	echo "<h1>Welcome to the online store, $user!</h1>";
	if(!isset($_COOKIE["size"]))
	{
		$numitems = 0;
		setcookie("size", $numitems, time()+60);
	}
	else
	{
		$numitems = $_COOKIE["size"];
	}
	echo "<div style='text-align:right'><strong>Number of items in cart: $numitems</strong></div>";
?>
	<table border="1" style="width:100%">
	<tr>
		<td style=text-align:center>Item</td>
		<td style=text-align:center>Image</td>
		<td style=text-align:center>Price</td>
		<td style="width:25%"></td>
	</tr>
<?php
	$fileptr = fopen("store.txt", "r");
	$count = 1;
	while($getStore = fgetss($fileptr)):
		$info = explode("&", $getStore);
		echo "<tr>";
		echo "<td style=text-align:center>$info[0]</td>";
		echo "<td style=text-align:center><img src='$info[1]' style='width:100px;height:100px'></td>";
		echo "<td style=text-align:center>$info[2]</td>";
		?>
		<td style=text-align:center>
		<form action="addcart.php" method="POST">
		<button type="submit" name= "<?php echo $count; ?>" value="<?php echo $info[0] . "#" . $info[2]; ?>">Add to Cart</button>
		</form>
		</td>
		<?php
		echo "</tr>";
		$count++;
	endwhile;
	fclose($fileptr);
?>
</table>

<form action="home.html" method="POST">
	<button type="submit">Logout</button>
</form>
<form action="checkout.php" method="POST">
	<p align="right"><button type="submit">Checkout</button></p>
</form>

</html>