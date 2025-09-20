<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'navbar.php';
include '../includes/db_connect.php';

// Fetch total children registered
$childrenQuery = "SELECT COUNT(*) AS total_children FROM children";
$childrenResult = $conn->query($childrenQuery);
$totalChildren = ($childrenResult) ? $childrenResult->fetch_assoc()['total_children'] : 0;

// Fetch registered parents
$parentsQuery = "SELECT COUNT(*) AS parent_count FROM users WHERE role = 'parent'";
$parentsResult = $conn->query($parentsQuery);
$registeredParents = ($parentsResult) ? $parentsResult->fetch_assoc()['parent_count'] : 0;

// Fetch upcoming vaccinations
$vaccinationsQuery = "SELECT COUNT(*) AS upcoming_count FROM vaccinationschedules WHERE scheduled_date >= CURDATE()";
$vaccinationsResult = $conn->query($vaccinationsQuery);
$upcomingVaccinations = ($vaccinationsResult) ? $vaccinationsResult->fetch_assoc()['upcoming_count'] : 0;

// Fetch vaccination counts
$total_vaccines_query = "SELECT COUNT(*) AS total FROM vaccinationschedules";
$completed_vaccines_query = "SELECT COUNT(*) AS completed FROM vaccinationschedules WHERE status = 'Completed'";

$total_result = $conn->query($total_vaccines_query);
$completed_result = $conn->query($completed_vaccines_query);

$total_vaccines = ($total_result->num_rows > 0) ? $total_result->fetch_assoc()['total'] : 0;
$completed_vaccines = ($completed_result->num_rows > 0) ? $completed_result->fetch_assoc()['completed'] : 0;

$progress = ($total_vaccines > 0) ? round(($completed_vaccines / $total_vaccines) * 100) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('photo.avif');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            width: 100vw;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        /* Navbar styling */
        .navbar-nav .nav-link {
            color: black !important;
            font-weight: 500;
            padding: 10px 15px;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: white !important;
            background-color: #28a745 !important;
            border-radius: 5px;
        }

        .navbar-nav .text-danger:hover {
            background-color: #dc3545 !important;
        }
        
        /* Progress bar styles */
        .progress-container {
            text-align: center;
            margin-top: 20px;
        }
        .progress-bar {
            width: 80%;
            height: 25px;
            background-color: #ddd;
            border-radius: 12px;
            margin: auto;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background-color: #28a745;
            color: white;
            text-align: center;
            line-height: 25px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Vaccination Progress Bar -->
<div class="progress-container">
    <h3>📊 Vaccination Progress</h3>
    <div class="progress-bar">
        <div class="progress-fill" style="width: <?php echo $progress; ?>%;">
            <?php echo $progress; ?>%
        </div>
    </div>
</div>

<div class="container">
    <br><br>
    <div class="row">
        <!-- Total Children Registered -->
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Children</h5>
                <p><?php echo $totalChildren; ?> children registered</p>
                <a href="manage_children.php" class="btn btn-primary">View Details</a>
            </div>
        </div>

        <!-- Registered Parents -->
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Registered Parents</h5>
                <p><?php echo $registeredParents; ?> parents registered</p>
                <a href="manage_users.php" class="btn btn-primary">Manage Users</a>
            </div>
        </div>

        <!-- Upcoming Vaccinations -->
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Upcoming Vaccinations</h5>
                <p><?php echo $upcomingVaccinations; ?> vaccinations scheduled</p>
                <a href="manage_vaccination_schedules.php" class="btn btn-primary">View Schedule</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
