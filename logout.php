<?php 

    // First we execute our common code to connection to the database and start the session 
    require("app/connect.php"); 
     
    // We remove the user's data from the session 
    unset($_SESSION['user']); 
     
    // Destroy Cookies
    setcookie('username', '', time() - 1*24*60*60);
	setcookie('token', '', time() - 1*24*60*60);
	setcookie('ball', '', time() - 1*24*60*60);

    // We redirect them to the login page 
    header("Location: index.php"); 
    die("Redirecting to: index.php");