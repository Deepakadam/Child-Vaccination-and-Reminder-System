<?php
include('../includes/db_connect.php');

if (isset($_GET['age']) && isset($_GET['child_id'])) {
    $age_in_months = intval($_GET['age']);
    $child_id = intval($_GET['child_id']);

    $stmt = $conn->prepare("SELECT v.id, v.vaccine_name 
                            FROM vaccines v 
                            WHERE v.age_in_months > ?  -- Fetch only upcoming vaccines
                            AND NOT EXISTS (
                                SELECT 1 FROM vaccinationschedules vs 
                                WHERE vs.child_id = ? AND vs.vaccine_id = v.id
                            ) 
                            ORDER BY v.age_in_months ASC");
    $stmt->bind_param("ii", $age_in_months, $child_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<option value=''>Select a Vaccine</option>";
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['vaccine_name']}</option>";
    }

    $stmt->close();
} else {
    echo "<option>Error fetching vaccines</option>";
}

$conn->close();
?>
