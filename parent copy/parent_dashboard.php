<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('ch.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        /* Navbar Styling */
        .navbar {
            background-color: #007bff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }
        .navbar-nav .nav-link {
            color: white;
            font-size: 18px;
            margin-right: 15px;
        }
        .navbar-nav .nav-link:hover {
            color: #f8f9fa;
        }
        .btn-logout {
            background-color: #dc3545;
            color: white;
        }
        .btn-logout:hover {
            background-color: #c82333;
        }
        /* Dashboard Container */
        .dashboard-container {
            max-width: 500px;
            margin: 120px auto 50px; /* Adjusted for navbar */
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .child-btn {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            font-weight: 500;
            border-radius: 8px;
            margin-bottom: 15px;
            transition: 0.3s;
        }
        .child-btn:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<!-- ✅ Parent Dashboard Navbar (Like Admin Panel) -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="parent_dashboard.php">Parent Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="view_vaccination_schedule.php">View Vaccinations</a></li>
                <li class="nav-item"><a class="nav-link" href="add_child.php">Add Child</a></li>
                <li class="nav-item"><a class="nav-link" href="vaccination_history.php">Vaccination History</a></li>
                <li class="nav-item"><a class="nav-link btn btn-logout text-white" href="/VACCINATION_SYSTEM/login.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- ✅ Parent Dashboard -->
<div class="dashboard-container">
    <h3 class="mb-3">👨‍👩‍👧 Welcome, Parent</h3>
    <h5 class="text-muted">Your Child</h5>
    
    <button class="btn btn-primary child-btn">Sonu (2021-12-02)</button>
    <button class="btn btn-primary child-btn">Ritu (2020-05-12)</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
