<?php
session_start();
include('../includes/db_connect.php');

// Ensure the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Check if schedule ID is provided
if (!isset($_GET['id'])) {
    die("❌ Error: No schedule ID provided.");
}

$schedule_id = $_GET['id'];  // Get schedule ID from URL

// Delete vaccination schedule from the database
$sql = "DELETE FROM vaccinationschedules WHERE id = $schedule_id";

if ($conn->query($sql) === TRUE) {
    header("Location: manage_vaccination_schedules.php?message=Vaccination schedule deleted successfully");
    exit();
} else {
    die("❌ SQL Error: " . $conn->error);
}
?>
