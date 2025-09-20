<?php
session_start();
include('../includes/db_connect.php');

// Ensure the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Check if child ID is provided
if (!isset($_GET['id'])) {
    die("❌ Error: No child ID provided.");
}

$child_id = $_GET['id'];  // Get child ID from URL

// Fetch child details (for confirmation)
$sql = "SELECT * FROM Children WHERE id = $child_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("❌ Error: Child not found.");
}
$child = $result->fetch_assoc();

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Child</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #dc3545;
        }
        p {
            font-size: 16px;
            color: #333;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            display: inline-block;
            margin: 10px;
        }
        .delete-btn {
            background-color: #dc3545;
            color: white;
        }
        .cancel-btn {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Confirm Delete</h2>
        <p>Are you sure you want to delete <strong><?php echo $child['name']; ?></strong>?</p>
        
        <a href="delete_child_action.php?id=<?php echo $child_id; ?>" class="btn delete-btn">Yes, Delete</a>
        <a href="manage_children.php" class="btn cancel-btn">Cancel</a>
    </div>

</body>
</html>
