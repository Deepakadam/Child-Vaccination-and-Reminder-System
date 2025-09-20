<?php
include '../includes/db_connect.php';

$from_date = isset($_POST['from_date']) ? $_POST['from_date'] : "";
$to_date = isset($_POST['to_date']) ? $_POST['to_date'] : "";

// Fetch all vaccination records with or without date filter
$query = "SELECT c.name AS child_name, v.vaccine_name, vs.scheduled_date, vs.status 
          FROM vaccinationschedules vs
          JOIN children c ON vs.child_id = c.id
          JOIN vaccines v ON vs.vaccine_id = v.id";

if (!empty($from_date) && !empty($to_date)) {
    $query .= " WHERE vs.scheduled_date BETWEEN '$from_date' AND '$to_date'";
}

$query .= " ORDER BY c.name, vs.scheduled_date";
$result = mysqli_query($conn, $query);

// Prepare data for structured display
$children = [];
while ($row = mysqli_fetch_assoc($result)) {
    $children[$row['child_name']][] = $row;
}
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccination Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-danger fw-bold">
        <i class="fas fa-syringe"></i> Vaccination Report
    </h2>

    <!-- Date Filter -->
    <form method="POST" class="row g-3">
        <div class="col-md-3">
            <label class="form-label fw-bold">From:</label>
            <input type="date" class="form-control" name="from_date" value="<?= $from_date ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-bold">To:</label>
            <input type="date" class="form-control" name="to_date" value="<?= $to_date ?>">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Apply Filter</button>
        </div>
    </form>

    <hr>

    <!-- Vaccination Summary -->
    <div class="d-flex justify-content-between">
        <h5 class="text-dark">Total Vaccinations: <b><?= mysqli_num_rows($result) ?></b></h5>
        <h5 class="text-success">✔ Completed: <b><?= count(array_filter($children, fn($child) => in_array('Completed', array_column($child, 'status')))) ?></b></h5>
        <h5 class="text-warning">⏳ Scheduled: <b><?= count(array_filter($children, fn($child) => in_array('Scheduled', array_column($child, 'status')))) ?></b></h5>
    </div>

    <hr>

    <!-- Vaccination Report -->
    <?php foreach ($children as $child_name => $records) : ?>
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">👶 <?= $child_name ?></h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Vaccine Name</th>
                            <th>Scheduled Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($records as $record) : ?>
                            <tr>
                                <td><?= $record['vaccine_name'] ?></td>
                                <td><?= date("d-m-Y", strtotime($record['scheduled_date'])) ?></td>
                                <td>
                                    <?php if ($record['status'] == 'Completed') : ?>
                                        <span class="badge bg-success">✔ Completed</span>
                                    <?php else : ?>
                                        <span class="badge bg-warning text-dark">⏳ Scheduled</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button class="btn btn-danger download-report" data-child="<?= $child_name ?>">📥 Download Report</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- JavaScript for Download Report -->
<script>
    $(document).ready(function () {
        $(".download-report").click(function () {
            var childName = $(this).data("child");
            window.location.href = "download_report.php?child=" + encodeURIComponent(childName);
        });
    });
</script>

</body>
</html>
