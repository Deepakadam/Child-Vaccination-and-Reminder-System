<?php
session_start();
include('../includes/db_connect.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

if (isset($_GET['child_id'])) {
    $child_id = $_GET['child_id'];

    // ✅ Fetch child details
    $child_query = "SELECT name, dob FROM children WHERE id = ?";
    $stmt = $conn->prepare($child_query);
    $stmt->bind_param("i", $child_id);
    $stmt->execute();
    $child_result = $stmt->get_result();

    if ($child_result->num_rows > 0) {
        $child = $child_result->fetch_assoc();

        $dob = new DateTime($child['dob']);
        $today = new DateTime();
        $age_in_months = $dob->diff($today)->m + ($dob->diff($today)->y * 12);

        // ✅ Fetch all vaccines with the correct vaccination status
        $query = "
        SELECT 
            v.id AS vaccine_id, 
            v.vaccine_name, 
            v.age_group, 
            v.age_in_months, 
            IFNULL(s.status, 'Upcoming') AS status, 
            s.scheduled_date 
        FROM vaccines v
        LEFT JOIN vaccinationschedules s 
            ON v.id = s.vaccine_id AND s.child_id = ?
        ORDER BY v.age_in_months ASC";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $child_id);
        $stmt->execute();
        $vaccine_result = $stmt->get_result();
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
            max-width: 1000px;
            margin: 100px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            font-size: 28px;
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
        .status-completed {
            color: green;
            font-weight: bold;
        }
        .status-upcoming {
            color: orange;
            font-weight: bold;
        }
        .status-scheduled {
            color: blue;
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

    </style>
</head>
<body>

<div class="container">
    <h2>Vaccination Chart for <?= htmlspecialchars($child['name']) ?></h2>
    <p>DOB: <?= htmlspecialchars($child['dob']) ?> | Age: <?= $age_in_months ?> months</p>

    <table>
        <tr>
            <th>Vaccine Name</th>
            <th>Age Group</th>
            <th>Due Age (Months)</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $vaccine_result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['vaccine_name']) ?></td>
                <td><?= htmlspecialchars($row['age_group']) ?></td>
                <td><?= $row['age_in_months'] ?> months</td>
                <td>
                    <?php
                    $due_age = $row['age_in_months'];
                    $status = $row['status'];
                    $scheduled_date = $row['scheduled_date'];

                    // ✅ Display correct status with completed, scheduled, and upcoming
                    if ($status == 'Completed') {
                        echo "<span class='status-completed'>✅ Completed</span>";
                    } elseif (!empty($scheduled_date) && $today >= new DateTime($scheduled_date)) {
                        echo "<span class='status-completed'>✅ Completed</span>";
                    } elseif ($age_in_months >= $due_age) {
                        echo "<span class='status-completed'>✅ Completed</span>";
                    } else {
                        echo "<span class='status-upcoming'>⏳ Upcoming</span>";
                    }
                    ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="manage_children.php" class="back-btn">Back to Child List</a>
</div>

</body>
</html>
