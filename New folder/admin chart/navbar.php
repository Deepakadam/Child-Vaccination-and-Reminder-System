<?php
// Start session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            /* background-image:url('istockphoto2.jpg'); */
            background-size:contain;
            background-position:center;
            background-repeat:no-repeat;
            height: 100vh;
            width: 190w;
        
        }
        /* .navbar {
            background-color: #ffffff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            
        } */
         /* Fix Navbar at the Top */
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background-color: white; /* Adjust if needed */
    z-index: 1000; /* Ensures navbar stays above content */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Optional shadow */
}

        .navbar-brand {
            font-weight: bold;
        }
        .nav-link {
            color: #333 !important;
        }
        .nav-link:hover {
            color:rgb(242, 245, 248) !important;
        }
        .navbar {
    background-color: #ffffff;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    height: 70px; /* Adjust height as needed */
    display: flex;
    align-items: center;
}

.navbar .btn, 
.navbar .nav-link {
    font-size: 18px; /* Make text bigger if needed */
    padding: 15px 20px; /* Adjust padding for better spacing */
}

    </style>
</head>
<body>

<!-- <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="admin_dashboard.php">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="manage_users.php">Manage Users</a></li>
                <li class="nav-item"><a class="nav-link" href="manage_children.php">Manage Children</a></li>
                <li class="nav-item"><a class="nav-link" href="add_vaccination_schedule.php">Add Schedule</a></li>
                <li class="nav-item"><a class="nav-link" href="reports.php">Reports</a></li>
                <li class="nav-item"><a class="nav-link" href="manage_reminders.php">Manage Reminders</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="admin_logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav> -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="btn btn-success me-3" href="admin_dashboard.php">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto"> <!-- ✅ `ms-auto` pushes items to the right -->
                <li class="nav-item"><a class="nav-link" href="manage_users.php">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="manage_children.php">Children</a></li>
                <li class="nav-item"><a class="nav-link" href="add_vaccination_schedule.php">Add Schedule</a></li>
                <!-- <li class="nav-item"><a class="nav-link" href="reports.php">Reports</a></li> -->
                <!-- <li class="nav-item"><a class="nav-link" href="send_reminder.php">Reminders</a></li> -->
                <a class="nav-link btn btn-danger text-white" href="/VACCINATION_SYSTEM/logout.php">Logout</a>
                </ul>
        </div>
    </div>
</nav>
