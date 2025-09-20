<?php
include('../includes/db_connect.php');

// Check if 'id' and 'confirm' are passed via GET
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    $user_id = $_GET['id'];

    // Delete the user from the Users table
    $sql = "DELETE FROM Users WHERE id = $user_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to manage users page after successful deletion
        header("Location: manage_users.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    // Redirect to the manage users page if the deletion is canceled or invalid request
    header("Location: manage_users.php");
    exit();
}
?>
