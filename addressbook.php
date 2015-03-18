/* Assignment 2B 
 * addressbook.php is the Model in the MVC pattern for the CRUD address book
 * website designed for this assignment.
 *
 * It only handles the operations on the MySQL back-end and does not in any way
 * interface with the JavaScript controller or the HTML View.
 *
 * Jude Pineda jmp846 11094980 */

/*

Note: The following SQL code has been executed in the database whose credentials are
given below. This is a prerequisite before running any of the CRUD operations on the
website.

CREATE TABLE contacts ( 
	id INT(4) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	firstName VARCHAR(50) NOT NULL, 
	lastName VARCHAR(50) NOT NULL,
	company VARCHAR(100) NOT NULL,
	phoneNumber VARCHAR(15) NOT NULL,
	email VARCHAR(50),
	url VARCHAR(80),
	address VARCHAR(200),
	birthday VARCHAR(20),
	notes VARCHAR(500) 
);

*/


<?php 

//configure the database paramaters 
$hostname = "lovett.usask.ca"; 
$dbname = "cmpt350_jmp846"; 
$uname = "cmpt350_jmp846"; 
$pword = "zak3hocoax"; 

// Connect to, and select the database
$conn = new mysqli($hostname, $uname, $pword, $dbname);
if($conn -> connect_error)
	die("connection failed: ".$conn->connect_error);
else echo "Connected successfully";




// THIS SHIT WORKS!!!!


// saveContact() adds a new contact to the database 
function saveContact($fName, $lName, $company, $pNumber, $email, $url, $address, $bday, $notes){ 
	
	echo "I'm here! " . $fName . "', '" 
		. $lName . "', '" 
		. $company . "', '" 
		. $pNumber . "', '" 
		. $email . "', '" 
		. $url . "', '" 
		. $address . "', '" 
		. $bday . "', '" 
		. $notes . "')"; 
	
	$sql = "INSERT INTO contacts (firstName, lastName, company, 
		phoneNumber, email, url, address, birthday, notes) VALUES ('" 
		. $fName . "', '" 
		. $lName . "', '" 
		. $company . "', '" 
		. $pNumber . "', '" 
		. $email . "', '" 
		. $url . "', '" 
		. $address . "', '" 
		. $bday . "', '" 
		. $notes . "')"; 
		
	if($GLOBALS["conn"] -> query($sql) == TRUE)
		echo "New contact added successfully: " . $sql . "<br/>
		with id:" . $GLOBALS["conn"] -> insert_id;
	else
		echo "Error with query: " . $sql . "<br/>" . $GLOBALS["conn"] -> error;
	
	//$result = mysqli_query($sql) or die(mysql_error()); 
} 

// the function below deletes a contact given an id.
function deleteContact($id){ 
	$sql = "DELETE FROM contacts where id = " . $id; 
	$result = mysqli_query($sql); 
} 
  
// accessor function to get all the contacts. returns an object array.
function refreshAddressBook(){ 
	
	// execute SQL command to get all contents of the table
	$sql = "SELECT * FROM contacts"; 
	$result = $GLOBALS["conn"] -> query($sql); 
	
	// place them in an array of objects
	$contacts = array(); 
	while($record = mysqli_fetch_object($result)){ 
		array_push($contacts,$record); 
	}
	
	return $contacts; 
} 

// Get whatever command AJAX throws at us 
$action = isset($_POST['action']) ? $_POST['action'] : ''; 

echo "ACTION IS " . $action;

// It's either add or delete. 
if($action == "add"){

	// get the submitted information
	$fName = $_POST['fname'];
	$lName = $_POST['lname'];
	$company = $_POST['company'];
	$email = $_POST['email'];
	$url = $_POST['url'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$bday = $_POST['bday'];
	$notes = $_POST['notes'];
	
	// create a row in the database with the pulled credentials
	saveContact($fName, $lName, $company, $email, $url, $phone, $address, $bday, $notes);
	$output['msg'] = "Contact " . $fName . " " . $lName . " has been saved successfully";
	
	// refresh the contact list
	$output['contacts'] = refreshAddressBook();
	echo json_encode($output); 
} else if($action == "delete"){
	
	// get the id from the POST attribute (or whatever it's called)
	$id = $_POST['id'];

	// remove the contact with the given id
	deleteContact($id); 
	$output['msg'] = "The entry has been deleted."; 

	// refresh the contact list
	$output['contacts'] = refreshAddressBook(); 
	echo json_encode($output); 
} else { 
	$output['contacts'] = refreshAddressBook(); 
	$output['msg'] = "Contact list refreshed"; 
	echo json_encode($output); 
} 