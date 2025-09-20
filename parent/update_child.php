<?php
session_start();
include('../includes/db_connect.php');

// Ensure the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'parent') {
    die("❌ Error: Access Denied. You are not an admin.");
}

// Debugging: Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging: Print received data
    echo "✅ Debug: Form received!<br>";
    echo "Child ID: " . $_POST['child_id'] . "<br>";
    echo "Name: " . $_POST['name'] . "<br>";
    echo "DOB: " . $_POST['dob'] . "<br>";
    echo "Gender: " . $_POST['gender'] . "<br>";
    echo "Parent ID: " . $_POST['parent_id'] . "<br>";

    // Get form data
    $child_id = $_POST['child_id'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $parent_id = $_POST['parent_id'];

    // Update query
    $sql = "UPDATE Children SET name='$name', dob='$dob', gender='$gender', parent_id='$parent_id' WHERE id='$child_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_children.php?message=Child updated successfully");
        exit();
    } else {
        die("❌ SQL Error: " . $conn->error);
    }
} else {
    die("❌ Error: Invalid request (Form not submitted).");
}
?>
