<?php

// Things to notice:
// This file is the first one we will run when we mark your submission
// Its job is to: 
// Create your database (currently called "skeleton", see credentials.php)... 
// Create all the tables you will need inside your database (currently it makes a simple "users" table, you will probably need more and will want to expand fields in the users table to meet the assignment specification)... 
// Create suitable test data for each of those tables 
// NOTE: this last one is VERY IMPORTANT - you need to include test data that enables the markers to test all of your site's functionality

// read in the details of our MySQL server:
require_once "credentials.php";

// We'll use the procedural (rather than object oriented) mysqli calls

// connect to the host:
$connection = mysqli_connect($dbhost, $dbuser, $dbpass);

// exit the script with a useful message if there was an error:
if (!$connection)
{
	die("Connection failed: " . $mysqli_connect_error);
}
  
// build a statement to create a new database:
$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Database created successfully, or already exists<br>";
} 
else
{
	die("Error creating database: " . mysqli_error($connection));
}

// connect to our database:
mysqli_select_db($connection, $dbname);

///////////////////////////////////////////
////////////// USERS TABLE //////////////
///////////////////////////////////////////

// if there's an old version of our table, then drop it:
$sql = "DROP TABLE IF EXISTS users";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Dropped existing table: users<br>";
}

else 
{	
	die("Error checking for existing table: " . mysqli_error($connection));
}

// make our table:
// notice that the username field is a PRIMARY KEY and so must be unique in each record
$sql = "CREATE TABLE users (username VARCHAR(16), password VARCHAR(16), email VARCHAR(64), PRIMARY KEY(username))";

// no data returned, we just test for true(success)/false(failure):
if (mysqli_query($connection, $sql)) 
{
	echo "Table created successfully: users<br>";
}

else 
{
	die("Error creating table: " . mysqli_error($connection));
}

// put some data in our table:
// create an array variable for each field in the DB that we want to populate
$usernames[] = 'barrym'; $passwords[] = 'letmein'; $emails[] = 'barry@m-domain.com';
$usernames[] = 'mandyb'; $passwords[] = 'abc123'; $emails[] = 'webmaster@mandy-g.co.uk';
$usernames[] = 'timmy'; $passwords[] = 'secret95'; $emails[] = 'timmy@lassie.com';
$usernames[] = 'briang'; $passwords[] = 'password'; $emails[] = 'brian@quahog.gov';
$usernames[] = 'a'; $passwords[] = 'test'; $emails[] = 'a@alphabet.test.com';
$usernames[] = 'b'; $passwords[] = 'test'; $emails[] = 'b@alphabet.test.com';
$usernames[] = 'c'; $passwords[] = 'test'; $emails[] = 'c@alphabet.test.com';
$usernames[] = 'd'; $passwords[] = 'test'; $emails[] = 'd@alphabet.test.com';

// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($usernames); $i++)
{
	// create the SQL query to be executed
    $sql = "INSERT INTO users (username, password, email) VALUES ('$usernames[$i]', '$passwords[$i]', '$emails[$i]')";
	
	// run the above query '$sql' on our DB
    // no data returned, we just test for true(success)/false(failure):
	if (mysqli_query($connection, $sql)) 
	{
		echo "row inserted<br>";
	}

	else 
	{
		die("Error inserting row: " . mysqli_error($connection));
	}
}


// we're finished, close the connection:
mysqli_close($connection);
?>