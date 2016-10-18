<!DOCTYPE html>
<html>
<h3>Checkout Page:</h3>
<center><h1>Checkout Summary</h1></center>
<table border="1" style="width:100%">
	<tr>
		<td style=text-align:center>Product</td>
		<td style=text-align:center>Price</td>
	</tr>

<?php
	$values = unserialize($_COOKIE["items"]);
	$size = $_COOKIE["size"];
	$count = 0;
	while($count < $size)
	{
		$vals = explode("#", $values[$count]);
		echo "<tr>";
		echo "<td style=text-align:center>$vals[0]</td>";
		echo "<td style=text-align:center>$vals[1]</td>";
		echo "</td>";
		$count++;
	}
?>
</table>
<form action="home.html" method="POST">
	<button type="submit">Logout</button>
</form>
</html>