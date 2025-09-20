<?php
session_start();
include('../includes/db_connect.php');

// Ensure only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Get the schedule ID from the URL
if (isset($_GET['id'])) {
    $schedule_id = intval($_GET['id']);

    // ✅ Update the vaccination status to "Completed"
    $sql = "UPDATE vaccinationschedules SET status = 'Completed' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $schedule_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Vaccination marked as completed!";
    } else {
        $_SESSION['error'] = "Error updating record: " . $conn->error;
    }

    // Redirect back to the schedule management page
    header("Location: manage_vaccination_schedules.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request!";
    header("Location: manage_vaccination_schedules.php");
    exit();
}
?>
