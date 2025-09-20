<?php
session_start();
include('../includes/db_connect.php');

// Ensure the parent is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'parent') {
    header('Location: ../login.php');
    exit();
}

$parent_id = $_SESSION['user_id'];

// Validate child ID
if (!isset($_GET['child_id']) || !is_numeric($_GET['child_id'])) {
    echo "Invalid child ID.";
    exit();
}

$child_id = $_GET['child_id'];

// Verify that the child belongs to the logged-in parent
$child_query = "SELECT name FROM children WHERE id = ? AND parent_id = ?";
$stmt_child = $conn->prepare($child_query);
$stmt_child->bind_param("ii", $child_id, $parent_id);
$stmt_child->execute();
$child_result = $stmt_child->get_result();

if ($child_result->num_rows === 0) {
    echo "Unauthorized access or child not found.";
    exit();
}
$child = $child_result->fetch_assoc();
$child_name = htmlspecialchars($child['name']);

// Fetch vaccination schedule
$sql = "SELECT v.vaccine_name, vs.scheduled_date, vs.status 
        FROM vaccinationschedules vs
        JOIN vaccines v ON vs.vaccine_id = v.id
        WHERE vs.child_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $child_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<?php include('navbar.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccination Schedule - <?= $child_name ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px #ccc;
        }
        h2 {
            text-align: center;
            color: #007bff;
        }
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .back-btn:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #007bff;
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
    </style>
</head>
<body>

<div class="container">
    <a href="manage_children.php" class="back-btn">← Back</a>
    <h2>Vaccination Schedule for <?= $child_name ?></h2>

    <table>
        <thead>
            <tr>
                <th>Vaccine Name</th>
                <th>Scheduled Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['vaccine_name']) ?></td>
                    <td><?= date("d M Y", strtotime($row['scheduled_date'])) ?></td>
                    <td class="<?= $row['status'] == 'Scheduled' ? 'status-scheduled' : 'status-completed' ?>"><?= $row['status'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
