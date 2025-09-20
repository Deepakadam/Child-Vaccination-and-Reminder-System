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
            width: 90%;
            max-width: 500px;
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

        /* Heading & Text Styling */
        h2 {
            color: #dc3545;
            font-size: 28px;
            margin-bottom: 15px;
        }

        p {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }

        strong {
            color: #007bff;
        }

        /* Button Styling */
        .btn {
            display: inline-block;
            padding: 12px 30px;
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

            .btn {
                padding: 10px 20px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Are you sure you want to delete this user?</h2>
    <p><strong>Username:</strong> <?php echo $user['name']; ?></p>
    <p><strong>Role:</strong> <?php echo $user['role']; ?></p>

    <a href="delete_user_action.php?id=<?php echo $user['id']; ?>&confirm=yes" class="btn delete-btn">Yes, Delete User</a>
    <a href="manage_users.php" class="btn cancel-btn">No, Cancel</a>
</div>

</body>
</html>
