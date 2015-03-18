/* Assignment 2B 
 * addressbook.js is the Controller in the MVC pattern for the CRUD address book
 * website designed for this assignment.
 *
 * As a Controller, it handles as an intermediary between the Model which is done in PHP
 * linked to a MySQL database, and the HTML View.
 * 
 * AJAX functions have been used extensively to limit the user experience to a single 
 * webpage. This avoids unnecessary multiple pages that would only otherwise display 
 * a nugget of data. 
 *
 * Jude Pineda jmp846 11094980 */
 
 
// Let's make a local version of the contact list, pulled from the database.
localContactList = ""; 

// Function to ensure there are no duplicate entries 
// TODO: Write documentation that says same first and last names are not allowed
// in this version of the address book 

function isDuplicate(fname, lname){ 
	var isduplicate = false; 
	for(var i = 0; i < localContactList.length; i++){ 
		if(localContactList[i].fname.toLowerCase() == fname.toLowerCase() 
		&& localContactList[i].lname.toLowerCase() == lname.toLowerCase()){ 
			isduplicate = true; 
		} 
	}	 
	return isduplicate; 
} 

// Use some AJAX to refresh the address book
function refreshAddressBook(items){ 

	// Empty the contact list 
	var list = $('#contacts-lists'); 
	
	

	// Save a client copy of the items array for validation.
	// This happens everytime this function is called. 
	localContactList = items;
	
	// This loop displays the contact list with the corresponding delete button
	// TODO: Make the contact an <a href> such that pressing the contact will show a popup that displays all
	// the info for the contact
	var lh = ""; 
	for(var i = 0; i < items.length; i++){ 
		lh += "<li>" + items[i].firstName + " " + items[i].lastName;  
		lh += " [ " + items[i].phoneNumber + " ] "; 
		lh += '<a href = "#delete-id" class = "deletebtn" contactid = "' + items[i].id + '"> delete contact </a>' 
		lh += "</li>"; 
	} 
	list.html(lh); 

	// Set the delete button event after every reload 
	setDeleteButtonListener() 
} 

// This is what is executed when the Save button is clicked.
function setSaveButtonListener(){ 
	$('#save-contact-btn').click(function(){ 
		//hide notice 
		$('#notice').hide(); 
		
		//get the name and phone data 
		var fname = $('#fname').val(); 
		var lname = $('#lname').val(); 
		var company = $('#company').val(); 
		var email = $('#email').val(); 
		var url = $('#url').val(); 
		var phone = $('#phone').val(); 
		var address = $('#address').val(); 
		var bday = $('#bday').val(); 
		var notes = $('#notes').val();
		
		
		//Error checking goes here.
		//TODO: More validation checks.
		/*
		if(fname == "" || lname == "" || phone == ""){ 
			$('#notice').empty().html('The name or number fields cannot be null').show('slow'); 
		} else if(isDuplicate(fname, lname)){ 
			$('#notice').empty().html('the contact info you specified is already in the database').show('slow'); 
		} else if(isNaN(new Number(phone))){ 
			$('#notice').empty().html('the phone field must contain valid numeric data').show('slow'); 
		} else if(name.match(/d/)){ 
			$('#notice').empty().html('the name field must not contain numeric input').show('slow'); 
		} else{ 
*/
		// call the AJAX save function.
		// TODO: This is what I'm stuck at right now. 
		// Note: this does not work either,I keep getting a parser error - unexpected /. 
		// I have no idea where the stray slash comes from.
		// Idea: Maybe use GET instead of POST?
		
			// Display the Saving... prompt
			// millisecond delay?
			$('#notice').empty().html('Saving....').show(); 
			
			$.ajax({ 
				url: 'addressbook.php', 
				type: 'post',
				data: 'action=add&' + $('#add-contact-form').serialize() 
			}).done(function(yay){   
				
				// Empty the fields
				$('#fname').val(''); 
				$('#lname').val(''); 
				$('#company').val(''); 
				$('#email').val(''); 
				$('#url').val(''); 
				$('#phone').val(''); 
				$('#address').val(''); 
				$('#bday').val(''); 
				$('#notes').val('');
				// Reload the contact list to display new contact info 
				refreshAddressBook(yay.contacts); 
				$('#notice').empty().html('Saved to database').show();
			}).fail(function(XMLHttpRequest, textStatus, errorThrown) { 
					alert("Error adding. Status: " + textStatus); alert("Error: " + errorThrown); 
			});
			 
		//}	
	}); 
} 

// This is what happens when the Delete button is clicked.
function setDeleteButtonListener(){ 
	$('.deletebtn').each(function(i){ 
	
		// Put the listener on every Delete button 
		$(this).click(function(){ 
			
			var answer = confirm("Are you sure you want to delete the contact?"); 
			if(!answer) return; 
			
			// Hide the Add Contact form 
			$('#add-contact-form').hide(); 
			
			// Update the dialog box 
			$('#notice').empty().html('deleting...').show(); 
			
			// Get the id of the contact to be deleted...
			var id = $(this).attr('contactid'); 
			
			// ...then delete that mofo. 
			$.ajax({ 
				url: 'addressbook.php', 
				data: 'action = delete&id = '+id, 
				
				//dataType: 'json', 
				type: 'post', 
				success: function (j) {   
					$('#notice').empty().html(j.msg); 
					//refresh the address list 
					refreshAddressBook(j.contacts); 
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
					alert("Error deleting. Status: " + textStatus); alert("Error: " + errorThrown); 
				}
			}); 
		}); 
	}); 
}
 
// $(document).ready is an essential function - it loads
// when all the JavaScript is loaded and there are no errors.
// Setup the page when JavaScript is loaded
$(document).ready(function(){ 

	// Hide the Add Contact form
	$('#addContactForm').hide();

	// Hide the error notification window 
	$('#notice').hide(); 
	
	// Setup the listener for the Add Contact button 
	$('#add-contact-btn').click(function(){ 
		
		// Double check - hide error message notification window
		$('#notice').hide(); 
		// Slowly show the Add Contact form when the button is clicked
		$('#addContactForm').show('slow'); 
	}); 

	// Setup the AJAX event for the Add Contact button 
	$('#cancel-btn').click(function(){ 
		
		// Hide the Add Contact form and the error notification window
		$('#addContactForm').hide('slow'); 
		$('#notice').hide(); 
		
		// Clear the form 
		$('#names').val(''); 
		$('#phone').val(''); 
	}); 

	// Setup the listeners for the CRUD operation buttons 
	setDeleteButtonListener(); 
	setSaveButtonListener(); 
	
	// Finally, load the contact list.
	$.ajax({ 
		url: 'addressbook.php', 
		data: '', 
		dataType: 'json', 
		type: 'post', 
		success: function (j) { 
			//refresh the address list 
			refreshAddressBook(j.contacts); 
		},
	}); 
}); 