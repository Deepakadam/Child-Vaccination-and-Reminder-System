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

// Fetch schedule details for confirmation
$sql = "SELECT vaccinationschedules.id, 
               children.name AS child_name, 
               vaccines.vaccine_name AS vaccine_name, 
               vaccinationschedules.scheduled_date 
        FROM vaccinationschedules
        JOIN children ON vaccinationschedules.child_id = children.id
        JOIN vaccines ON vaccinationschedules.vaccine_id = vaccines.id
        WHERE vaccinationschedules.id = $schedule_id";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("❌ Error: Schedule not found.");
}

$schedule = $result->fetch_assoc();

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Vaccination Schedule</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #dc3545;
        }
        p {
            font-size: 16px;
            color: #333;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            display: inline-block;
            margin: 10px;
        }
        .delete-btn {
            background-color: #dc3545;
            color: white;
        }
        .cancel-btn {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Confirm Delete</h2>
        <p>Are you sure you want to delete the vaccination schedule for <strong><?php echo $schedule['child_name']; ?></strong> (<?php echo $schedule['vaccine_name']; ?> on <?php echo $schedule['scheduled_date']; ?>)?</p>
        
        <a href="delete_vaccination_schedule_action.php?id=<?php echo $schedule_id; ?>" class="btn delete-btn">Yes, Delete</a>
        <a href="manage_vaccination_schedules.php" class="btn cancel-btn">Cancel</a>
    </div>

</body>
</html>
