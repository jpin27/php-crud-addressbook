<!DOCTYPE html>

<html>
	<head>
	</head>
	<body>
		<?php
		$servername="lovett.usask.ca";
		$username="cmpt350_mtn610";
		$password="xqywvz0m81";
		$dbname="cmpt350_mtn610";
		
		$conn = new mysqli($servername, $username, $password, $dbname);
		
		if($conn->connect_error)
			die("connection failed: ".$conn->connect_error);
		else
			echo "Connected successfully";
		
		$sql = "INSERT INTO HotelGuests3 (firstname, lastname, 
			CreditCard, CheckoutDay) VALUES ('".$_POST['fname']."',
			'".$_POST['lname']."', '".$_POST['cc']."', '".$_POST['date']."')";
			
			if($conn->query($sql) == TRUE)
				echo "New Hotel Guest create successfully: ".$sql."<br/>
				with id:".$conn->insert_id;
			else
				echo "Error with query: " .$sql."<br/>".$conn->error;
		 ?> 
	</body>
</html>