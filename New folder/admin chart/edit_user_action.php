<?php
include('../includes/db_connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    // $role = $_POST['role'];

    // Update the user data in the database
    $sql = "UPDATE Users SET name = '$username' WHERE id = $user_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the manage users page after successful update
        header("Location: manage_users.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
