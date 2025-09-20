<?php
include('../includes/db_connect.php');

// Ensure the parent is logged in
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'parent') {
    header('Location: login.php');  // Redirect to login if not logged in as parent
    exit();
}

// Get the logged-in parent's ID
$parent_id = $_SESSION['user_id'];

// Fetch children only for this logged-in parent
$sql = "SELECT * FROM Children WHERE parent_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $parent_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<?php include('navbar.php'); ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Children</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
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
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        a {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 4px;
        }
        a:hover {
            background-color: #218838;
        }
        .form-footer {
            margin-top: 20px;
            text-align: center;
        }
        .add-child-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .add-child-btn:hover {
            background-color: #218838;
        }
        .btn-view {
            background-color: #007bff; /* Blue color for View Schedule */
        }
        .btn-view:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Manage Children</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Actions</th>
                    <th>View Schedule</th> <!-- Added new column -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['dob']); ?></td>
                        <td><?php echo htmlspecialchars($row['gender']); ?></td>
                        <td>
                            <a href="edit_child.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a href="delete_child.php?id=<?php echo $row['id']; ?>">Delete</a>
                        </td>
                        <td>
                            <a href="view_vaccination_schedule.php?child_id=<?php echo $row['id']; ?>" class="btn-view">View Schedule</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="form-footer">
            <a href="add_child.php" class="add-child-btn">Add New Child</a>
        </div>
    </div>

</body>
</html>
