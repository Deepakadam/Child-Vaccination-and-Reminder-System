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
    /* Body Styling */
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(to right, #f4f6f9, #dbe9f4);
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Container Styling */
    .container {
        background: #ffffff;
        max-width: 450px;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: all 0.3s ease-in-out;
    }

    .container:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    /* Heading Styling */
    h2 {
        color: #dc3545;
        font-size: 28px;
        margin-bottom: 15px;
    }

    p {
        font-size: 18px;
        color: #555;
        margin-bottom: 30px;
    }

    strong {
        color: #007bff;
    }

    /* Button Styling */
    .btn {
        display: inline-block;
        padding: 12px 25px;
        font-size: 16px;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s;
        margin: 10px;
        border: none;
        cursor: pointer;
    }

    .delete-btn {
        background: #dc3545;
        color: #fff;
    }

    .delete-btn:hover {
        background: #c82333;
    }

    .cancel-btn {
        background: #007bff;
        color: #fff;
    }

    .cancel-btn:hover {
        background: #0056b3;
    }

    /* Responsive Design */
    @media (max-width: 600px) {
        .container {
            width: 90%;
            padding: 30px;
        }
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
