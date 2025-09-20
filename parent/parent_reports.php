<?php
session_start();
include('../includes/db_connect.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'parent') {
    header('Location: ../login.php');
    exit();
}

$parent_id = $_SESSION['user_id'];

$sql = "SELECT c.id AS child_id, c.name AS child_name, c.dob, v.vaccine_name, vs.scheduled_date, vs.status
        FROM children c
        JOIN vaccinationschedules vs ON c.id = vs.child_id
        JOIN vaccines v ON vs.vaccine_id = v.id
        WHERE c.parent_id = ? 
        ORDER BY c.id, vs.scheduled_date";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $parent_id);
$stmt->execute();
$result = $stmt->get_result();

$children = [];
while ($row = $result->fetch_assoc()) {
    $children[$row['child_id']]['name'] = $row['child_name'];
    $children[$row['child_id']]['dob'] = $row['dob'];
    $children[$row['child_id']]['vaccinations'][] = $row;
}
include('navbar.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccination Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 20px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin: 100px auto 20px; 
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        h3 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        .status {
            font-weight: bold;
        }
        .completed {
            color: green;
        }
        .pending {
            color: orange;
        }
        .download-btn {
            display: block;
            width: fit-content;
            margin: 10px auto;
            padding: 10px 16px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .download-btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Vaccination Report</h2>

    <?php foreach ($children as $child_id => $child): ?>
        <h3><?= htmlspecialchars($child['name']) ?> (DOB: <?= date("d M Y", strtotime($child['dob'])) ?>)</h3>
        <table>
            <thead>
                <tr>
                    <th>Vaccine Name</th>
                    <th>Scheduled Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($child['vaccinations'] as $vaccine): ?>
                    <tr>
                        <td><?= htmlspecialchars($vaccine['vaccine_name']) ?></td>
                        <td><?= date("d M Y", strtotime($vaccine['scheduled_date'])) ?></td>
                        <td class="status <?= ($vaccine['status'] == 'Completed') ? 'completed' : 'pending'; ?>">
                            <?= ($vaccine['status'] == 'Completed') ? '✅ Completed' : '⏳ Pending'; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="generate_report.php?child_id=<?= $child_id ?>" class="download-btn">Download Report for <?= htmlspecialchars($child['name']) ?></a>
    <?php endforeach; ?>
</div>

</body>
</html>
