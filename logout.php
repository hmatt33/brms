<?php
// This is the logout page for the site.
session_start();
//if no session variable then redirect the user to index (login page)
if (!isset($_SESSION['UserID'])) {
    header("location: index.php");
    exit();
} else { 
    //end the session
	$_SESSION = array(); //Destroy the variables
	session_destroy(); //Destroy the session
	setcookie('PHPSESSID', ", time()-3600,'/', ", 0, 0); //Destroy the cookie
	header("location: index.php");
	exit();
}
?>