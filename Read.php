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
			
			$id = $_GET['GuestID'];
			$sql = "SELECT * FROM HotelGuests3 WHERE id=".$id;
			$result = $conn->query($sql);
			
			if($result->num_rows > 0){ //Tell us how many rows are returned with this query
				$row = $result->fetch_assoc();
				echo "<table>
					<tr>
						<td>ID:</td>
						<td>".$row["id"]."</td>
					</tr>
					<tr>
						<td>Name:</td>
						<td>".$row["firstname"]." ".$row["lastname"]."</td>
					</tr>
					<tr>
						<td>Credit Card Info:</td>
						<td>".$row["CreditCard"]."</td>
					</tr>
					<tr>
						<td>Checkout Day:</td>
						<td>".$row["CheckoutDay"]."</td>
					</tr>
				</table>";
				/*http://homepage.usask.ca/~rgv639/Lab2/Read.php?GuestID=2*/
			}
			else
				echo "0 results";
		 ?> 
	</body>
</html>