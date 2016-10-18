<!DOCTYPE html>
<html>
<?php
	if(!isset($_POST['valid']))
	{
		header("Location: notallowed.php");
	}
?>


<center>Checkout Summary</center>
	<!--create table-->
      <table border = "1" width="100%">
      <caption>Items Purchased</caption>
      <tr align = "center">

	<!--column headers-->
	<th width="50%">Product</th>
	<th width="50%">Price</th>
	</tr>
<?php
	//connect to db
	$db = new mysqli('localhost', 'root', '', 'dan');
	if($db->connect_error)
	{
		die ("Could not connect to db: " . $db->connect_error);
	}
	
	//mail info////////////////////////////////////////////
	
	$mailpath = 'C:/xampp/htdocs/Assignment2/src/PHPMailer';
	
	$path = get_include_path();
	set_include_path($path . PATH_SEPARATOR . $mailpath);
	require 'PHPMailerAutoload.php';
	
	$mail = new PHPMailer();
 
	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->SMTPAuth = true; // enable SMTP authentication
	$mail->SMTPSecure = "tls"; // sets tls authentication
	$mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server; or your email service
	$mail->Port = 587; // set the SMTP port for GMAIL server; or your email server port
	$mail->Username = "cs4501.fall15@gmail.com"; // email username
	$mail->Password = "UVACSROCKS"; // email password

	$sender = "Assignment 2";
	$subj = "Someone bought your item!";

	//add to owner earned
	$total = 0; //total for buyer
	$query = "SELECT * FROM Checkout";
	$result = $db->query($query);
	$rows = $result->num_rows;
	
	for($i = 0; $i < $rows; $i++)  #For each row in result table
	{
		$row = $result->fetch_array();
		$name = $row[0];
		
		//get owner id of item and price of item
		$query = "SELECT Items.IOwnerID, Items.ICost FROM Items WHERE Items.IName='$name'";
		$res = $db->query($query);
		$row = $res->fetch_array();
		$id = $row[0];
		$price = $row[1];
		
		//add price to earned
		$query = "SELECT OEarned, OEmail, OName FROM Owners WHERE OID='$id'";
		$res = $db->query($query);
		$row = $res->fetch_array();
		$earned = $row[0] + $price;
		
		//send owner an email
		$receiver = $row[1];
		$msg = "Hey $row[2], Your item \"$name\" has been bought for $price dollars.";
		
		// Put information into the message
		$mail->addAddress($receiver);
		$mail->SetFrom($sender);
		$mail->Subject = "$subj";
		$mail->Body = "$msg";
		
		if(!$mail->send()) 
		{
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
		
		//add to buyer total
		$total = $total + $price;
		
		//update table
		$query = "UPDATE Owners SET OEarned='$earned' WHERE OID='$id'";
		$res = $db->query($query);
	}

	//get items from db
	$query = "SELECT * FROM Checkout";
	$result = $db->query($query);
	
	$keys = array("Name", "Price");
	$rows = $result->num_rows;
	
	for ($i = 0; $i < $rows; $i++):  #For each row in result table
        echo "<tr align = center>";
        $row = $result->fetch_array();  #Get next row
			 
			 
        foreach ($keys as $next_key)  #For each column in row
        {
            echo "<td> $row[$next_key] </td>"; #Write data in col
        }
        echo "</tr>";
    endfor;
?>
</table><br />

<?php
	//get buyer info
	$bemail = $_COOKIE['bemail'];
	$query = "SELECT Buyers.BName, Buyers.BAddress FROM Buyers WHERE Buyers.BEmail='$bemail'";
	$result = $db->query($query);
	$row = $result->fetch_array();
	$bname = $row[0];
	$baddress = $row[1];
	
	//buyer confirmation
	$dollar = '$';
	echo "Thank you, $bname. Your total is " . $dollar . $total . " and your items will be shipped to $baddress";
?>

<form action="clear.php" method="POST">
	<button type="submit">Logout</button>
</form>
	
</html>