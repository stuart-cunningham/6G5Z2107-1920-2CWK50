<?php

// Things to notice:
// This script will let a logged-in user VIEW their account details and allow them to UPDATE those details
// The main job of this script is to execute an INSERT or UPDATE statement to create or update a user's account information...
// ... but only once the data the user supplied has been validated on the client-side, and then sanitised ("cleaned") and validated again on the server-side
// It's your job to add these steps into the code
// Both sign_up.php and sign_in.php do client-side validation, followed by sanitisation and validation again on the server-side -- you may find it helpful to look at how they work 
// HTML5 can validate all the account data for you on the client-side
// The PHP functions in helper.php will allow you to sanitise the data on the server-side and validate *some* of the fields... 
// There are fields you will want to add to allow the user to update them...
// ... you'll also need to add some new PHP functions of your own to validate email addresses, telephone numbers and dates

// execute the header script:
require_once "header.php";

// default values we show in the form:
$email = "";
    
// strings to hold any validation error messages:
$email_val = "";
 
// should we show the set profile form?:
$show_account_form = false;

// message to output to user:
$message = "";

// checks the session variable named 'loggedInSkeleton'
// take note that of the '!' (NOT operator) that precedes the 'isset' function
if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}


elseif (isset($_POST['email']))
{
	// user just tried to update their profile
	
	// connect directly to our database (notice 4th argument) we need the connection for sanitisation:
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	// if the connection fails, we need to know, so allow this exit:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	
	// SANITISATION CODE MISSING:

    // ...
    // Add your santitisation code around here
	// ...
	

	$email = $_POST['email'];

	
	// SERVER-SIDE VALIDATION CODE MISSING:

    // ...
    // Add your santitisation code around here
    // ...
	
	$errors = "";
	
	// check that all the validation tests passed before going to the database:
	if ($errors == "")
	{		
		// read their username from the session:
		$username = $_SESSION["username"];
		
		// now write the new data to our database table...
		
		// check to see if this user already had a favourite:
		$query = "SELECT * FROM users WHERE username='$username'";
		
		// this query can return data ($result is an identifier):
		$result = mysqli_query($connection, $query);
		
		// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
		$n = mysqli_num_rows($result);
			
		// if there was a match then UPDATE their profile data, otherwise INSERT it:
		if ($n > 0)
		{
			// we need an UPDATE:
			$query = "UPDATE users SET email='$email' WHERE username='$username'";
			$result = mysqli_query($connection, $query);		
		}
	

		// no data returned, we just test for true(success)/false(failure):
		if ($result) 
		{
			// show a successful update message:
			$message = "Profile successfully updated<br>";
		} 
		else
		{
			// show the set profile form:
			$show_account_form = true;
			// show an unsuccessful update message:
			$message = "Update failed<br>";
		}
	}
	else
	{
		// validation failed, show the form again with guidance:
		$show_account_form = true;
		// show an unsuccessful update message:
		$message = "Update failed, please check the errors above and try again<br>";
	}
	
	// we're finished with the database, close the connection:
	mysqli_close($connection);

}

else
{
	// user has arrived at the page for the first time, show any data already in the table:
	
	// read the username from the session:
	$username = $_SESSION["username"];
	
	// now read their profile data from the table...
	
	// connect directly to our database (notice 4th argument):
	$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	// if the connection fails, we need to know, so allow this exit:
	if (!$connection)
	{
		die("Connection failed: " . $mysqli_connect_error);
	}
	
	// check for a row in our profiles table with a matching username:
	$query = "SELECT * FROM users WHERE username='$username'";
	
	// this query can return data ($result is an identifier):
	$result = mysqli_query($connection, $query);
	
	// how many rows came back? (can only be 1 or 0 because username is the primary key in our table):
	$n = mysqli_num_rows($result);
		
	// if there was a match then extract their profile data:
	if ($n > 0)
	{
		// use the identifier to fetch one row as an associative array (elements named after columns):
		$row = mysqli_fetch_assoc($result);
		// extract their profile data for use in the HTML:
		$email = $row['email'];

	}
	
	// show the set profile form:
	$show_account_form = true;
	
	// we're finished with the database, close the connection:
	mysqli_close($connection);
	
}

if ($show_account_form)
{
echo <<<_END

    <!-- CLIENT-SIDE VALIDATION MISSING -->
    
    <form action="account_set.php" method="post">
      Update your profile info:<br>
      Username: {$_SESSION['username']}
      <br>
      Email address: <input type="text" name="email" value="$email">
      <br>
      <input type="submit" value="Submit">
    </form>	
_END;
}

// display our message to the user:
echo $message;

// finish of the HTML for this page:
require_once "footer.php";
?>