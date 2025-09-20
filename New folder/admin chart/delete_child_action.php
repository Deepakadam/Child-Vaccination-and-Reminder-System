<?php
session_start();
include('../includes/db_connect.php');

// Ensure the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Check if child ID is provided
if (!isset($_GET['id'])) {
    die("❌ Error: No child ID provided.");
}

$child_id = $_GET['id'];  // Get child ID from URL

// Delete child from the database
$sql = "DELETE FROM Children WHERE id = $child_id";

if ($conn->query($sql) === TRUE) {
    header("Location: view_child.php?message=Child deleted successfully");
    exit();
} else {
    die("❌ SQL Error: " . $conn->error);
}
?>
