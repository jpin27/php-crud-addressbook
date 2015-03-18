<!DOCTYPE html>

<html>
	<head>
	</head>
	<body>
		<?php
		$servername="lovett.usask.ca";
		$username="cmpt350_jmp846";
		$password="zak3hocoax";
		$dbname="cmpt350_jmp846";
		
		$conn = new mysqli($servername, $username, $password, $dbname);
		
		if($conn->connect_error)
			die("connection failed: ".$conn->connect_error);
		else
			echo "Connected successfully";
			
		$sql = "CREATE TABLE IF NOT EXISTS HotelGuests3 (
			id INT AUTO_INCREMENT PRIMARY KEY,
			firstname VARCHAR(30) NOT NULL,
			lastname VARCHAR(30) NOT NULL,
			CreditCard CHAR(16),
			CheckoutDay DATE
		)";
			
		if($conn->query($sql) == TRUE)
			echo "Table HotelGuests3 created successfully";
		else
			echo "Error creating table: ".$conn->error;
			
		$conn->close();
		 ?> 
	</body>
</html>