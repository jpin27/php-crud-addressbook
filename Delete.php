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
				
			$id=$_GET['GuestID'];
			$sql = "DELETE FROM HotelGuests3 WHERE id=".$id;
			
			if($conn->query($sql) == TRUE)
				echo "Record delete successfully";
			else
				echo "error deleting record: ".$conn->error;
		 ?> 
	</body>
</html>