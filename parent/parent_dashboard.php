<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        
            body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    /* background: url('img4.avif') no-repeat center center fixed; */
    background-size: contain; /* Ensures the entire image fits */
}


        .navbar {
            background: #007bff;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 {
            color: white;
            margin: 0;
            padding-left: 20px;
        }
        .nav-links {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }
        .nav-links li {
            margin: 0 15px;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
        }
        .nav-links a:hover {
            background: #0056b3;
            border-radius: 5px;
        }
        .logout-btn {
            background: red;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 20px;
        }
        .container {
            display: flex;
            justify-content: center;
            margin-top: 100px;
        }
        .dashboard {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            width: 60%;
        }
        .cards {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 200px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: 0.3s;
        }
        .card:hover {
            background: #007bff;
            color: white;
        }
        .card a {
            text-decoration: none;
            color: inherit;
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>Parent Dashboard</h1>
        <!-- <ul class="nav-links">
            <li><a href="#">Add Child</a></li>
            <li><a href="#">View & Edit Child</a></li>
            <li><a href="#">Vaccination Schedule</a></li>
        </ul> -->
        <a href="/VACCINATION_SYSTEM/login.php" class="logout-btn">Logout</a>
        <!-- <a href="parent_reports.php" class="logout-btn">report</a> -->
    </nav>

    <div class="container">
        <div class="dashboard">
            <h2>Welcome, Parent</h2>
            <p>Manage your child's vaccination records easily.</p>
            <div class="cards">
                <div class="card">
                    <i class="fas fa-user-plus fa-2x"></i>
                    <a href="/VACCINATION_SYSTEM/parent/add_child.php">Add Child</a>
                </div>
                <div class="card">
                    <i class="fas fa-notes-medical fa-2x"></i> <!-- Medical notes icon -->
                    <a href="parent_reports.php">Vaccination Report</a>
                </div>
                <div class="card">
                    <i class="fas fa-syringe fa-2x"></i>
                    <a href="manage_children.php">Vaccination Schedule</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
