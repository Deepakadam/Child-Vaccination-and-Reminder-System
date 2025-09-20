<?php
// Include the database connection file
include('../includes/db_connect.php');

// Fetch all users (excluding admin)
$sql = "SELECT id, name, email, phone, role FROM Users WHERE role != 'admin'";
$result = $conn->query($sql);

// Include the navbar file
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 80%;
            max-width: 800px; 
            margin: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            border-radius: 10px;
            box-shadow: none;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: rgba(13, 38, 65, 0.2);
            transition: background-color 0.3s ease-in-out;
        }

        a {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .actions a {
            background-color: #28a745;
        }

        .actions a:hover {
            background-color: #218838;
        }

        .no-data {
            text-align: center;
            font-size: 18px;
            color: #888;
        }

        .add-user-btn {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }

        .add-user-btn:hover {
            background-color: #218838;
        }

        .form-footer {
            margin-top: 20px;
            text-align: center;
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
        <h2>Manage Users</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <!-- <th>Role</th> -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <!-- <td><?php echo $row['role']; ?></td> -->
                            <td class="actions">
                                <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a>
                                <a href="delete_user.php?id=<?php echo $row['id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">No users found.</div>
        <?php endif; ?>

        <div class="form-footer">
            <a href="../register.php" class="add-user-btn">Add New User</a>
        </div>
    </div>

</body>
</html>
