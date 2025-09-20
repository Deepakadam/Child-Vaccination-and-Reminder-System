<?php
include ('../includes/db_connect.php');

if (!isset($_GET['child_id']) || !isset($_GET['age'])) {
    echo "<option value=''>Invalid request</option>";
    exit;
}

$child_id = intval($_GET['child_id']);  // Convert to integer for security
$age = intval($_GET['age']);

$sql = "SELECT v.vaccine_name FROM vaccines v
        WHERE v.age_in_months <= ?
        AND NOT EXISTS (
            SELECT 1 FROM vaccinationschedules vs WHERE vs.child_id = ? AND vs.vaccine_name = v.vaccine_name
        )";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing query: " . $conn->error);
}
$stmt->bind_param("ii", $age, $child_id);
$stmt->execute();
$result = $stmt->get_result();

$vaccineOptions = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $vaccineOptions .= "<option value='{$row['vaccine_name']}'>{$row['vaccine_name']}</option>";
    }
} else {
    $vaccineOptions = "<option value=''>No vaccines available</option>";
}

echo $vaccineOptions;
$stmt->close();
$conn->close();
?>
