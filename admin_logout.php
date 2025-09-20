<?php
session_start(); // Start the session

// Destroy all session variables
session_unset();  // Clears the session variables
session_destroy(); // Destroys the session

// Redirect to the login page
header("Location: login.php");
exit();
?>
