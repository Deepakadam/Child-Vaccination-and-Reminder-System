<?php
session_start();
include('../includes/db_connect.php');

// Ensure the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Fetch all scheduled vaccinations
$sql = "SELECT vaccinationschedules.id, 
               children.name AS child_name, 
               vaccines.vaccine_name AS vaccine_name, 
               vaccinationschedules.scheduled_date, 
               vaccinationschedules.status 
        FROM vaccinationschedules
        JOIN children ON vaccinationschedules.child_id = children.id
        JOIN vaccines ON vaccinationschedules.vaccine_id = vaccines.id";

$result = $conn->query($sql);

// ✅ Debugging: Check for SQL errors
if (!$result) {
    die("❌ SQL Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Vaccination Schedules</title>
    <style>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.25); 
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
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
        .status-scheduled {
            color: orange;
            font-weight: bold;
        }
        .status-completed {
            color: green;
            font-weight: bold;
        }
        .action-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: white;
            font-size: 14px;
            display: inline-block;
            text-align: center;
        }
        .mark-completed-btn {
            background-color: #28a745;
        }
        .delete-btn {
            background-color: #dc3545;
        }
        .action-btn:hover {
            opacity: 0.8;
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
    </style>
    <script>
        function confirmDelete(scheduleId) {
            if (confirm("Are you sure you want to delete this schedule?")) {
                window.location.href = "delete_vaccination_schedule.php?id=" + scheduleId;
            }
        }
    </script>
</head>
<body>

    <?php include 'navbar.php'; ?>  <!-- ✅ Navbar included inside <body> for proper rendering -->

    <div class="container">
        <h2>Manage Vaccination Schedules</h2>

        <table>
            <tr>
                <th>Child Name</th>
                <th>Vaccine Name</th>
                <th>Scheduled Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['child_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['vaccine_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['scheduled_date']); ?></td>
                    <td class="<?php echo $row['status'] == 'Scheduled' ? 'status-scheduled' : 'status-completed'; ?>">
                        <?php echo $row['status'] == 'Scheduled' ? "⏳ Scheduled" : "✔ Completed"; ?>
                    </td>
                    <td>
                        <?php if ($row['status'] == 'Scheduled') { ?>
                            <a href="mark_vaccination_completed.php?id=<?php echo $row['id']; ?>" class="action-btn mark-completed-btn">
                                Mark Completed
                            </a>
                        <?php } ?>
                        <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id']; ?>)" class="action-btn delete-btn">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>
