<?php

// Things to notice:
// The main job of this script is to end the user's session
// Meaning we want to destroy the current session data

// execute the header script:
require_once "header.php";

// checks the session variable named 'loggedInSkeleton'
// take note that of the '!' (NOT operator) that precedes the 'isset' function
if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
}

// the user must be signed-in, proceed with ending the session
// and clearing session cookies and any others you may have added
else
{
	// user just clicked to logout, so destroy the session data:
	// first clear the session superglobal array:
	$_SESSION = array();
	// then the cookie that holds the session ID:
	setcookie(session_name(), "", time() - 2592000, '/');
	// then the session data on the server:
	session_destroy();

	echo "You have successfully logged out, please <a href='sign_in.php'>click here</a><br>";
}

// finish of the HTML for this page:
require_once "footer.php";

?>