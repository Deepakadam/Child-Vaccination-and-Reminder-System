<?php
include('../includes/db_connect.php');

// Check if 'id' is passed via GET
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch user data
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
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        /* .container {
            width: 50%;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        } */
        .container {
    width: 40%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(255, 255, 255, 0.25); /* Slight transparency */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-size: 16px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .form-footer {
            text-align: center;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-link:hover {
            background-color: #0056b3;
        }
        .navbar-nav .nav-link {
    color: black !important; /* Ensure text is visible */
    font-weight: 500;
    padding: 10px 15px;
}

.navbar-nav .nav-link:hover,
.navbar-nav .nav-link.active {
    color: white !important; /* White text for active/hovered links */
    background-color: #28a745 !important; /* Green background */
    border-radius: 5px;
}

    </style>
</head>
<body>

<div class="container">
        <h2>Edit User</h2>

        <form method="POST" action="edit_user_action.php">
            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

            <!-- Edit Username -->
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo $user['name']; ?>" required>

            <!-- Add Parent Specific Fields (phone and email) -->
            <?php if ($user['role'] == 'parent'): ?>
                <!-- Parent's Phone -->
                <label for="phone">Phone:</label>
                <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required>

                <!-- Parent's Email -->
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
            <?php endif; ?>

            <!-- Submit Button -->
            <input type="submit" value="Update User">
        </form>

        <div class="form-footer">
            <a href="manage_users.php" class="back-link">Back to User Management</a>
        </div>
    </div>

</body>
</html>