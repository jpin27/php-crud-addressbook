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

//configure the database paramaters 
$hostname = "lovett.usask.ca"; 
$dbname = "cmpt350_jmp846"; 
$uname = "cmpt350_jmp846"; 
$pword = "zak3hocoax"; 

// Connect to, and select the database
$addressbook = mysql_pconnect($hostname, $uname, $pword) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($dbname); 

// saveContact() adds a new contact to the database 
function saveContact($fName, $lName, $company, $pNumber, $email, $url, $address, $bday, $notes){ 
	$sql = "INSERT INTO contacts (firstName, lastName, company, phoneNumber, email, url, address, birthday, notes) VALUES ('" . $fName . "','" . $lName . "','" . $company . "','" . $pNumber . "','" . $email . "','" . $url .
	"','" . $address . "','" . $bday . "','" . $notes . "');"; 
	$result = mysql_query($sql) or die(mysql_error()); 
} 

// the function below deletes a contact given an id.
function deleteContact($id){ 
	$sql = "DELETE FROM contacts where id = " . $id; 
	$result = mysql_query($sql); 
} 
  
// accessor function to get all the contacts. returns an object array.
function getContacts(){ 
	
	// execute SQL command to get all contents of the table
	$sql = "SELECT * FROM contacts"; 
	$result = mysql_query($sql); 
	
	// place them in an array of objects
	$contacts = array(); 
	while($record = mysql_fetch_object($result)){ 
		array_push($contacts,$record); 
	} 
	
	return $contacts; 
} 

// Get whatever command AJAX throws at us 
$action = $_POST['action']; 

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
	$output['contacts'] = getContacts();
	echo json_encode($output); 
} else if($action == "delete"){
	
	// get the id from the POST attribute (or whatever it's called)
	$id = $_POST['id'];

	// remove the contact with the given id
	deleteContact($id); 
	$output['msg'] = "The entry has been deleted."; 

	// refresh the contact list
	$output['contacts'] = getContacts(); 
	echo json_encode($output); 
} else { 
	$output['contacts'] = getContacts(); 
	$output['msg'] = "Contact list refreshed"; 
	echo json_encode($output); 
} 