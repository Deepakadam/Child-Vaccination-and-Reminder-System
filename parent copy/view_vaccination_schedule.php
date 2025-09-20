<?php
session_start();
include('../includes/db_connect.php');

// Ensure the user is logged in as a parent
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'parent') {
    header('Location: ../login.php');
    exit();
}

// Get the child ID from the URL
if (!isset($_GET['child_id'])) {
    die("❌ Error: No child ID provided.");
}
$child_id = $_GET['child_id'];

// Fetch child details
$sql_child = "SELECT * FROM Children WHERE id = '$child_id' AND parent_id = '".$_SESSION['user_id']."'";
$result_child = $conn->query($sql_child);

if ($result_child->num_rows == 0) {
    die("❌ Error: Child not found.");
}
$child = $result_child->fetch_assoc();

// Fetch the child's vaccination schedule
$sql_vaccination = "SELECT * FROM VaccinationSchedules WHERE child_id = '$child_id'";
$result_vaccination = $conn->query($sql_vaccination);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccination Schedule</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        }
        .status-completed {
            color: green;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Vaccination Schedule for <?php echo $child['name']; ?></h2>

        <table>
            <tr>
                <th>Vaccine Name</th>
                <th>Scheduled Date</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result_vaccination->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['vaccine_name']; ?></td>
                    <td><?php echo $row['scheduled_date']; ?></td>
                    <td class="<?php echo $row['status'] == 'Scheduled' ? 'status-scheduled' : 'status-completed'; ?>">
                        <?php echo $row['status'] == 'Scheduled' ? "⏳ Scheduled" : "✔ Completed"; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <div style="text-align: center; margin-top: 20px;">
            <a href="parent_dashboard.php" style="background-color: #007bff; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">Back to Dashboard</a>
        </div>
    </div>

</body>
</html>
