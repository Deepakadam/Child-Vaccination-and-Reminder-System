<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$parent_id = isset($_SESSION['parent_id']) ? $_SESSION['parent_id'] : 0;  // Ensure ID exists
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/navbar.css"> <!-- External CSS -->
    <title>Navbar</title>
    <style>
        /* Reset margin and padding */
        body, html {
            margin: 0;
            padding: 0;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #007bff;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            font-family: Arial, sans-serif;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
        }
        
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .logout {
            background-color: red;
            padding: 8px 15px;
            border-radius: 5px;
        }

        .logout:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div>
        <a href="../parent/parent_dashboard.php?id=<?= $parent_id ?>">🏠 Home</a>
        <a href="../parent/manage_children.php?parent_id=<?= $parent_id ?>">👶 My Children</a>
        <a href="../parent/parent_reports.php?parent_id=<?= $parent_id ?>">📄 Report</a> <!-- Added Report Icon -->
        <!-- <a href="/VACCINATION_SYSTEM/parent/parent_reports.php">Report</a> -->
    </div>
    <div>
        <a href="../login.php" class="logout">🚪 Logout</a>
    </div>
</nav>

</body>
</html>
