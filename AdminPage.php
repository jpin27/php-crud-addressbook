<!DOCTYPE html>

<html>
	<head>
	</head>
	<body>
		<table>
			<tr>
				<th>ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Credit Card</th>
				<th>Checkout Date</th>
				<th></th>
				<th></th>
			</tr>
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
			
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()){
					echo "<tr>
						<tr>
						<td>".$row["id"]."</td>
						<td>".$row["firstname"]."</td>
						<td>".$row["lastname"]."</td>
						<td>".$row["CreditCard"]."</td>
						<td>".$row["CheckoutDay"]."</td>
						<td>
							<a href='UpdateGuest.php?GuestID=".$row["id"]."'>
								UPDATE
							</a>
						</td>
						<td>
							<a href='DeleteGuest.php?GuestID=".$row["id"]."'
								onclick='return confirm(/"Are you sure?/")'>
								DELETE
							</a>
						</td>
					</tr>";
				}
			}
			else
				echo "0 results";
		 ?>
		 </table>
	</body>
</html>