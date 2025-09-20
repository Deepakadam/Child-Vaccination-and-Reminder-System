
<?php
$servername = "localhost";
$username = "root";  // Default for WAMP
$password = "";      // Default for WAMP
$database = "vaccination_db"; // Change this to your database name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
