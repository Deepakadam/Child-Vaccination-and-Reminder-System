<?php
session_start();
include('../includes/db_connect.php');

// Ensure the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Function to check SQL execution
function checkQuery($result, $conn) {
    if (!$result) {
        die("SQL Error: " . $conn->error);
    }
    return $result;
}

// Get total vaccinations
$sql_total = "SELECT COUNT(*) AS total FROM vaccinationschedules";
$result_total = checkQuery($conn->query($sql_total), $conn);
$total_vaccinations = $result_total->fetch_assoc()['total'];

// Get completed vaccinations
$sql_completed = "SELECT COUNT(*) AS completed FROM vaccinationschedules WHERE status = 'Completed'";
$result_completed = checkQuery($conn->query($sql_completed), $conn);
$completed_vaccinations = $result_completed->fetch_assoc()['completed'];

// Get pending vaccinations count
$pending_vaccinations = $total_vaccinations - $completed_vaccinations;

// Fetch pending vaccination details
$sql_pending = "SELECT vaccinationschedules.id, children.name AS child_name, 
               vaccines.name AS vaccine_name, vaccinationschedules.scheduled_date 
               FROM vaccinationschedules 
               JOIN children ON vaccinationschedules.child_id = children.id 
               JOIN vaccines ON vaccinationschedules.vaccine_id = vaccines.id
               WHERE vaccinationschedules.status = 'Scheduled'";
$result_pending = checkQuery($conn->query($sql_pending), $conn);

// Fetch completed vaccination details
$sql_done = "SELECT vaccinationschedules.id, children.name AS child_name, 
               vaccines.name AS vaccine_name, vaccinationschedules.scheduled_date 
               FROM vaccinationschedules 
               JOIN children ON vaccinationschedules.child_id = children.id 
               JOIN vaccines ON vaccinationschedules.vaccine_id = vaccines.id
               WHERE vaccinationschedules.status = 'Completed'";
$result_done = checkQuery($conn->query($sql_done), $conn);

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccination Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }
         .container {
            max-width: 900px;
            margin: 100px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        } 
        /* .container {
            max-width: 900px;
            position: absolute;
            top: 50%;
            left: 50%;
            margin: auto;
            transform: translate(-50%, -50%);
            background-color: rgba(20, 7, 7, 0.25); 
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }  */
        h2 {
            text-align: center;
            color: #333;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .stat-box {
            padding: 20px;
            background-color: #007bff;
            color: white;
            border-radius: 10px;
            text-align: center;
            width: 30%;
        }
        .table-container {
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .pending {
            color: orange;
        }
        .completed {
            color: green;
        }
        .navbar-nav .nav-link {
    color: black !important; /* Ensure text is visible */
    font-weight: 500;
    padding: 10px 15px;
}

.navbar-nav .nav-link:hover,
.navbar-nav .nav-link.active {
    color: white !important; /* White text for active/hovered links */
    background-color: #28a745 !important; /* Green background */
    border-radius: 5px;
}

.navbar-nav .nav-item .nav-link.text-danger:hover {
    background-color: #dc3545 !important; /* Keep logout red */
}

    </style>
</head>
<body>

    <div class="container">
        <h2>Vaccination Reports</h2>

        <div class="stats">
            <div class="stat-box">
                <h3>Total Vaccinations</h3>
                <p><?php echo $total_vaccinations; ?></p>
            </div>
            <div class="stat-box" style="background-color: #28a745;">
                <h3>Completed</h3>
                <p><?php echo $completed_vaccinations; ?></p>
            </div>
            <div class="stat-box" style="background-color: #ffc107;">
                <h3>Pending</h3>
                <p><?php echo $pending_vaccinations; ?></p>
            </div>
        </div>

        <div class="table-container">
            <h3>Pending Vaccinations</h3>
            <table>
                <tr>
                    <th>Child Name</th>
                    <th>Vaccine Name</th>
                    <th>Scheduled Date</th>
                </tr>
                <?php while ($row = $result_pending->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['child_name']; ?></td>
                        <td><?php echo $row['vaccine_name']; ?></td>
                        <td class="pending"><?php echo $row['scheduled_date']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <div class="table-container">
            <h3>Completed Vaccinations</h3>
            <table>
                <tr>
                    <th>Child Name</th>
                    <th>Vaccine Name</th>
                    <th>Scheduled Date</th>
                </tr>
                <?php while ($row = $result_done->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['child_name']; ?></td>
                        <td><?php echo $row['vaccine_name']; ?></td>
                        <td class="completed"><?php echo $row['scheduled_date']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

</body>
</html>