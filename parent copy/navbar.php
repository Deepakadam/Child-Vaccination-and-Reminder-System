<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background.jpg'); /* Add your background image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: white;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 70px;
        }
        .navbar .btn, 
        .navbar .nav-link {
            font-size: 18px;
            padding: 15px 20px;
        }
        .dashboard-container {
            margin-top: 100px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="btn btn-primary me-3" href="parent_dashboard.php">Parent Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="view_child_details.php">My Children</a></li>
                <li class="nav-item"><a class="nav-link" href="view_vaccination_schedule.php">Vaccination Schedule</a></li>
                <li class="nav-item"><a class="nav-link" href="vaccination_history.php">Vaccination History</a></li>
                <li class="nav-item"><a class="nav-link" href="reminder_settings.php">Set Reminders</a></li>
                <a class="nav-link btn btn-danger text-white" href="logout.php">Logout</a>
            </ul>
        </div>
    </div>
</nav>

<!-- Dashboard Content -->
<div class="container dashboard-container">
    <h2 class="text-center mb-4">Welcome to Parent Dashboard</h2>
    
    <div class="row">
        <!-- Total Children Card -->
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h4>Total Children</h4>
                <p>2 children registered</p>
                <a href="view_child_details.php" class="btn btn-primary">View Details</a>
            </div>
        </div>

        <!-- Upcoming Vaccinations Card -->
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h4>Upcoming Vaccinations</h4>
                <p>3 vaccinations scheduled</p>
                <a href="view_vaccination_schedule.php" class="btn btn-success">View Schedule</a>
            </div>
        </div>

        <!-- Vaccination History Card -->
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h4>Vaccination History</h4>
                <p>5 vaccinations completed</p>
                <a href="vaccination_history.php" class="btn btn-warning">View History</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
