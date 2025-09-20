<?php
session_start();
include('../includes/db_connect.php');

// Ensure the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');  // Redirect to login page if not admin
    exit();
}

// Fetch all children along with parent names
$sql = "SELECT Children.id, Children.name, Children.dob, Children.gender, Users.name AS parent_name 
        FROM Children 
        LEFT JOIN Users ON Children.parent_id = Users.id";

$result = $conn->query($sql);

// Check if query failed
if (!$result) {
    die("❌ SQL Error: " . $conn->error);
}

include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Children</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 100px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            font-size: 26px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .action-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: white;
            font-size: 14px;
        }
        .edit-btn {
            background-color: #ffc107;
        }
        .delete-btn {
            background-color: #dc3545;
        }
         .navbar-nav .nav-link {
            color: black !important;
            font-weight: 500;
            padding: 10px 15px;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: white !important;
            background-color: #28a745 !important;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Children List</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Child Name</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Parent Name</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['dob']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['parent_name'] ? $row['parent_name'] : 'No Parent Assigned'; ?></td>
                    <td>
    <a href="edit_child.php?id=<?php echo $row['id']; ?>" class="action-btn edit-btn">Edit</a>
    <a href="delete_child.php?id=<?php echo $row['id']; ?>" class="action-btn delete-btn">Delete</a>
</td>
                </tr>
            <?php } ?>
        </table>

    </div>

</body>
</html>
