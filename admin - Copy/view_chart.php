<?php
session_start();
include('../includes/db_connect.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Get the child's ID from the URL
if (isset($_GET['child_id'])) {
    $child_id = $_GET['child_id'];

    // Fetch child details
    $child_query = "SELECT name, dob FROM Children WHERE id = $child_id";
    $child_result = $conn->query($child_query);

    if ($child_result->num_rows > 0) {
        $child = $child_result->fetch_assoc();

        $dob = new DateTime($child['dob']);
        $today = new DateTime();
        $age_in_months = $dob->diff($today)->m + ($dob->diff($today)->y * 12);

        // Fetch vaccines based on the child's age
        $vaccine_query = "
            SELECT vaccine_name, age_group, age_in_months, 
            IF(age_in_months <= $age_in_months, '✅ Completed', '⏳ Upcoming') AS status 
            FROM vaccines
            ORDER BY age_in_months ASC";

        $vaccine_result = $conn->query($vaccine_query);
    } else {
        echo "Child not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vaccination Chart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 100px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            font-size: 26px;
            color: #333;
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
        .status-administered {
            color: green;
            font-weight: bold;
        }
        .status-upcoming {
            color: orange;
            font-weight: bold;
        }
        .back-btn {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-btn:hover {
            background-color: #218838;
        }
        /* Navbar Styles */
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

.navbar-nav .nav-item .nav-link.text-danger:hover {
    background-color: #dc3545 !important;
}
    </style>
</head>
<body>

<div class="container">
    <h2>Vaccination Chart for <?= $child['name'] ?></h2>
    <p>DOB: <?= $child['dob'] ?> | Age: <?= $age_in_months ?> months</p>

    <table>
        <tr>
            <th>Vaccine Name</th>
            <th>Age Group</th>
            <th>Due Age (Months)</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $vaccine_result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['vaccine_name'] ?></td>
            <td><?= $row['age_group'] ?></td>
            <td><?= $row['age_in_months'] ?> months</td>
            <td class="<?= ($row['status'] == '✅ Administered') ? 'status-administered' : 'status-upcoming' ?>">
                <?= $row['status'] ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="manage_children.php" class="back-btn">Back to Child List</a>
</div>

</body>
</html>
