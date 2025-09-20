<?php
session_start();
include('../includes/db_connect.php');

// Ensure admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Check if ID is provided
if (isset($_GET['id'])) {
    $schedule_id = intval($_GET['id']);

    // ✅ Update status to 'Completed'
    $sql = "UPDATE vaccinationschedules SET status = 'Completed' WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $schedule_id);
        if ($stmt->execute()) {
            // Redirect back with a success message
            header("Location: manage_vaccination_schedules.php?success=1");
            exit();
        } else {
            echo "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "❌ SQL preparation failed: " . $conn->error;
    }
} else {
    echo "❌ Invalid schedule ID.";
}

$conn->close();
?>
