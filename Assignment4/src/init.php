<?php
	$db = new mysqli('localhost', 'root', '', 'dan');
	
	if ($db->connect_error): 
		die ("Could not connect to db " . $db->connect_error); 
	endif;
	
	$db->query("drop table entree, appetizer, favorite");
	
	$result = $db->query("create table entree (id int primary key not null auto_increment, title varchar(30), ingredients varchar(30), directions varchar(90), rating varchar(5))") or die ("Invalid: " . $db->error);
	$result = $db->query("create table appetizer (id int primary key not null auto_increment, title varchar(30), ingredients varchar(30), directions varchar(90), rating varchar(5))") or die ("Invalid: " . $db->error);
	$result = $db->query("create table favorite (id int primary key not null auto_increment, title varchar(30), ingredients varchar(30), directions varchar(90), rating varchar(5))") or die ("Invalid: " . $db->error);
	
	$xml=simplexml_load_file("cookbook.xml") or die("Error: Cannot create object");
	$json = json_encode($xml);
	$array = json_decode($json,TRUE);
  
  $categories = $array["categories"];
  $ent = $categories["Entree_menu"];
  $app = $categories["Appetizer_menu"];
  $fav = $categories["Favorite_menu"];
  
	foreach ($ent["recipe"] as $recobj) {
    $title = trim($recobj["title"]);
    $ingr = trim($recobj["ingredients"]);
    $dir = trim($recobj["directions"]);
    $rate = trim($recobj["rating"]);
    $query = "insert into entree values (NULL, '$title', '$ingr', '$dir', '$rate')"; 
		$db->query($query) or die ("Invalid insert " . $db->error);
  }
  
  foreach ($app["recipe"] as $recobj) {
    $title = trim($recobj["title"]);
    $ingr = trim($recobj["ingredients"]);
    $dir = trim($recobj["directions"]);
    $rate = trim($recobj["rating"]);
    $query = "insert into appetizer values (NULL, '$title', '$ingr', '$dir', '$rate')"; 
		$db->query($query) or die ("Invalid insert " . $db->error);
  }
  
  foreach ($fav["recipe"] as $recobj) {
    $title = trim($recobj["title"]);
    $ingr = trim($recobj["ingredients"]);
    $dir = trim($recobj["directions"]);
    $rate = trim($recobj["rating"]);
    $query = "insert into favorite values (NULL, '$title', '$ingr', '$dir', '$rate')"; 
		$db->query($query) or die ("Invalid insert " . $db->error);
  }
  
  header("Location: home.html");
?>
