<?php
include('../includes/db_connect.php');

$child_id = isset($_GET['child_id']) ? intval($_GET['child_id']) : 0;

if ($child_id > 0) {
    $query = "SELECT period, vaccine_name, schedule_date FROM vaccinationschedules WHERE child_id = ? ORDER BY schedule_date ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $child_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $vaccination_data = [];
    while ($row = $result->fetch_assoc()) {
        $vaccination_data[$row['period']][] = [
            'vaccine_name' => $row['vaccine_name'],
            'schedule_date' => date("d-m-Y", strtotime($row['schedule_date'])) // Format date as DD-MM-YYYY
        ];
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Child Vaccination Schedule</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #f4f4f4; }
        h2 { text-align: center; }
    </style>
</head>
<body>

<h2>Vaccination Schedule</h2>

<table>
    <tr>
        <th>Period</th>
        <th>Vaccines</th>
        <th>Your Date</th>
    </tr>
    <?php if (!empty($vaccination_data)): ?>
        <?php foreach ($vaccination_data as $period => $vaccines): ?>
            <tr>
                <td rowspan="<?= count($vaccines) ?>"><?= $period ?></td>
                <td><?= $vaccines[0]['vaccine_name'] ?></td>
                <td><?= $vaccines[0]['schedule_date'] ?></td>
            </tr>
            <?php for ($i = 1; $i < count($vaccines); $i++): ?>
                <tr>
                    <td><?= $vaccines[$i]['vaccine_name'] ?></td>
                    <td><?= $vaccines[$i]['schedule_date'] ?></td>
                </tr>
            <?php endfor; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="3">No vaccination schedule found.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>
