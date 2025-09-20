<?php
session_start();
include('../includes/db_connect.php');

$child_id = $_POST['child_id'];
$vaccine_id = $_POST['vaccine_id'];
$scheduled_date = $_POST['scheduled_date'];

// Validate inputs
if (empty($child_id) || empty($vaccine_id) || empty($scheduled_date)) {
    die("❌ Error: Missing required fields.");
}

// Fetch parent_id from the Children table
$sql_parent = "SELECT parent_id FROM children WHERE id = ?";
$stmt = $conn->prepare($sql_parent);
$stmt->bind_param("i", $child_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $parent_id = $row['parent_id'];
} else {
    die("❌ Error: Child not found.");
}

// Insert schedule with valid date format
$sql_insert = "INSERT INTO vaccinationschedules (child_id, vaccine_id, scheduled_date, parent_id, status) 
               VALUES (?, ?, ?, ?, 'Scheduled')";

$stmt = $conn->prepare($sql_insert);
if ($stmt === false) {
    die("❌ Error: " . $conn->error);
}

$stmt->bind_param("iisi", $child_id, $vaccine_id, $scheduled_date, $parent_id);

if ($stmt->execute()) {
    $today = date("Y-m-d");
    $remaining_days = (strtotime($scheduled_date) - strtotime($today)) / (60 * 60 * 24);
    $remaining_text = ($remaining_days > 0) ? "$remaining_days days remaining" : "Due today!";
} else {
    die("❌ Error: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccination Scheduled</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
        }
        h2 {
            color: #28a745;
        }
        p {
            font-size: 16px;
            color: #333;
            margin: 10px 0;
        }
        .info-box {
            background-color: #d4edda;
            padding: 10px;
            border-radius: 5px;
            color: #155724;
            font-weight: bold;
            margin-top: 15px;
        }
        .btn {
            display: inline-block;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            margin-top: 15px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>✅ Vaccination Scheduled Successfully!</h2>
    <p>Vaccination has been successfully scheduled for your child.</p>
    <div class="info-box">
        <p>📅 Scheduled Date: <strong><?php echo htmlspecialchars($scheduled_date); ?></strong></p>
        <p>⏳ <?php echo htmlspecialchars($remaining_text); ?></p>
    </div>
    <a href="manage_vaccination_schedules.php" class="btn">Back to Schedule</a>
</div>

</body>
</html>
