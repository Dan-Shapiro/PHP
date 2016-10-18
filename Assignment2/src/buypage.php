<!DOCTYPE html>
<html>
<?php

	session_start();
	
	//if not set, you did not login
	if(!isset($_SESSION['good']))
	{
		header("Location: notallowed.php");
	}
	
	//connect to db
	$db = new mysqli('localhost', 'root', '', 'dan');
	if($db->connect_error)
	{
		die ("Could not connect to db: " . $db->connect_error);
	}

	//get category
	if(isset($_POST['Category']))
	{
		$cat = $_POST['Category'];
	}
	else
	{
		$cat = 0;
	}

	echo "You are viewing the ";
	switch($cat)
	{
		case 1:
			$catstr = "Music";
			break;
		case 2:
			$catstr = "Cars";
			break;
		default:
			$catstr = "Books";
			break;
	}
	echo "$catstr category.<br />";
	
	//set cookie for cart size
	if(!isset($_COOKIE["size"]))
	{
		$numitems = 0;
		setcookie("size", $numitems, time()+600);
	}
	//get cookie for cart size
	else
	{
		$numitems = $_COOKIE["size"];
	}
	//display cart size
	echo "<div style='text-align:right'><strong>Number of items in cart: $numitems</strong></div>";
	
	//only take rows needed for store
	$tables = array("Items"=>array("IName", "IDescription", "ICost", "IQuantity"));

	foreach ($tables as $curr_table=>$curr_keys):
		//get store from database matching category
		$query = "select Items.IName, Items.IDescription, Items.ICost, Items.IQuantity from Items where Items.ICategory = $cat && Items.IQuantity > 0";
		$result = $db->query($query);
         $rows = $result->num_rows; #Det. num. of rows
         $keys = $curr_keys;
?>
	<!--create table-->
      <table border = "1">
      <caption><?php echo $curr_table;?></caption>
      <tr align = "center">

	<!--column headers-->
	<th>Item</th>
	<th>Description</th>
	<th>Price</th>
	<th>Number Left</th>
	<th></th>
<?php
         echo "</tr>"; 
         for ($i = 0; $i < $rows; $i++):  #For each row in result table
             echo "<tr align = center>";
             $row = $result->fetch_array();  #Get next row
			 
			 
             foreach ($keys as $next_key)  #For each column in row
             {
                  echo "<td> $row[$next_key] </td>"; #Write data in col
             }
?>
	<!-- add to cart-->
	<td style=text-align:center>
		<form action="addcart.php" method="POST">
		<button type="submit" name= "<?php echo "item"; ?>" value="<?php echo "$row[0]"; ?>">Add to Cart</button>
		</form>
	</td>
	
<?php
             echo "</tr>";
         endfor;
         echo "</table><br />";
      endforeach;
?>
<!--change category-->
<form action="buypage.php" method="POST">
	Item Category:<select name="Category">
						<option value=0>Books</option>
						<option value=1>Music</option>
						<option value=2>Cars</option></select>
	<input type="submit" value="Switch Category"><br />
</form>

<!--checkout-->
<form action="checkout.php" method="POST">
	<input type="hidden" name="valid" value="yes">
	<button type="submit">Checkout</button><br />
</form>

<!--logout-->
<form action="logout.php" method="POST">
	<button type="submit">Logout</button>
</form>
</html>