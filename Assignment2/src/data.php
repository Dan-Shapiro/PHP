<?php
	
	//set up db
	$db = new mysqli('localhost', 'root', '', 'dan');
	if($db->connect_error):
		die ("Could not connect to db: " . $db->connect_error);
	endif;
	
	//drop tables
	$db->query("drop table Buyers");
	$db->query("drop table Owners");
	$db->query("drop table Items");
	$db->query("drop table Checkout");
	
	//create tables
	//Buyers
	$result = $db->query("create table Buyers	(BID int primary key not null, 
												BName char(30) not null, 
												BEmail char(30) not null, 
												BPassword char(30) not null, 
												BAddress char(80) not null)") 
												or die ("Invalid: " . $db->error);
	$buy = file("buyers.txt");
	
	//read from flat file
	foreach ($buy as $buyers)
	{
		$buyers = rtrim($buyers);
		$buy = preg_split("/[#]+/", $buyers);
		$query = "insert into Buyers values ('$buy[0]', '$buy[1]', '$buy[2]', '$buy[3]', '$buy[4]')";
		$db->query($query) or die("Invalid insert : " . $db->error);
	}
	
	//Owners
	$result = $db->query("create table Owners	(OID int primary key not null, 
												OName char(30) not null, 
												OEmail char(30) not null, 
												OPassword char(30) not null, 
												OEarned decimal(10,2) not null)") 
												or die ("Invalid: " . $db->error);
	$own = file("owners.txt");
	
	//read from flat file
	foreach ($own as $owners)
	{
		$owners = rtrim($owners);
		$own = preg_split("/[#]+/", $owners);
		$query = "insert into Owners values ('$own[0]', '$own[1]', '$own[2]', '$own[3]', '$own[4]')";
		$db->query($query) or die("Invalid insert : " . $db->error);
	}
	
	//Items
	$result = $db->query("create table Items	(IName char(30) not null, 
												ICategory int(11) not null, 
												IDescription char(30) not null, 
												ICost decimal(10,2) not null, 
												IQuantity int(11) not null, 
												IOwnerID int(11) not null)") 
												or die ("Invalid: " . $db->error);
	$it = file("items.txt");
	
	//read from flat file
	foreach ($it as $items)
	{
		$items = rtrim($items);
		$it = preg_split("/[#]+/", $items);
		$query = "insert into Items values ('$it[0]', '$it[1]', '$it[2]', '$it[3]', '$it[4]', '$it[5]')";
		$db->query($query) or die("Invalid insert: " . $db->error);
	}
	
	
	//Checkout
	$result = $db->query("create table Checkout	(Name char(30) not null,
												Price decimal(10,2) not null)")
												or die ("Invalid: " . $db->error);
	
	//go to homepage
	header("Location: home.php");
?>
</html>