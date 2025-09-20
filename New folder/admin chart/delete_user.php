<?php
include('../includes/db_connect.php');

// Check if 'id' is passed via GET
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch user data (to show name or other details in confirmation)
    $sql = "SELECT * FROM Users WHERE id = $user_id";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Deletion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            width: 40%;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        .confirmation-buttons {
            text-align: center;
        }
        .confirmation-buttons a {
            display: inline-block;
            margin: 10px;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .confirmation-buttons a:hover {
            background-color: #218838;
        }
        .confirmation-buttons a.cancel {
            background-color: #dc3545;
        }
        .confirmation-buttons a.cancel:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Are you sure you want to delete this user?</h2>
        <p><strong>Username:</strong> <?php echo $user['name']; ?></p>
        <p><strong>Role:</strong> <?php echo $user['role']; ?></p>

        <div class="confirmation-buttons">
            <a href="delete_user_action.php?id=<?php echo $user['id']; ?>&confirm=yes">Yes, Delete User</a>
            <a href="manage_users.php" class="cancel">No, Cancel</a>
        </div>
    </div>

</body>
</html>
